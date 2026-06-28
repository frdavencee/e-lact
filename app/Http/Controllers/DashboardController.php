<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Personel;
use App\Models\Branch;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalLokasi    = Lokasi::count();
        $totalPersonel  = Personel::count();
        $totalBranch    = Branch::count();
        $totalGenerated = Lokasi::where('status', 'generated')->count();

        return view('dashboard.index', compact(
            'totalLokasi',
            'totalPersonel',
            'totalBranch',
            'totalGenerated'
        ));
    }
}
