<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pengajuan;
use App\Models\Pelatihan;
use App\Models\Iht;

class LaporanController extends Controller
{
    public function magang(Request $request)
    {
        $query = Pengajuan::with('jenisProgram', 'user.kampus');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('created_at', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $data = $query->latest()->get();

        return view('admin.laporan.magang', compact('data'));
    }

    public function exportMagang(Request $request)
    {
        $query = Pengajuan::with('jenisProgram', 'user.kampus');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('created_at', [$request->tanggal_mulai, $request->tanggal_selesai]);
        }

        $data = $query->get();

        $pdf = Pdf::loadView('admin.laporan.export_magang', compact('data'));
        return $pdf->download('laporan-magang.pdf');
    }
    public function pelatihan(Request $request)
    {
        $query = Pelatihan::with('peserta');
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_mulai', [$request->start_date, $request->end_date]);
        }
        $data = $query->latest()->get();
        // print_r($data);
        // die();

        return view('admin.laporan.pelatihan', compact('data'));
    }

    public function exportPelatihan(Request $request)
    {
        $query = Pelatihan::with('pesertas.pegawai');
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_mulai', [$request->start_date, $request->end_date]);
        }

        $data = $query->latest()->get();

        $pdf = Pdf::loadView('admin.laporan.export_pelatihan', compact('data'))->setPaper('A4', 'landscape');

        return $pdf->download('laporan-pelatihan.pdf');
    }

    public function iht(Request $request)
    {
        $query = Iht::with('pesertas.pegawai');
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_mulai', [$request->start_date, $request->end_date]);
        }

        $data = $query->latest()->get();

        return view('admin.laporan.iht', compact('data'));
    }

    public function exportIht(Request $request)
    {
        $query = Iht::with('pesertas.pegawai');
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_mulai', [$request->start_date, $request->end_date]);
        }

        $data = $query->latest()->get();

        $pdf = Pdf::loadView('admin.laporan.export_iht', compact('data'))->setPaper('A4', 'landscape');

        return $pdf->download('laporan-iht.pdf');
    }
}
