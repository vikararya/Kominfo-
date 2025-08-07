<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dokumentasi;
use App\Models\Cover;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCovers = Cover::count(); // Menghitung jumlah semua Cover
        $totalViews = Dokumentasi::sum('views');
        $totalPublished = Cover::where('status', 'publish')->count(); // Cover dengan status 'publish'
        $totalDraft = Cover::where('status', 'draft')->count(); // Cover dengan status 'draft'
        $topDokumentasis = Dokumentasi::orderBy('views', 'desc')->take(5)->get();

        return view('dashboard', compact('totalViews', 'topDokumentasis', 'totalCovers', 'totalPublished', 'totalDraft'));
    }
}
