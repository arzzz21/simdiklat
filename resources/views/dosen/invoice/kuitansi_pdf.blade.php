<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kuitansi Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        .text-center {
            text-align: center;
        }
        .kuitansi-box {
            border: 1px solid #000;
            padding: 20px;
        }
        .ttd {
            margin-top: 50px;
            text-align: right;
        }
        table.detail {
            width: 100%;
            margin-top: 20px;
        }
        table.detail td {
            vertical-align: top;
            padding: 4px 0;
        }
        .border {
            border: 1px solid black;
            padding: 10px;
        }
        .footer {
            font-size: 12px;
            margin-top: 30px;
            text-align: center;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="text-center">KUITANSI PEMBAYARAN</h3>

        <div class="kuitansi-box">
            <p>Sudah terima dari:</p>
            <p><strong>{{ $pengajuan->user->name }}</strong> (Dosen Pembimbing)</p>

            <p>Uang sejumlah:</p>
            <p><strong>Rp. {{ number_format($pengajuan->invoice->total, 0, ',', '.') }}</strong></p>

            <p>Untuk pembayaran program:</p>
            <p><strong>{{ strtoupper($pengajuan->jenisProgram->nama) }}</strong></p>

            <table class="detail">
                <tr>
                    <td width="30%">Program Studi</td>
                    <td>: {{ $pengajuan->program_studi }}</td>
                </tr>
                <tr>
                    <td>Rentang Waktu</td>
                    <td>: {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>Unit Magang</td>
                    <td>: {{ $pengajuan->unit_magang ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jumlah Mahasiswa</td>
                    <td>: {{ $pengajuan->mahasiswas->count() }} orang</td>
                </tr>
                <tr>
                    <td>Metode Biaya</td>
                    <td>: {{ ucfirst(str_replace('_', ' ', $pengajuan->jenisProgram->metode_biaya)) }}</td>
                </tr>
                <tr>
                    <td>Nominal per {{ $pengajuan->jenisProgram->metode_biaya == 'per_bulan' ? 'Bulan' : ($pengajuan->jenisProgram->metode_biaya == 'per_minggu' ? 'Minggu' : 'Program') }}</td>
                    <td>: Rp. {{ number_format($pengajuan->jenisProgram->biaya, 0, ',', '.') }}</td>
                </tr>
            </table>

            <div class="ttd" style="align : center">
                <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
                <p>Petugas</p>
                <img src="{{ $qrBase64 }}" width="80" alt="QR Code">
                <p>{{ $pengajuan->verifikator->name ?? '-' }}</p>
            </div>
            <hr style="margin: 10px 0;">
            <small><strong>Verifikasi:</strong></small><br>
            <small>Oleh: {{ $pengajuan->verifikator->name ?? '-' }}</small><br>
            <small>Tanggal: {{ \Carbon\Carbon::parse($pengajuan->tanggal_verifikasi)->format('d-m-Y H:i') }}</small>

        </div>

        <div class="footer">
            Kuitansi ini dicetak dari sistem informasi Diklat RS — tidak perlu tanda tangan basah.
        </div>
    </div>
</body>
</html>
