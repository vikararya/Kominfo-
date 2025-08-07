<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumentasi;
use App\Models\Doksub;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DoksubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dokumentasis = Dokumentasi::with('versis')->get();

        $dokumentasiId = $request->get('dokumentasi_id');
        $versiId = $request->get('versi_id');

        $query = Doksub::with('dokumentasi');

        // Filter berdasarkan Dokumentasi
        if ($dokumentasiId) {
            $query->where('dokumentasi_id', $dokumentasiId);
        }

        // Filter berdasarkan Versi
        if ($versiId) {
            $query->whereHas('dokumentasi', function ($q) use ($versiId) {
                $q->whereHas('versis', function ($q) use ($versiId) {
                    $q->where('id', $versiId);
                });
            });
        }

        $doksubs = $query->latest()->get();

        return view('subjudul.index', compact('dokumentasis', 'doksubs', 'dokumentasiId', 'versiId'));
    }


    // public function create(Request $request)
    // {
    //     $dokumentasis = Dokumentasi::all();
    //     $dokumentasiId = $request->query('dokumentasi_id');
    //     $versiId = $request->query('versi_id');

    //     return view('subjudul.create', compact('dokumentasis', 'dokumentasiId', 'versiId'));
    // }

    public function create(Request $request)
    {
        $dokumentasis = Dokumentasi::whereNull('deskripsi')->orWhere('deskripsi', '')->get();
        $dokumentasiId = $request->query('dokumentasi_id');
        $versiId = $request->query('versi_id');

        return view('subjudul.create', compact('dokumentasis', 'dokumentasiId', 'versiId'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subjudul' => 'required|string|max:255',
            'dokumentasi_id' => 'required|exists:dokumentasis,id',
            'deskripsi' => 'required|string',
            'status' => 'required|in:draft,publish',
        ]);

        Doksub::create([
            'subjudul' => $validated['subjudul'],
            'dokumentasi_id' => $validated['dokumentasi_id'],
            'deskripsi' => $validated['deskripsi'],
            'status' => $validated['status'] ?? null,
        ]);

        return redirect()->route('subjudul.index', [
            'dokumentasi_id' => $validated['dokumentasi_id'],
        ])->with('success', 'Dokumentasi created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doksub $doksub)
    {
        return view('subjudul.show', compact('doksub'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Doksub $subjudul)
    // {
    //     $dokumentasis = Dokumentasi::all();
    //     return view('subjudul.edit', compact('dokumentasis', 'subjudul'));
    // }

    public function edit(Doksub $subjudul)
    {
        $dokumentasis = Dokumentasi::whereNull('deskripsi')->orWhere('deskripsi', '')->get();
        return view('subjudul.edit', compact('dokumentasis', 'subjudul'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doksub $subjudul)
    {
        $validated = $request->validate([
            'subjudul' => 'required|string|max:255',
            'dokumentasi_id' => 'required|exists:dokumentasis,id',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:draft,publish',
        ]);

        $subjudul->update(array_merge($validated, [
            'subjudul' => $validated['subjudul'],
            'dokumentasi_id' => $validated['dokumentasi_id'],
            'deskripsi' => $validated['deskripsi'],
            'status' => $validated['status'] ?? null,
        ]));

        return redirect()->route('subjudul.index', [
            'dokumentasi_id' => $validated['dokumentasi_id'],
        ])->with('success', 'Dokumentasi updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doksub $doksub)
    {
        $doksub->delete();
        return redirect()->route('subjudul.index')->with('success', 'Dokumentasi deleted successfully.');
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
