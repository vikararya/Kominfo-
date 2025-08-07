<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use App\Models\Cover;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total counts
        $totalCovers = Cover::count();
        $totalViews = Dokumentasi::sum('views');
        $totalPublished = Cover::where('status', 'publish')->count();
        $totalDraft = Cover::where('status', 'draft')->count();

        // Get top viewed covers (only those with views)
        $topCovers = Cover::withCount([
            'dokumentasis as total_views' => function ($query) {
                $query->select(DB::raw('COALESCE(SUM(views), 0)'));
            }
        ])
            ->having('total_views', '>', 0)
            ->orderBy('total_views', 'desc')
            ->take(5)
            ->get();

        // Prepare data for pie chart
        $coverLabels = $topCovers->pluck('name')->toArray();
        $coverViews = $topCovers->pluck('total_views')->toArray();

        // Dynamic color palette
        $colorPalette = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'];
        $coverColors = array_slice($colorPalette, 0, count($coverLabels));

        // Monthly views data for bar chart
        $viewsPerMonth = Dokumentasi::selectRaw("MONTH(created_at) as month, SUM(views) as total_views")
            ->whereYear('created_at', now()->year)
            ->groupByRaw("MONTH(created_at)")
            ->pluck('total_views', 'month')
            ->toArray();

        $months = [];
        $monthlyViews = [];

        for ($m = 1; $m <= 12; $m++) {
            $months[] = Carbon::create()->month($m)->format('F');
            $monthlyViews[] = $viewsPerMonth[$m] ?? 0;
        }

        return view('dashboard', compact(
            'totalViews',
            'totalCovers',
            'totalPublished',
            'totalDraft',
            'months',
            'monthlyViews',
            'coverLabels',
            'coverViews',
            'coverColors'
        ));
    }
}