<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iht;
use App\Models\Pegawai;
use App\Models\IhtParticipant;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IhtController extends Controller
{
    public function index()
    {
        $ihts = Iht::withCount('participants')->orderByDesc('tanggal_mulai')->get();
        return view('admin.iht.index', compact('ihts'));
    }
    public function create()
    {
        return view('admin.iht.create');
    }

    public function store(Request $request)
    {
        // $data = $request->validate([
        //     'judul' => 'required|string|max:255',
        //     'deskripsi' => 'nullable|string',
        //     'tempat' => 'required|string',
        //     'instruktur' => 'nullable|string',
        //     'tanggal_mulai' => 'required|date',
        //     'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        //     'file_materi' => 'nullable|file|mimes:pdf,docx,jpg,png',
        //     'file_dokumentasi' => 'nullable|file|mimes:pdf,docx,jpg,png',
        // ]);

        // // Simpan file jika ada
        // if ($request->hasFile('file_materi')) {
        //     $data['file_materi'] = $request->file('file_materi')->store('materi-iht');
        // }
        // if ($request->hasFile('file_dokumentasi')) {
        //     $data['file_dokumentasi'] = $request->file('file_dokumentasi')->store('dokumentasi-iht');
        // }

        // $iht = Iht::create($data);

        // return redirect()->route('admin.iht.index')->with('success', 'IHT berhasil ditambahkan.');
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tempat' => 'required|string',
            'instruktur' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'file_materi' => 'nullable|file|mimes:pdf,docx,jpg,png',
            'file_dokumentasi' => 'nullable|file|mimes:pdf,docx,jpg,png',
        ]);

        // Buat folder jika belum ada
        if (!Storage::disk('public')->exists('materi-iht')) {
            Storage::disk('public')->makeDirectory('materi-iht');
        }
        if (!Storage::disk('public')->exists('dokumentasi-iht')) {
            Storage::disk('public')->makeDirectory('dokumentasi-iht');
        }

        // Simpan file jika ada
        if ($request->hasFile('file_materi')) {
            $data['file_materi'] = $request->file('file_materi')->store('materi-iht', 'public');
        }
        if ($request->hasFile('file_dokumentasi')) {
            $data['file_dokumentasi'] = $request->file('file_dokumentasi')->store('dokumentasi-iht', 'public');
        }

        $iht = Iht::create($data);

        return redirect()->route('admin.iht.index')->with('success', 'IHT berhasil ditambahkan.');
    }

    public function edit(Iht $iht)
    {
        return view('admin.iht.edit', compact('iht'));
    }

    public function update(Request $request, Iht $iht)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tempat' => 'required|string',
            'instruktur' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'file_materi' => 'nullable|file|mimes:pdf,docx,jpg,png',
            'file_dokumentasi' => 'nullable|file|mimes:pdf,docx,jpg,png',
        ]);

        if ($request->hasFile('file_materi')) {
            if ($iht->file_materi) Storage::delete($iht->file_materi);
            $data['file_materi'] = $request->file('file_materi')->store('materi-iht');
        }
        if ($request->hasFile('file_dokumentasi')) {
            if ($iht->file_dokumentasi) Storage::delete($iht->file_dokumentasi);
            $data['file_dokumentasi'] = $request->file('file_dokumentasi')->store('dokumentasi-iht');
        }

        $iht->update($data);

        return redirect()->route('admin.iht.index')->with('success', 'IHT berhasil diperbarui.');
    }

    public function destroy(Iht $iht)
    {
        if ($iht->file_materi) Storage::delete($iht->file_materi);
        if ($iht->file_dokumentasi) Storage::delete($iht->file_dokumentasi);
        $iht->delete();
        return back()->with('success', 'IHT berhasil dihapus.');
    }

    public function peserta(Iht $iht)
    {
        $peserta_terdaftar = $iht->participants()->with('pegawai')->get();
        $pegawai_all = Pegawai::all();

        return view('admin.iht.peserta', compact('iht', 'peserta_terdaftar', 'pegawai_all'));
    }

    public function tambahPeserta(Request $request, Iht $iht)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
        ]);

        // Cegah duplikasi
        if ($iht->participants()->where('pegawai_id', $request->pegawai_id)->exists()) {
            return back()->with('warning', 'Peserta sudah terdaftar.');
        }

        $iht->participants()->create([
            'pegawai_id' => $request->pegawai_id,
            'hadir' => false,
        ]);

        return back()->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function hapusPeserta(Iht $iht, $participant_id)
    {
        $peserta = $iht->participants()->findOrFail($participant_id);
        $peserta->delete();

        return back()->with('success', 'Peserta dihapus.');
    }
    public function presensi(Iht $iht)
    {
        $iht->load('pesertas.pegawai');
        return view('admin.iht.presensi', compact('iht'));
    }

    public function simpanPresensi(Request $request, Iht $iht)
    {
        // update presensi
        foreach ($request->hadir ?? [] as $participant_id) {
            $participant = \App\Models\IhtParticipant::find($participant_id);
            if ($participant && $participant->iht_id == $iht->id) {
                $participant->update(['hadir' => true]);
            }
        }
        // clear peserta yang tidak ditandai hadir
        $iht->pesertas()->whereNotIn('id', $request->hadir ?? [])->update(['hadir' => false]);

        // upload materi
        if ($request->hasFile('file_dokumentasi')) {
            $path = $request->file('file_dokumentasi')->store('dokumentasi-iht', 'public');
            $iht->update(['file_dokumentasi' => $path]);
        }

        return redirect()->route('admin.iht.index')->with('success', 'Presensi dan materi berhasil disimpan.');
    }

    public function generateSertifikat($id)
    {
        // Ambil data IHT dan relasi pesertas + pegawai
        $iht = Iht::with('pesertas.pegawai')->findOrFail($id);

        // Format tanggal sertifikat
        $tanggal = Carbon::parse($iht->tanggal_selesai)->translatedFormat('d F Y');
        $isiQR = "Surat ini ditandatangani oleh: dr. Indarto, M.Si., M.M selaku Direktur Utama RS PKU Muhammadiyah Sukoharjo pada $tanggal";

        // Generate QR Code (base64 SVG)
        $qrSvg = QrCode::format('svg')->size(120)->generate($isiQR);
        $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        // Loop peserta yang hadir dan belum punya sertifikat
        foreach ($iht->pesertas as $peserta) {
            if ($peserta->hadir && !$peserta->sertifikat_path) {
                try {
                    // Generate PDF sertifikat
                    $pdf = Pdf::loadView('admin.iht.sertifikat', [
                        'iht' => $iht,
                        'peserta' => $peserta,
                        'qrBase64' => $qrBase64,
                    ])->setPaper([0, 0, 609.45, 935.43], 'landscape');

                    // Buat nama file
                    $nama = Str::slug($peserta->pegawai->nama);
                    $filename = 'sertifikat-' . $nama . '-' . $peserta->id . '.pdf';
                    $path = 'sertifikat/iht/' . $filename;

                    // Simpan file PDF ke storage (public)
                    Storage::disk('public')->put($path, $pdf->output());

                    // Simpan path sertifikat ke database
                    $peserta->sertifikat_path = $path;

                    if ($peserta->isDirty('sertifikat_path')) {
                        $peserta->save();
                        Log::info("Sertifikat berhasil disimpan untuk peserta ID: {$peserta->id}", [
                            'nama' => $peserta->pegawai->nama,
                            'path' => $path,
                        ]);
                    } else {
                        Log::warning("Tidak ada perubahan pada peserta ID: {$peserta->id}");
                    }

                } catch (\Exception $e) {
                    Log::error("Gagal membuat sertifikat untuk peserta ID: {$peserta->id}", [
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        return back()->with('success', 'Sertifikat berhasil dibuat.');
        // $iht = Iht::with('pesertas.pegawai')->findOrFail($id);
        // $isiQR = "Surat ini ditandatangani oleh: dr. Indarto, M.Si., M.M selaku Direktur Utama RS PKU Muhammadiyah Sukoharjo pada $iht->tanggal_selesai";

        // // Buat SVG base64 agar aman dipakai di PDF
        // $qrSvg = QrCode::format('svg')->size(120)->generate($isiQR);
        // $qrBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);
        // foreach ($iht->pesertas as $peserta) {
        //     if ($peserta->hadir && !$peserta->sertifikat_path) {
        //         $pdf = PDF::loadView('admin.iht.sertifikat', [
        //             'iht' => $iht,
        //             'peserta' => $peserta,
        //             'qrBase64' => $qrBase64,
        //         ])->setPaper([0, 0, 609.45, 935.43], 'landscape');

        //         $filename = 'sertifikatt-' . $peserta->id . '.pdf';
        //         $path = 'sertifikat/iht/' . $filename;
        //         Storage::disk('public')->makeDirectory('sertifikat/iht');
        //         Storage::disk('public')->put($path, $pdf->output());
        //         // Storage::put('public/' . $path, $pdf->output());

        //         $peserta->sertifikat_path = $path;
        //         $peserta->save();
        //     }
        // }

        // return back()->with('success', 'Sertifikat berhasil dibuat');

        // foreach ($iht->pesertas as $peserta) {
        //         $pdf = PDF::loadView('admin.iht.sertifikat', [
        //             'iht' => $iht,
        //             'peserta' => $peserta,
        //             'qrBase64' => $qrBase64,
        //         ])->setPaper([0, 0, 609.45, 935.43], 'landscape');
        // }
        // return $pdf->stream('Sertifikat-'.$peserta->id.'.pdf');
    }
}
