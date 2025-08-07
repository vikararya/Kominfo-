<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::all();
        return view('kategoris.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategoris.create');
    }

    public function store(Request $request)
    {
        // Validasi input dengan format PNG wajib untuk icon
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'icon' => 'required|image|mimes:png|max:3048', // Hanya menerima PNG dengan maksimal 2MB
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'deskripsi.required' => 'Deskripsi kategori tidak boleh kosong.',
            'icon.required' => 'Icon kategori wajib diunggah.',
            'icon.image' => 'File icon harus berupa gambar.',
            'icon.mimes' => 'Icon harus berformat PNG.',
            'icon.max' => 'Ukuran icon tidak boleh lebih dari 3MB.',
        ]);

        try {
            // Upload file icon
            $imagePath = $request->file('icon')->store('kategoris/', 'public');

            // Simpan data kategori
            Kategori::create([
                'name' => $validated['name'],
                'deskripsi' => $validated['deskripsi'],
                'icon' => $imagePath,
            ]);

            return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan kategori: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        return view('kategoris.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        return view('kategoris.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Kategori $kategori)
    {
        // Validasi input dengan format PNG wajib jika ada icon baru
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'icon' => 'nullable|image|mimes:png|max:3048', // Hanya menerima PNG dengan maksimal 2MB jika ada file baru
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'deskripsi.required' => 'Deskripsi kategori tidak boleh kosong.',
            'icon.image' => 'File icon harus berupa gambar.',
            'icon.mimes' => 'Icon harus berformat PNG.',
            'icon.max' => 'Ukuran icon tidak boleh lebih dari 3MB.',
        ]);

        try {
            // Jika ada file icon baru, upload dan ganti icon lama
            if ($request->hasFile('icon')) {
                $imagePath = $request->file('icon')->store('kategoris/', 'public');
                $kategori->icon = $imagePath;
            }

            // Update data kategori
            $kategori->update([
                'name' => $validated['name'],
                'deskripsi' => $validated['deskripsi'],
                'icon' => $kategori->icon, // Jika tidak ada icon baru, gunakan yang lama
            ]);

            return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui kategori: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->icon && Storage::disk('public')->exists($kategori->icon)) {
            Storage::disk('public')->delete($kategori->icon);
        }

        $kategori->delete();

        return redirect()->route('kategoris.index')->with('success', 'Kategori deleted successfully.');
    }
}
