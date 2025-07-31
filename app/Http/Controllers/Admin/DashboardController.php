<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Iht;
use App\Models\Pelatihan;
use Illuminate\Support\Carbon;
use Carbon\CarbonImmutable;

class DashboardController extends Controller
{
    public function indexAdmin()
    {
        $bulanUnique = [];
        $bulanFormatted = [];

        // Ambil tanggal 5 bulan yang lalu dari hari ini
        $date = Carbon::now()->subMonths(5)->startOfMonth();

        // Loop sebanyak 6 kali untuk mendapatkan 6 bulan (Juli sampai Februari)
        for ($i = 0; $i < 6; $i++) {
            $bulanUnique[] = $date->format('Y-m');
            $bulanFormatted[] = $date->translatedFormat('F Y');
            $date->addMonth();
        }

        // Ambil data dari database
        $dataMagang = collect($bulanUnique)->map(function ($bln) {
            return Pengajuan::where('created_at', 'like', "$bln%")->count();
        });

        $dataPelatihan = collect($bulanUnique)->map(function ($bln) {
            return Pelatihan::where('created_at', 'like', "$bln%")->count();
        });

        $dataIht = collect($bulanUnique)->map(function ($bln) {
            return Iht::where('created_at', 'like', "$bln%")->count();
        });

        return view('admin.dashboard', [
            'bulan' => $bulanFormatted,
            'dataMagang' => $dataMagang->values()->all(),
            'dataPelatihan' => $dataPelatihan->values()->all(),
            'dataIht' => $dataIht->values()->all(),
            'totalMagang' => Pengajuan::count(),
            'totalPelatihan' => Pelatihan::count(),
            'totalIht' => Iht::count(),
        ]);
    }

}
