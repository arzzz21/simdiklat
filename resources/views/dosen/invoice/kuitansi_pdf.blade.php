<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 95%;
            margin: auto;
            border: 1px solid #000;
            padding: 15px 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header {
            text-align: left;
        }

        .header h2,
        .header h3,
        .header h4,
        .header h5 {
            margin: 0;
            padding: 0;
        }

        .green-text {
            color: #008000;
        }

        .green-line {
            border-top: 3px solid green;
            margin: 5px 0 10px 0;
        }

        table.meta {
            width: 100%;
            margin-top: 10px;
            font-size: 12px;
        }

        table.meta td {
            padding: 4px;
            vertical-align: top;
        }

        .rupiah-box {
            margin-top: 10px;
            font-weight: bold;
            font-size: 18px;
            display: flex;
            justify-content: flex-end;
        }

        .rupiah-box span {
            border: 1px solid #000;
            padding: 5px 5px;
        }

        .ttd {
            margin-top: 10px;
            text-align: right;
        }

        .qr {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <tr>
                <td class="header">
                    <h3 class="green-text" style="font-family: 'Times New Roman', Times, serif">PIMPINAN DAERAH MUHAMMADIYAH SUKOHARJO</h3>
                    <h2 class="green-text" style="font-family: 'Times New Roman', Times, serif">RUMAH SAKIT PKU MUHAMMADIYAH SUKOHARJO</h2>
                    <h5 class="green-text">Jl. Mayor Sunaryo No. 37, Sukoharjo 57512 | Telp. (0271) 593979 | Fax. (0271) 599158</h5>
                    <h5 class="green-text">Email: pkusukoharjo@gmail.com | Website: www.pkusukoharjo.com</h5>
                <td class="text-right">
                    <h2 class="green-text">KWITANSI</h2>
                </td>
            </tr>
        </table>

        <div class="green-line"></div>

        <table class="meta">
            <tr>
                <td>Telah Terima Dari</td>
                <td>:</td>
                <td> {{ $pengajuan->user->kampus->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Uang Sejumlah</td>
                <td>:</td>
                <td> {{ \Illuminate\Support\Str::title(\Riskihajar\Terbilang\Facades\Terbilang::make($pengajuan->invoice->total, ' rupiah')) }}</td>
            </tr>
            <tr>
                <td>Untuk Pembayaran</td>
                <td>:</td>
                <td> {{ $pengajuan->invoice ? 'INV/' . $pengajuan->invoice->id . '/' . now()->year : '-' }}<br>
                    {{ $pengajuan->jenisProgram->nama ? 'Permohonan ' . $pengajuan->jenisProgram->nama . ' ' . $pengajuan->prodi->jenjang . '-' . $pengajuan->prodi->nama : '' }}<br>
                    Periode {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}
                    s/d {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }}
                </td>
            </tr>
        </table>

        <div class="rupiah-box">
            <span>Rp. {{ number_format($pengajuan->invoice->total, 0, ',', '.') }}</span>
        </div>

        <div class="ttd">
            <p>Sukoharjo, {{ \Carbon\Carbon::parse($pengajuan->tanggal_verifikasi)->locale('id')->translatedFormat('d F Y') }}</p>
            @if(!empty($qrBase64))
                <div class="qr">
                    <img src="{{ $qrBase64 }}" width="80" alt="QR Code">
                </div>
            @endif
            <p>({{ $pengajuan->verifikator->name ?? '................' }})</p>
        </div>
    </div>
</body>
</html>
