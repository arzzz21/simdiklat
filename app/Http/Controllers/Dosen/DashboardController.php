<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function indexDosen()
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

        // print_r($dataMagang);
        // die();
        return view('dosen.dashboard', [
            'bulan' => $bulanFormatted,
            'dataMagang' => $dataMagang->values()->all(),
            'totalMagang' => Pengajuan::where('user_id', Auth::id())->count(),
        ]);
    }
}
