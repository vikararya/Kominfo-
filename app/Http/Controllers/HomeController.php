<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Cover;
use App\Models\Dokumentasi;
use App\Models\Kategori;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kategori untuk dropdown filter
        $kategoris = Kategori::all();

        // Ambil parameter kategori & search dari request
        $kategoriId = $request->get('kategori');
        $search = $request->get('search');

        // Query Cover dengan relasi versi terbaru, hanya ambil maksimal 6 data
        $covers = Cover::with([
            'versis' => function ($query) {
                $query->latest()->limit(1); // Ambil hanya versi terbaru
            }
        ])
            ->where('status', 'publish')
            ->when($kategoriId, function ($query) use ($kategoriId) {
                return $query->where('kategori_id', $kategoriId);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->latest() // Urutkan dari terbaru
            ->take(6)  // Ambil hanya 6 data
            ->get();

        return \view('home.index', compact('covers', 'kategoris', 'kategoriId', 'search'));
    }


    // public function show(Request $request, Cover $cover)
    // {
    //     if ($cover->status !== 'publish') {
    //         abort(404);
    //     }

    //     // Ambil versi terurut dari terbaru
    //     $versis = $cover->versis()->orderBy('created_at', 'desc')->get();
    //     $latestVersi = $versis->first();
    //     $versiId = $request->get('versi_id', $latestVersi?->id);

    //     $dokumentasisQuery = Dokumentasi::where(function ($query) use ($cover) {
    //         $query->where('cover_id', $cover->id)
    //             ->orWhereNull('cover_id'); // Ambil dokumentasi yang tidak memiliki cover_id juga
    //     })
    //         ->where('status', 'publish')
    //         ->where('versi_id', $versiId) // Tetap filter berdasarkan versi
    //         ->orderBy('order');

    //     // Di HomeController@show
    //     if ($versiId) {
    //         $dokumentasisQuery->where('versi_id', $versiId);
    //     } else {
    //         // Ambil versi terbaru jika $versiId tidak ada
    //         $latestVersi = $cover->versis()->latest()->first();
    //         $dokumentasisQuery->where('versi_id', $latestVersi?->id);
    //     }

    //     $dokumentasis = $dokumentasisQuery
    //         ->with(['subjudulList' => fn($query) => $query->where('status', 'publish')])
    //         ->get();

    //     // Increment views
    //     foreach ($dokumentasis as $dokumentasi) {
    //         $dokumentasi->increment('views');
    //     }


    //     return view('home.show', compact('cover', 'dokumentasis', 'versis', 'versiId', 'latestVersi'));
    // }

    // public function show(Request $request, Cover $cover)
    // {
    //     // Check if cover is published
    //     if ($cover->status !== 'publish') {
    //         abort(404);
    //     }

    //     // Get all versions ordered by latest first
    //     $versis = $cover->versis()
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     // Get selected version ID from request or use latest
    //     $versiId = $request->get('versi_id', $versis->first()?->id);

    //     // Get the actual selected version model
    //     $selectedVersi = $versiId ? $versis->firstWhere('id', $versiId) : $versis->first();

    //     // Query for documentation
    //     $dokumentasis = Dokumentasi::where(function ($query) use ($cover) {
    //         $query->where('cover_id', $cover->id)
    //             ->orWhereNull('cover_id');
    //     })
    //         ->where('status', 'publish')
    //         ->where('versi_id', $selectedVersi?->id)
    //         ->orderBy('order')
    //         ->with(['subjudulList' => fn($query) => $query->where('status', 'publish')])
    //         ->get();

    //     // Increment views for each documentation
    //     $dokumentasis->each->increment('views');

    //     return view('home.show', [
    //         'cover' => $cover,
    //         'dokumentasis' => $dokumentasis,
    //         'versis' => $versis,
    //         'versiId' => $versiId,
    //         'selectedVersi' => $selectedVersi
    //     ]);
    // }

    public function show(Request $request, Cover $cover)
    {
        // Check if cover is published
        if ($cover->status !== 'publish') {
            abort(404);
        }

        // Get all versions ordered by latest first
        $versis = $cover->versis()
            ->orderBy('created_at', 'desc')
            ->get();

        // Get selected version ID from request or use latest
        $versiId = $request->get('versi_id', $versis->first()?->id);

        // Get the actual selected version model
        $selectedVersi = $versiId ? $versis->firstWhere('id', $versiId) : $versis->first();

        // Coba ambil dokumentasi asli (bukan duplikat)
        $dokumentasis = Dokumentasi::where(function ($query) use ($cover) {
            $query->where('cover_id', $cover->id)
                ->orWhereNull('cover_id');
        })
            ->where('status', 'publish')
            ->where('versi_id', $selectedVersi?->id)
            ->where('is_duplicate', false)
            ->orderBy('order')
            ->with(['subjudulList' => fn($query) => $query->where('status', 'publish')])
            ->get();

        // Jika dokumentasi asli tidak ada, fallback ke duplikat
        if ($dokumentasis->isEmpty()) {
            $dokumentasis = Dokumentasi::where(function ($query) use ($cover) {
                $query->where('cover_id', $cover->id)
                    ->orWhereNull('cover_id');
            })
                ->where('status', 'publish')
                ->where('versi_id', $selectedVersi?->id)
                ->where('is_duplicate', true)
                ->orderBy('order')
                ->with(['subjudulList' => fn($query) => $query->where('status', 'publish')])
                ->get();
        }

        // Increment views
        $dokumentasis->each->increment('views');

        return view('home.show', [
            'cover' => $cover,
            'dokumentasis' => $dokumentasis,
            'versis' => $versis,
            'versiId' => $versiId,
            'selectedVersi' => $selectedVersi
        ]);
    }



    public function allCovers(Request $request)
    {
        // Ambil semua kategori untuk filter
        $kategoris = Kategori::all();

        // Ambil parameter kategori & search dari request
        $kategoriId = $request->get('kategori');
        $search = $request->get('search');

        // Query Cover dengan relasi versi terbaru
        $covers = Cover::with([
            'versis' => function ($query) {
                $query->latest()->limit(1);
            }
        ])
            ->where('status', 'publish')
            ->when($kategoriId, function ($query) use ($kategoriId) {
                return $query->where('kategori_id', $kategoriId);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(12); // Menampilkan 12 cover per halaman

        return view('home.all', compact('covers', 'kategoris', 'kategoriId', 'search'));
    }


}
