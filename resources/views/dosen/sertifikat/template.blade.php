<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sertifikat Magang</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url("{{ public_path('sertifikat/magang.jpg') }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .container {
            position: static;
            width: 100%;
            height: 210mm;
            padding: 170px 70px 170px 70px;
            /* atur agar teks di area tengah background */
            text-align: center;
        }

        .no-sertifikat {
            font-size: 12px;
            margin-bottom: 10px;
        }

        .label {
            font-size: 13px;
            margin-bottom: 10px;
        }

        .nama {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .prodi {
            font-size: 15px;
            font-weight: bold;
        }

        .kampus {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .isi {
            font-size: 13px;
            margin-top: 10px;
            line-height: 1.5;
        }

    </style>

</head>

<body>
    <div class="container">
        <p class="no-sertifikat"> No :
            00{{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}/LAI/UHM/{{ now()->format('Y') }} </p>
        <p class="label">Diberikan kepada :</p>
        <p class="nama">salis</p>
        <p class="prodi">Pendidikan {{ strtoupper($pengajuan->program_studi) }}</p>
        <p class="kampus">{{ strtoupper($pengajuan->user->kampus->nama ?? '-') }}</p>
        <p class="isi"> Telah melaksanakan Magang di Rumah Sakit PKU Muhammadiyah Sukoharjo<br> mulai dari
            {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->translatedFormat('d F Y') }} sampai dengan
            {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->translatedFormat('d F Y') }}<br> dengan hasil
            <strong>B (Baik)</strong> </p>
    </div>
</body>

</html>
