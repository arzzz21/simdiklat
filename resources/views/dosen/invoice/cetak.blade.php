<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header {
            text-align: left;
        }

        .header h3,
        .header h4,
        .header h5 {
            margin: 0;
            padding: 0;
        }

        .green-text {
            color: #008000;
        }

        .info-table td {
            padding: 5px;
            vertical-align: top;
        }

        .items th,
        .items td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .total-row {
            font-weight: bold;
            background-color: #e2f0d9;
        }

        .rekening-box {
            margin-top: 20px;
            border: 1px solid #000;
            padding: 10px;
            background-color: #f6f6f6;
        }

        .rekening-box td {
            padding: 5px;
        }

        .bg-yellow {
            background-color: #fce4a2;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

    </style>
</head>

<body>
    <table>
        <tr>
            <td class="header">
                <h4 class="green-text" style="font-family: 'Times New Roman', Times, serif">PIMPINAN DAERAH MUHAMMADIYAH SUKOHARJO</h4>
                <h3 class="green-text" style="font-family: 'Times New Roman', Times, serif">RUMAH SAKIT PKU MUHAMMADIYAH SUKOHARJO</h3>
                <h5 class="green-text">Jl. Mayor Sunaryo No. 37, Sukoharjo 57512 | Telp. (0271) 593979 | Fax. (0271) 599158</h5>
                <h5 class="green-text">Email: pkusukoharjo@gmail.com | Website: www.pkusukoharjo.com</h5>
            <td class="text-right">
                <h2>INVOICE</h2>
            </td>
        </tr>
    </table> <br>
    <table class="info-table">
        <tr>
            <td><strong>Nama</strong></td>
            <td>: {{ $invoice->pengajuan->user->kampus->nama ?? '-' }}</td>
            <td><strong>Tanggal</strong></td>
            <td>: {{ $invoice->created_at->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>No HP</strong></td>
            <td>: {{ $invoice->pengajuan->user->kampus->no_hp ?? '-' }}</td>
            <td><strong>No INV</strong></td>
            <td>: {{ 'INV/' . $invoice->id . '/' . date('Y') }}</td>
        </tr>
        <tr>
            <td><strong>Alamat</strong></td>
            <td colspan="3">: {{ $invoice->pengajuan->user->kampus->alamat ?? '-' }}</td>
        </tr>
    </table> <br>
    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Keterangan</th>
                <th>Nominal</th>
                <th>Qty</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td> Permohonan {{ $invoice->pengajuan->jenisProgram->nama }} durasi
                    {{ \Carbon\Carbon::parse($invoice->pengajuan->tanggal_mulai)->format('d') }} -
                    {{ \Carbon\Carbon::parse($invoice->pengajuan->tanggal_selesai)->format('d F Y') }} </td>
                <td>Rp{{ number_format($invoice->pengajuan->jenisProgram->biaya, 0, ',', '.') }}</td>
                <td>{{ $invoice->pengajuan->mahasiswas->count() }} mahasiswa</td>
                <td>Rp{{ number_format($invoice->total, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right">Total</td>
                <td>Rp{{ number_format($invoice->total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <div class="rekening-box">
        <table>
            <tr>
                <td width="50%"><strong>REKENING BNI</strong></td>
                <td class="bg-yellow"><strong>KONFIRMASI PEMBAYARAN</strong></td>
            </tr>
            <tr>
                <td><strong>RS PKU MUHAMMADIYAH SUKOHARJO</strong><br>5511565657</td>
                <td class="bg-yellow">FARISA AMIYATUN<br>0812 1888 1726 (WA)</td>
            </tr>
        </table>
    </div>
</body>

</html>
