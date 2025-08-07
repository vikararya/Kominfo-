<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Versi;
use App\Models\Cover;
use Illuminate\Validation\Rule;
use App\Models\Dokumentasi;

class VersiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $covers = Cover::all();

        // Tentukan cover default (ambil cover pertama atau spesifik tertentu)
        $defaultCover = $covers->first(); // atau Cover::find(id_tertentu)

        // Gunakan cover_id dari request jika ada, jika tidak gunakan default
        $coverId = $request->input('cover_id', $defaultCover->id ?? null);

        // Query versi
        $versis = Versi::with('cover')
            ->when($coverId, function ($query) use ($coverId) {
                return $query->where('cover_id', $coverId);
            })
            ->get();

        return view('versis.index', compact('versis', 'covers', 'coverId'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $covers = Cover::all();
        return view('versis.create', compact('covers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'cover_id' => 'required|exists:covers,id',
                'versi' => 'required|string|regex:/^\d+\.\d+\.\d+$/',
                'deskripsi' => 'required|string',

            ]);

            $versi = Versi::create([
                'versi' => $validated['versi'],
                'cover_id' => $validated['cover_id'],
                'deskripsi' => $validated['deskripsi'],
            ]);

            // Update cover dengan versi terbaru
            Cover::where('id', $validated['cover_id'])->update(['latest_version_id' => $versi->id]);

            return redirect()->route('versis.index')->with('success', 'Versi baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('versis.index')->with('error', 'Terjadi kesalahan! Mohon coba lagi.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $versi = Versi::with('cover')->findOrFail($id);
            $covers = Cover::all();

            return view('versis.edit', compact('versi', 'covers'));
        } catch (\Exception $e) {
            return redirect()->route('versis.index')
                ->with('error', 'Versi tidak ditemukan.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $versi = Versi::findOrFail($id);

            $validated = $request->validate([
                'versi' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^\d+\.\d+\.\d+$/',
                    Rule::unique('versis')
                        ->where('cover_id', $versi->cover_id)
                        ->ignore($versi->id)
                ],
                'deskripsi' => 'required|string',
            ], [
                'versi.regex' => 'Format versi harus X.X.X (contoh: 1.0.0)',
                'versi.unique' => 'Versi ini sudah ada untuk cover yang sama.'
            ]);

            // Update versi
            $versi->update(array_merge($validated, [
                'versi' => $validated['versi'],
                'deskripsi' => $validated['deskripsi'],

            ]));

            // Jika ini versi terbaru, update juga di cover
            if ($versi->cover->latest_version_id == $versi->id) {
                $versi->cover->update(['versi' => $validated['versi']]);
            }

            return redirect()->route('versis.index')
                ->with('success', 'Versi berhasil diperbarui.');

        } catch (\Exception $e) {
            return redirect()->route('versis.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
    /**
     * Get versions by cover ID.
     */
    public function getVersi($coverId)
    {
        $versions = Versi::where('cover_id', $coverId)
            ->select('id', 'versi as nama')
            ->get();

        return response()->json($versions);
    }

    /**
     * Duplicate a version along with its related documentation and subjuduls.
     */
    /**
     * Duplicate a version along with its related documentation and subjuduls.
     */
    public function duplicate($id)
    {
        try {
            // Ambil versi yang akan diduplikasi
            $originalVersi = Versi::findOrFail($id);

            // Duplikasi versi
            $newVersi = $originalVersi->replicate();
            $newVersi->versi = $this->generateNewVersionNumber($originalVersi->versi); // Generate versi baru
            $newVersi->save();

            // Duplikasi dokumentasi terkait
            $originalDokumentasis = Dokumentasi::where('versi_id', $originalVersi->id)->get();
            foreach ($originalDokumentasis as $originalDokumentasi) {
                // Buat salinan dokumentasi
                $newDokumentasi = $originalDokumentasi->replicate();
                $newDokumentasi->versi_id = $newVersi->id;
                $newDokumentasi->judul = $originalDokumentasi->judul . ' (Copy)'; // Tambahkan teks "(Copy)"
                $newDokumentasi->is_duplicate = true; // Tandai sebagai duplikat
                $newDokumentasi->save();

                // Duplikasi subjudul terkait
                $originalSubjuduls = $originalDokumentasi->subjudulList;
                foreach ($originalSubjuduls as $originalSubjudul) {
                    $newSubjudul = $originalSubjudul->replicate();
                    $newSubjudul->dokumentasi_id = $newDokumentasi->id;
                    $newSubjudul->save();
                }
            }

            return redirect()->route('versis.index')->with('success', 'Versi beserta dokumentasi dan subjudul berhasil diduplikasi.');
        } catch (\Exception $e) {
            return redirect()->route('versis.index')->with('error', 'Terjadi kesalahan saat menduplikasi: ' . $e->getMessage());
        }
    }

    /**
     * Generate a new version number based on the original version number.
     *
     * @param string $originalVersion
     * @return string
     */
    private function generateNewVersionNumber($originalVersion)
    {
        // Pisahkan versi menjadi bagian-bagian (misal: "1.0.0" menjadi [1, 0, 0])
        $parts = explode('.', $originalVersion);

        // Ambil bagian terakhir (patch version) dan tambahkan 1
        $lastPart = (int) end($parts);
        $lastPart++;

        // Ganti bagian terakhir dengan nilai yang baru
        $parts[count($parts) - 1] = $lastPart;

        // Gabungkan kembali menjadi string versi (misal: "1.0.1")
        $newVersion = implode('.', $parts);

        // Cek apakah versi ini sudah ada di database
        while (Versi::where('versi', $newVersion)->exists()) {
            // Jika sudah ada, tambahkan 1 ke bagian terakhir
            $lastPart++;
            $parts[count($parts) - 1] = $lastPart;
            $newVersion = implode('.', $parts);
        }

        return $newVersion;
    }
}
