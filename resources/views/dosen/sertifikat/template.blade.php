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
            margin-top: 72mm;
            position: static;
            width: 100%;
            height: 100mm;
            /* padding: 170px 70px 170px 70px; */
            /* atur agar teks di area tengah background */
            text-align: center;
            /* background-color: aquamarine */
        }

        .no-sertifikat {
            font-size: 12px;
            margin-bottom: 10px;
        }

        .label {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 26px;
        }

        .nama {
            font-family:'Times New Roman', Times, serif;
            font-size: 45px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .nomer {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 22px;
            font-weight: bold;
        }

        .prodi {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 24px;
            font-weight: bold;
        }

        .kampus {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .isi {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 24px;
            line-height: 1.0;
        }
        .ttd {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-size: 16px;
            color: solid black;
            font-weight: bold;
        }
        hr {
            border: 1px solid black;
            margin-top: 4px;
        }
    </style>

</head>

<body>
    <div class="container">
        <table style="width: 65%; margin: 0 auto; text-align:center;">
            <tr>
                <td class="nomer">No : {{ str_pad($pengajuan->id, 4, '0', STR_PAD_LEFT) }}/LAI/UHM/III.6.AU/PKUSKH/{{ now()->format('Y') }} </td>
            </tr>
            <tr>
                <td class="label" style="padding-top: 10px;">Diberikan kepada :</td>
            </tr>
            <tr>
                <td class="nama" style="border-bottom: 2px solid #000; padding-top: 10px;">{{ $mhs->nama }}</td>
            </tr>
            <tr>
                <td class="prodi" style="padding-top: 10px;">Pendidikan {{ strtoupper($pengajuan->program_studi) }}</td>
            </tr>
            <tr>
                <td class="kampus">{{ strtoupper($pengajuan->user->kampus->nama ?? '-') }}</td>
            </tr>
            <tr>
                <td class="isi" style="padding-top: 10px;">
                    Telah melaksanakan {{ $pengajuan->jenisProgram->nama }} di Rumah Sakit PKU Muhammadiyah Sukoharjo pada tanggal
                    @if ($pengajuan->tanggal_mulai === $pengajuan->tanggal_selesai)
                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }} sampai dengan
                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_selesai)->locale('id')->translatedFormat('d F Y') }}
                    @endif
                    <br>dengan hasil <strong>B (Baik)</strong>
                </td>
            </tr>
        </table>
        <div class="ttd" style="padding-left: 70%;">
            <table style="text-align: center;">
                <tr>
                    <td>Direktur Rumah Sakit</td>
                </tr>
                <tr>
                    <td>PKU Muhammadiyah Sukoharjo</td>
                </tr>
                <tr>
                    <td>
                        <img src="{{ $qrBase64 }}" width="70">
                    </td>
                </tr>
                <tr>
                    <td style="text-decoration: underline">dr. Indarto, M.Si., M.M.</td>
                </tr>
                <tr>
                    <td>NBM. 1329060</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
