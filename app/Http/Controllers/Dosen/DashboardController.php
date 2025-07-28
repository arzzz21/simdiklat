<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data per bulan (6 bulan terakhir)
        $bulan = collect(range(0, 5))->map(function ($i) {
            return now()->subMonths($i)->format('Y-m');
        })->reverse();

        $dataMagang = $bulan->map(function ($bln) {
            return Pengajuan::where('user_id', Auth::id())->where('created_at', 'like', "$bln%")->count();
        });

        // print_r($dataMagang);
        // die();
        return view('dosen.dashboard', [
            'bulan' => $bulan->map(fn($b) => Carbon::createFromFormat('Y-m', $b)->translatedFormat('F Y'))->values()->all(),
            'dataMagang' => $dataMagang->values()->all(),
            'totalMagang' => Pengajuan::where('user_id', Auth::id())->count(),
        ]);
    }
}
