<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $totalLokasi = Lokasi::count();
        $totalBelum = Lokasi::where('status', 'belum')->count();
        $totalSiap = Lokasi::where('status', 'siap')->count();
        $totalGenerated = Lokasi::where('status', 'generated')->count();

        $approved = 0;
        $rejected = 0;
        $draft = 0;
        $chartLabels = [];
        $chartData = [];
        $recentApprovals = collect();
        $myPendingApprovals = collect();
        $myProjects = collect();

        return view('dashboard.index', compact(
            'totalLokasi',
            'totalBelum',
            'totalSiap',
            'totalGenerated',
            'approved',
            'rejected',
            'draft',
            'chartLabels',
            'chartData',
            'recentApprovals',
            'myPendingApprovals',
            'myProjects'
        ));
    }
}
