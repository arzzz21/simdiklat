<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Tugas</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            /* margin: 20px; */
            top: 0cm;
            /* margin-bottom: 70.88pt;
            margin-left: 28.35pt;
            margin-right: 28.35pt; */
        }

        .header {
            text-align: center;
        }

        .header h2,
        .header h3,
        .header h5 {
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        td h2,
        td h3,
        td h5 {
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        .green-text {
            color: #008000;
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
            margin-top: 10px;
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

        .mark {
            color: #fff;
            background-color: #125735;
            padding: 10px 5px;
        }

        .footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 15px;
            text-align: center;
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <table width="100%" style="margin-bottom: 5px;">
        <tr>
            <td width="80">
                <img src="{{ public_path('images/logo-pku.png') }}" width="80">
            </td>
            <td style="text-align: center;">
                <h3 class="green-text">PIMPINAN DAERAH MUHAMMADIYAH SUKOHARJO</h3>
                <h2 class="green-text">RUMAH SAKIT</h2>
                <h2 class="green-text">PKU MUHAMMADIYAH SUKOHARJO</h2>
                <h5 class="green-text">Jl. Mayor Sunaryo No. 37, Sukoharjo 57512</h5>
            </td>
            <td width="80" style="text-align: right;">
                <img src="{{ public_path('images/larsi.png') }}" width="70">
            </td>
        </tr>
    </table>
    <hr>
    <div class="content">
        <p>Yang bertanda tangan di bawah ini menugaskan:</p>

        <p><strong>{{ $pegawai->nama }}</strong><br>
        Unit: {{ $pegawai->unit->nama }}<br>
        Jabatan: {{ $pegawai->jabatan->nama }}</p>

        <p>Untuk mengikuti pelatihan:</p>
        <p><strong>{{ $pelatihan->nama }}</strong><br>
        Tempat: {{ $pelatihan->tempat }}<br>
        Tanggal: {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->format('d-m-Y') }} s.d. {{ \Carbon\Carbon::parse($pelatihan->tanggal_selesai)->format('d-m-Y') }}</p>

        <p>Demikian surat tugas ini dibuat untuk digunakan sebagaimana mestinya.</p>

    </div>
    @php
        $bulan = [
            'Muḥarram' => 'Muharram',
            'Ṣafar' => 'Safar',
            'Rabīʿ al-Awwal' => 'Rabiul Awal',
            'Rabīʿ ath-Thānī' => 'Rabiul Akhir',
            'Jumādá al-Ūlá' => 'Jumadil Ula',
            'Jumādá al-Ākhirah' => 'Jumadil Akhir',
            'Rajab' => 'Rajab',
            'Shaʿbān' => 'Syaban',
            'Ramaḍān' => 'Ramadhan',
            'Shawwāl' => 'Syawal',
            'Dhū al-Qaʿdah' => 'Dzulqaidah',
            'Dhū al-Ḥijjah' => 'Dzulhijjah',
        ];

        $hijriDate = \GeniusTS\HijriDate\Hijri::convertToHijri($pelatihan->tanggal_mulai);
        $tanggalHijri = $hijriDate->format('d F Y');
        $cleanHijri = strtr($tanggalHijri, $bulan);
    @endphp
    <div class="ttd">
        <table width="100%">
            <tr>
                <td width="50%"></td>
                <td style="text-align: right;">Sukoharjo,</td>
                <td style="text-align: right; border-bottom: 1px solid black;">
                    {{ \Carbon\Carbon::parse($pelatihan->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }} M
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="text-align: right;">{{ $cleanHijri }} H</td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" style="text-align: center; padding-top:20px">
                    DIREKTUR UTAMA RUMAH SAKIT <br>
                    PKU MUHAMMADIYAH <br>
                    SUKOHARJO
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" style="text-align: center; font-weight:bold;">
                    <img src="{{ $qrBase64 }}" width="100">
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" style="text-align: center; font-weight:bold; text-decoration: underline;">
                    dr. Indarto, M.Si., M.M
                </td>
            </tr>
            <tr>
                <td></td>
                <td colspan="2" style="text-align: center; font-weight:bold;">
                    NBM. 1.329.060
                </td>
            </tr>
        </table>
    </div>
    <div class="footer">
        <div>Dicetak dari Sistem Informasi Diklat RS PKU Muhammadiyah Sukoharjo.</div>
        <div class="mark">Telp. 0812 2720 3899 | (0271) 593 979 &nbsp; &nbsp; Website. www.rspkusukoharjo.com &nbsp; &nbsp; Email. pku.sukoharjo@gmail.com</div>
    </div>
</body>
</html>
