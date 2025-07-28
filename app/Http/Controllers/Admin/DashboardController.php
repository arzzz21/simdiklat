<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Iht;
use App\Models\Pelatihan;
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
            return Pengajuan::where('created_at', 'like', "$bln%")->count();
        });

        $dataPelatihan = $bulan->map(function ($bln) {
            return Pelatihan::where('created_at', 'like', "$bln%")->count();
        });

        $dataIht = $bulan->map(function ($bln) {
            return Iht::where('created_at', 'like', "$bln%")->count();
        });
        // print_r($dataMagang);
        // die();
        return view('admin.dashboard', [
            'bulan' => $bulan->map(fn($b) => Carbon::createFromFormat('Y-m', $b)->translatedFormat('F Y'))->values()->all(),
            'dataMagang' => $dataMagang->values()->all(),
            'dataPelatihan' => $dataPelatihan->values()->all(),
            'dataIht' => $dataIht->values()->all(),
            'totalMagang' => Pengajuan::count(),
            'totalPelatihan' => Pelatihan::count(),
            'totalIht' => Iht::count(),
        ]);
    }

}
