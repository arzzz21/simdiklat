<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan IHT</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        h3 {
            text-align: center;
        }

    </style>
</head>

<body>
    <h3>LAPORAN IHT (In House Training)</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Tempat</th>
                <th>Instruktur</th>
                <th>Peserta</th>
            </tr>
        </thead>
        <tbody> @foreach ($data as $i => $item) <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->judul }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d-m-Y') }} s/d
                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d-m-Y') }}</td>
                <td>{{ $item->tempat }}</td>
                <td>{{ $item->instruktur }}</td>
                <td> @foreach ($item->pesertas as $peserta) {{ $peserta->pegawai->nama }}<br> @endforeach </td>
            </tr> @endforeach </tbody>
    </table>
</body>

</html>
