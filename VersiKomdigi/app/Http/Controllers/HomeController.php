<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        // Query Cover dengan relasi versi terbaru
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
            ->get();

        return view('home.index', compact('covers', 'kategoris', 'kategoriId', 'search'));
    }

    public function show(Request $request, Cover $cover)
    {
        if ($cover->status !== 'publish') {
            abort(404);
        }

        // Ambil versi terurut dari terbaru
        $versis = $cover->versis()->orderBy('created_at', 'desc')->get();
        $latestVersi = $versis->first();
        $versiId = $request->get('versi_id', $latestVersi?->id);

        // Query dokumentasi
        $dokumentasisQuery = Dokumentasi::where('cover_id', $cover->id)
            ->where('status', 'publish')
            ->orderBy('order');

        // Di HomeController@show
        if ($versiId) {
            $dokumentasisQuery->where('versi_id', $versiId);
        } else {
            // Ambil versi terbaru jika $versiId tidak ada
            $latestVersi = $cover->versis()->latest()->first();
            $dokumentasisQuery->where('versi_id', $latestVersi?->id);
        }

        $dokumentasis = $dokumentasisQuery
            ->with(['subjudulList' => fn($query) => $query->where('status', 'publish')])
            ->get();

        // Increment views
        foreach ($dokumentasis as $dokumentasi) {
            $dokumentasi->increment('views');
        }


        return view('home.show', compact('cover', 'dokumentasis', 'versis', 'versiId', 'latestVersi'));
    }


}
