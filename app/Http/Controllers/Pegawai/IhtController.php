<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IhtController extends Controller
{
    public function index()
    {
        $pegawai = auth()->user()->pegawai;
        $ihts = $pegawai->ihts()->with('iht')->get();

        return view('pegawai.iht.index', compact('ihts'));
    }
    public function evaluasiForm(IhtParticipant $participant)
    {
        return view('pegawai.iht.evaluasi', compact('participant'));
    }

    public function submitEvaluasi(Request $request, IhtParticipant $participant)
    {
        $request->validate([
            'evaluasi' => 'required|string|max:1000'
        ]);
        $participant->evaluasi = $request->evaluasi;
        $participant->evaluasi_at = now();
        $participant->save();

        return redirect()->route('pegawai.iht.index')->with('success', 'Evaluasi berhasil dikirim.');
    }
}
