<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumentasi;
use App\Models\Cover;
use App\Models\Versi;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumentasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil semua cover
        $covers = Cover::all();

        // Tentukan cover default (ambil cover pertama atau spesifik tertentu)
        $defaultCover = $covers->first(); // atau Cover::find(id_tertentu)

        // Gunakan cover_id dari request jika ada, jika tidak gunakan default
        $coverId = $request->query('cover_id', $defaultCover->id ?? null);

        // Query untuk dokumentasi asli
        $dokumentasiAsli = Dokumentasi::when($coverId, function ($query) use ($coverId) {
            $query->where('cover_id', $coverId);
        })
            ->where('is_duplicate', false)
            ->with([
                'cover',
                'versis' => function ($query) {
                    $query->latest()->take(1);
                },
                'subjudulList'
            ])
            ->orderBy('order')
            ->latest()
            ->get();

        // Query untuk dokumentasi duplikat
        $dokumentasiDuplikat = Dokumentasi::when($coverId, function ($query) use ($coverId) {
            $query->where('cover_id', $coverId);
        })
            ->where('is_duplicate', true)
            ->with([
                'cover',
                'versis' => function ($query) {
                    $query->latest()->take(1);
                },
                'subjudulList'
            ])
            ->orderBy('order')
            ->latest()
            ->get();

        return view('dokumentasis.index', compact(
            'dokumentasiAsli',
            'dokumentasiDuplikat',
            'covers',
            'coverId'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $covers = Cover::all();
        $versis = Versi::all(); // Pastikan ini ada
        return view('dokumentasis.create', compact('covers', 'versis'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'cover_id' => 'required|exists:covers,id',
            'deskripsi' => 'nullable|string',
            'versi_id' => 'required|exists:versis,id',
            'status' => 'required|in:draft,publish',
            'order' => [
                'required',
                'integer',
                Rule::unique('dokumentasis')->where('cover_id', $request->cover_id)
            ],
        ]);

        Dokumentasi::create(array_merge($validated, [
            'judul' => $validated['judul'],
            'status' => $validated['status'] ?? null,
            'versi_id' => $validated['versi_id'],
            'order' => $validated['order']
        ]));

        return redirect()->route('dokumentasis.index', ['cover_id' => $validated['cover_id']])
            ->with('success', 'Dokumentasi created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        $versis = $dokumentasi->versis()->orderBy('created_at', 'desc')->get();
        $latestVersi = $versis->first();
        $versiId = $request->query('versi_id', $latestVersi ? $latestVersi->id : null);
        $selectedVersi = $versis->firstWhere('id', $versiId);

        // Selalu ambil dokumentasi terkait (asli dan duplikat) jika ada cover_id
        if ($dokumentasi->cover_id) {
            $relatedDokumentasis = Dokumentasi::where('cover_id', $dokumentasi->cover_id)
                ->with(['versis', 'subjudulList'])
                ->orderBy('order')
                ->get();

            $originalDokumentasis = $relatedDokumentasis->where('is_duplicate', false);
            $duplicateDokumentasis = $relatedDokumentasis->where('is_duplicate', true);
        } else {
            // Jika tidak ada cover_id, anggap sebagai dokumentasi tunggal
            $originalDokumentasis = collect([$dokumentasi]);
            $duplicateDokumentasis = collect();
        }

        // Hapus pengecekan AJAX jika tidak diperlukan
        return view('dokumentasis.show', compact(
            'dokumentasi',
            'versis',
            'latestVersi',
            'versiId',
            'selectedVersi',
            'originalDokumentasis',
            'duplicateDokumentasis'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokumentasi $dokumentasi)
    {
        $covers = Cover::all();
        return view('dokumentasis.edit', compact('dokumentasi', 'covers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokumentasi $dokumentasi)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'image' => 'nullable|image',
            'cover_id' => 'required|exists:covers,id',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:draft,publish',
            'order' => [
                'required',
                'integer',
                Rule::unique('dokumentasis')->where(fn($query) => $query->where('cover_id', $request->cover_id))
                    ->ignore($dokumentasi->id)
            ],
        ]);

        $dokumentasi->update(array_merge($validated, [
            'judul' => $validated['judul'],
            'cover_id' => $validated['cover_id'],
            'status' => $validated['status'],
            'order' => $validated['order']
        ]));

        return redirect()->route('dokumentasis.index', ['cover_id' => $validated['cover_id']])
            ->with('success', 'Dokumentasi edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokumentasi $dokumentasi)
    {
        // Hapus gambar dari storage jika ada
        if ($dokumentasi->image && Storage::disk('public')->exists($dokumentasi->image)) {
            Storage::disk('public')->delete($dokumentasi->image);
        }

        // Hapus record dari database
        $dokumentasi->delete();

        return redirect()->route('dokumentasis.index')->with('success', 'Dokumentasi deleted successfully.');

    }

    public function swapOrder(Request $request, $id)
    {
        $dokumentasi1 = Dokumentasi::findOrFail($id);
        $dokumentasi2 = Dokumentasi::where('cover_id', $dokumentasi1->cover_id)
            ->where('order', $request->new_order)
            ->first();

        if ($dokumentasi2) {
            // Tukar posisi order dalam satu cover
            $tempOrder = $dokumentasi1->order;
            $dokumentasi1->order = $dokumentasi2->order;
            $dokumentasi2->order = $tempOrder;

            // Simpan perubahan
            $dokumentasi1->save();
            $dokumentasi2->save();

            return redirect()->back()->with('success', 'Urutan berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal menukar urutan.');
    }

    public function getVersions($coverId)
    {
        $versions = Versi::where('cover_id', $coverId)->orderBy('created_at', 'desc')->get();

        return response()->json($versions);
    }


    public function uploadImage(Request $request)
    {
        try {
            // Validasi file
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Simpan file ke direktori public/images
            $imageName = time() . '.' . $request->file->extension();
            $request->file->move(public_path('images'), $imageName);

            // Kembalikan URL gambar
            return response()->json([
                'url' => asset('images/' . $imageName), // Pastikan ini mengembalikan URL lengkap
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
