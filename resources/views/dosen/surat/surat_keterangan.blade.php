<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Magang</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            margin: 50px;
        }

        .header {
            text-align: center;
        }

        .header h2,
        .header h3 {
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        .alamat {
            font-size: 11pt;
        }

        hr {
            border: 1px solid black;
            margin-top: 4px;
        }

        .judul {
            text-align: center;
            margin-top: 20px;
            text-decoration: underline;
            font-weight: bold;
        }

        .nomor {
            text-align: center;
            margin-bottom: 20px;
        }

        .isi {
            text-align: justify;
            line-height: 1.6;
        }

        .ttd {
            text-align: right;
            margin-top: 40px;
        }

        ol {
            margin-top: 0;
        }

        .footer {
            font-size: 10pt;
            margin-top: 50px;
            text-align: center;
        }

    </style>
</head>

<body>
    <div class="header">
        <h2>PIMPINAN DAERAH MUHAMMADIYAH SUKOHARJO</h2>
        <h3>RUMAH SAKIT PKU MUHAMMADIYAH SUKOHARJO</h3>
        <p class="alamat">Jl. Mayor Sunaryo No. 37, Sukoharjo 57512</p>
        <hr>
    </div>
    <div class="judul">SURAT KETERANGAN</div>
    <div class="nomor">Nomor: {{ str_pad($pengajuan->id, 3, '0', STR_PAD_LEFT).'/DIKLAT'.'/PKU-SKH/'.date('Y') }}</div>
    <p class="isi">Yang bertanda tangan di bawah ini:</p>
    <table>
        <tr>
            <td width="150">Nama</td>
            <td>:</td>
            <td>dr. Indarto, M.Si., M.M.</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>Direktur Utama Rumah Sakit PKU Muhammadiyah Sukoharjo</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>Rumah Sakit PKU Muhammadiyah Sukoharjo</td>
        </tr>
    </table>
    <p class="isi">Menerangkan bahwa mahasiswa berikut:</p>
    <table>
        <tr>
            <td width="150" style="vertical-align: top;">Nama</td>
            <td style="vertical-align: top;">:</td>
            <td><ol> @foreach($pengajuan->mahasiswas as $mhs) <li>{{ $mhs->nama }}</li> @endforeach </ol></td>
        </tr>
        <tr>
            <td width="150">Nama Pembimbing</td>
            <td>:</td>
            <td>{{ $pengajuan->pembimbing_rumah_sakit }}</td>
        </tr>
        <tr>
            <td>Program</td>
            <td>:</td>
            <td>{{ $pengajuan->jenisProgram->nama }}</td>
        </tr>
        <tr>
            <td>Asal Instansi</td>
            <td>:</td>
            <td>{{ $pengajuan->user->kampus->nama ?? '-' }}</td>
        </tr>
    </table>
    <p class="isi"> Nama tersebut diatas benar-benar telah menyelesaikan kegiatan {{ $pengajuan->jenisProgram->nama }} dengan kompetensi
        sesuai program studi yang diajukan di Unit {{ $pengajuan->unit_magang ?? '-' }} RS PKU
        Muhammadiyah Sukoharjo pada tanggal
        {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }} s/d
        {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }} dan pembimbing praktik telah
        melaksanakan tugas sesuai prosedur pembimbingan sesuai dengan mekanisme prosedur pendidikan di Rumah Sakit PKU Muhammadiyah Sukoharjo. </p>
    <div class="ttd">
        <p>Sukoharjo, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</p>
        <p>{{ $pengajuan->jabatan_pembimbing }}</p> <br><br><br>
        <p><strong>{{ $pengajuan->nama_pembimbing_rs }}</strong></p> @if(!empty($pengajuan->nip_pembimbing)) <p>NIP.
            {{ $pengajuan->nip_pembimbing }}</p> @endif
    </div>
    <div class="footer"> Dicetak dari Sistem Informasi Diklat RS PKU Muhammadiyah Sukoharjo. </div>
</body>

</html>
