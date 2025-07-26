<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url("{{ public_path('sertifikat/sertif-iht.jpg') }}");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .container {
            margin-top: 58mm;
            position: static;
            width: 100%;
            height: 100mm;
            /* padding: 170px 70px 170px 70px; */
            /* atur agar teks di area tengah background */
            text-align: center;
            /* background-color: aquamarine */
        }

        .label {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 26px;
            color: #F7B878;
            font-weight: bold;
            margin-top: 11mm;
        }

        .label2 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 22px;
            color: #F7B878;
            font-weight: bold;
            margin-top: 5mm;
        }

        .peserta {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 22px;
            color: #2C3486;
            font-weight: bold;
            margin-top: 5mm;

        }
        .iht {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 26px;
            color: #E94D3A;
            font-weight: bold;
            margin-top: 5mm;
        }
        .tanggal {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 20px;
            color: solid black;
            font-weight: bold;
            margin-top: 5mm;
        }

        .nama {
            font-family:'Times New Roman', Times, serif;
            font-size: 50px;
            font-weight: bold;
            margin-top: 5mm;
            color: #E94D3A;
        }

        .nomer {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 22px;
            font-weight: bold;
            color: #2C3486;
        }

        hr {
            border: 1px solid #E94D3A;
            margin-top: 2px;
            margin-left: 60mm;
            margin-right: 60mm;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="nomer">No : {{ str_pad($peserta->id, 4, '0', STR_PAD_LEFT) }}/SERT/DKT/III.6.AU/PKUSKH/{{ now()->format('Y') }}</div>
    <div class="label">DIBERIKAN KEPADA :</div>
    <div class="nama"><strong>{{ $peserta->pegawai->nama }}</strong></div>
    <hr>
    <div class="label2">Atas Peran Serta Sebagai :</div>
    <div class="peserta"><strong>PESERTA</strong></div>
    <div class="iht">
        <strong>IN HOUSE TRAINING</strong>
        <br> <strong>{{ $iht->judul }}</strong>
    </div>
    <div class="tanggal">{{ \Carbon\Carbon::parse($iht->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }} sampai
        {{ \Carbon\Carbon::parse($iht->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }}</div>
    </div>
</body>


</html>
