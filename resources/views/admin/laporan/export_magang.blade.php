<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Magang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th, table td { border: 1px solid #000; padding: 6px; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Laporan Magang</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Program</th>
                <th>Dosen</th>
                <th>Kampus</th>
                <th>Jumlah Mhs</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $d)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $d->created_at->format('d-m-Y') }}</td>
                <td>{{ $d->jenisProgram->nama }}</td>
                <td>{{ $d->user->name }}</td>
                <td>{{ $d->user->kampus->nama ?? '-' }}</td>
                <td>{{ $d->mahasiswas->count() }}</td>
                <td>{{ ucfirst($d->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
