<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cover;
use App\Models\Versi;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CoverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $covers = Cover::with([
            'versis' => function ($query) {
                $query->latest()->take(1); // Ambil versi terbaru
            }
        ])->latest()->get(); // Urutkan berdasarkan yang terbaru


        return view('covers.index', compact('covers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('covers.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:225|unique:covers,name',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'kategori_id' => 'required|exists:kategoris,id',
            'versi' => 'required|string',
            'content' => 'required|string',
            'status' => 'nullable|in:draft,publish',
        ]);

        try {
            // Simpan file gambar dan logo
            $imagePath = $request->file('image')->store('covers/images', 'public');
            $logoPath = $request->file('logo')->store('covers/logos', 'public');

            // Simpan data ke database
            $cover = Cover::create(array_merge($validated, [
                'name' => $validated['name'],
                'image' => $imagePath,
                'logo' => $logoPath,
                'kategori_id' => $validated['kategori_id'],
                'versi' => $validated['versi'],
                'content' => $validated['content'],
                'status' => $validated['status'] ?? null,
                'author' => Auth::user()->name,
            ]));

            // Simpan versi dengan deskripsi default
            $versi = Versi::create([
                'cover_id' => $cover->id,
                'versi' => $validated['versi'],
                'deskripsi' => 'Versi pertama', // Deskripsi default
            ]);

            // Update cover dengan versi terbaru
            $cover->update(['versi' => $versi->versi]);

            return redirect()->route('covers.index')->with('success', 'Cover berhasil dibuat.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $cover = Cover::with([
            'versis' => function ($query) {
                $query->latest()->take(1);
            }
        ])->findOrFail($id);

        return view('covers.show', compact('cover'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cover $cover)
    {
        $kategoris = Kategori::all();
        return view('covers.edit', compact('cover', 'kategoris'));
    }
    public function update(Request $request, Cover $cover)
    {
        // Validasi input dengan pesan yang lebih jelas
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kategori_id' => 'required|exists:kategoris,id',
            'content' => 'required|string',
            'edited' => 'nullable|string|max:255',
            'status' => 'nullable|in:draft,publish',
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'image.image' => 'File gambar harus berupa format jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'logo.image' => 'File logo harus berupa format jpg, jpeg, atau png.',
            'logo.max' => 'Ukuran logo tidak boleh lebih dari 2MB.',
            'kategori_id.required' => 'Kategori harus dipilih.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'content.required' => 'Konten tidak boleh kosong.',
        ]);

        try {
            // Cek apakah ada file gambar baru yang diunggah
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('covers/images', 'public');
                $cover->image = $imagePath;
            }

            // Cek apakah ada file logo baru yang diunggah
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('covers/logos', 'public');
                $cover->logo = $logoPath;
            }

            // Update data
            $cover->update(array_merge($validated, [
                'image' => $cover->image,
                'logo' => $cover->logo,
                'status' => $validated['status'] ?? $cover->status,
                'edited' => $request->edited_by ?? Auth::user()->name, // Bisa diketik, default ke user login
            ]));

            return redirect()->route('covers.index')->with('success', 'Cover berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui cover: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cover $cover)
    {
        if ($cover->image && Storage::disk('public')->exists($cover->image)) {
            Storage::disk('public')->delete($cover->image);
        }

        if ($cover->logo && Storage::disk('public')->exists($cover->logo)) {
            Storage::disk('public')->delete($cover->logo);
        }

        $cover->delete();

        return redirect()->route('covers.index')->with('success', 'Cover deleted successfully.');
    }
}
