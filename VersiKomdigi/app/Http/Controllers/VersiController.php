<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Versi;
use App\Models\Cover;
use App\Models\Dokumentasi;

class VersiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request->query('type', 'covers'); // Default adalah 'covers'

        $covers = Cover::all();
        $dokumentasis = Dokumentasi::all();

        $query = Versi::query();

        // Filter berdasarkan type
        if ($type === 'covers') {
            $query->whereNotNull('cover_id'); // Hanya tampilkan versi yang memiliki cover
        } elseif ($type === 'dokumentasis') {
            $query->whereNotNull('dokumentasi_id'); // Hanya tampilkan versi yang memiliki dokumentasi
        }

        // Filter tambahan berdasarkan cover_id atau dokumentasi_id
        if ($request->has('cover_id') && $request->get('cover_id') != '') {
            $query->where('cover_id', $request->get('cover_id'));
        }

        if ($request->has('dokumentasi_id') && $request->get('dokumentasi_id') != '') {
            $query->where('dokumentasi_id', $request->get('dokumentasi_id'));
        }

        $versis = $query->with(['cover', 'dokumentasi'])->get();

        return view('versis.index', compact('versis', 'covers', 'dokumentasis', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->query('type', 'covers'); // Default 'covers'
        $covers = Cover::all();
        $versiCovers = collect(); // Inisialisasi dengan koleksi kosong untuk menghindari error

        if ($type === 'covers') {
            return view('versis.create', compact('type', 'covers', 'versiCovers'));
        }

        if ($type === 'dokumentasis') {
            $dokumentasis = Dokumentasi::with('cover')->get(); // Ambil semua dokumentasi beserta cover terkait
            $versiCovers = Versi::whereNotNull('cover_id')->get(); // Ambil versi cover yang tersedia
            return view('versis.create', compact('type', 'dokumentasis', 'covers', 'versiCovers'));
        }

        abort(404); // Jika type tidak valid, kembalikan 404
    }



    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'versi' => 'required|integer',
    //         'cover_id' => 'required|exists:covers,id',
    //         'dokumentasi_id' => 'required|exists:dokumentasis,id',
    //     ]);

    //     $versi = Versi::create([
    //         'versi' => $validated['versi'], // Ambil data dari hasil validasi
    //         'cover_id' => $validated['cover_id'],
    //         'dokumentasi_id' => $validated['dokumentasi_id'],
    //     ]);

    //     // Update kolom versi_id di tabel covers
    //     $cover = Cover::find($validated['cover_id']);
    //     $cover->versi_id = $versi->id; // Hubungkan versi dengan cover
    //     $cover->save();

    //     // Update kolom versi_id di tabel dokumentasis
    //     $dokumentasi = Dokumentasi::find($validated['dokumentasi_id']);
    //     $dokumentasi->versi_id = $versi->id; // Hubungkan versi dengan dokumentasi
    //     $dokumentasi->save();



    //     return redirect()->route('versis.index')->with('success', 'Versi created successfully.');
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        try {
            $type = $request->input('type', 'covers');

            if ($type === 'covers') {
                $validated = $request->validate([
                    'cover_id' => 'required|exists:covers,id',
                    'versi' => 'required|string|regex:/^\d+\.\d+\.\d+$/',
                ]);

                $versi = Versi::create([
                    'versi' => $validated['versi'],
                    'cover_id' => $validated['cover_id'],
                    'dokumentasi_id' => null,
                ]);

                Cover::where('id', $validated['cover_id'])->update(['versi_id' => $versi->id]);

                return redirect()->route('versis.index')->with('success', 'Cover berhasil ditambahkan.');
            }

            if ($type === 'dokumentasis') {
                $validated = $request->validate([
                    'dokumentasi_id' => 'required|exists:dokumentasis,id',
                    'versi_cover_id' => 'required|exists:versis,id', // ID versi cover yang dipilih
                ]);

                // Ambil data versi cover yang dipilih
                $versiCover = Versi::findOrFail($validated['versi_cover_id']);

                // Buat versi baru untuk dokumentasi dengan versi yang sama
                $versiDokumentasi = Versi::create([
                    'versi' => $versiCover->versi,
                    'dokumentasi_id' => $validated['dokumentasi_id'],
                    'cover_id' => null,
                ]);

                // Update dokumentasi dengan versi_id yang baru dibuat
                $dokumentasi = Dokumentasi::find($validated['dokumentasi_id']);
                $dokumentasi->versi_id = $versiDokumentasi->id;
                $dokumentasi->save();

                return redirect()->route('versis.index')->with('success', 'Dokumentasi berhasil ditambahkan.');
            }

            return redirect()->route('versis.index')->with('error', 'Tipe data tidak valid.');
        } catch (\Exception $e) {
            return redirect()->route('versis.index')->with('error', 'Terjadi kesalahan! Mohon coba lagi.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Versi $versi)
    {
        return view('versis.show', compact('versi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Controller
    public function edit($id)
    {
        $versi = Versi::findOrFail($id);
        $type = request('type', $versi->dokumentasi_id ? 'dokumentasis' : 'covers');
        $covers = Cover::all();
        $dokumentasis = Dokumentasi::with('cover')->get();

        // Ambil hanya versi yang sesuai dengan cover yang dipilih
        $filteredVersiCovers = Versi::where('cover_id', $versi->cover_id)->get();

        return view('versis.edit', compact('type', 'versi', 'covers', 'filteredVersiCovers', 'dokumentasis'));
    }

    public function update(Request $request, $id)
    {
        try {
            $type = $request->input('type', 'covers');
            $versi = Versi::findOrFail($id);

            if ($type === 'covers') {
                $validated = $request->validate([
                    'versi' => 'required|string|max:255',
                ]);

                $versi->update([
                    'versi' => $validated['versi'],
                ]);
            }

            if ($type === 'dokumentasis') {
                $validated = $request->validate([
                    'versi_cover_id' => 'required|exists:versis,id',
                ]);

                // Ambil data versi berdasarkan `versi_cover_id`
                $versiCover = Versi::findOrFail($validated['versi_cover_id']);

                // Update versi dari versi yang dipilih
                $versi->update([
                    'versi' => $versiCover->versi,
                ]);
            }

            return redirect()->route('versis.index')->with('success', 'Versi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('versis.index')->with('error', 'Terjadi kesalahan! Mohon coba lagi.');
        }
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Versi $versi)
    {
        $versi->delete();
        return redirect()->route('versis.index')->with('success', 'Versi deleted successfully.');
    }

    public function duplicate($id)
    {
        try {
            // Cari versi yang akan diduplikasi
            $originalVersi = Versi::findOrFail($id);

            // Buat duplikasi versi
            $newVersi = $originalVersi->replicate(); // Replicate membuat salinan tanpa menyimpan ke database
            $newVersi->versi = $originalVersi->versi . ' (Copy)'; // Tambahkan keterangan agar terlihat sebagai duplikat
            $newVersi->save(); // Simpan ke database

            return redirect()->route('versis.index')->with('success', 'Versi berhasil diduplikasi.');
        } catch (\Exception $e) {
            return redirect()->route('versis.index')->with('error', 'Terjadi kesalahan saat menduplikasi versi.');
        }
    }

    // VersiController.php
    public function getVersi($coverId)
    {
        // Ambil data versi berdasarkan cover_id
        $versions = Versi::where('cover_id', $coverId)
            ->select('id', 'versi as nama') // Sesuaikan 'versi' dengan nama kolom di database
            ->get();

        return response()->json($versions);
    }

}
