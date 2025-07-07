<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Invoice #{{ $invoice->id }}</title>
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .table th, .table td { border: 1px solid #000; padding: 8px; }
    .header { text-align: center; }
  </style>
</head>
<body>
  <div class="header">
    <h2>Invoice Pembayaran</h2>
    <p>RS PKU Muhammadiyah Sukoharjo</p>
    <hr>
  </div>

  <table>
    <tr>
      <td><strong>No Invoice:</strong> #{{ $invoice->id }}</td>
      <td><strong>Tanggal:</strong> {{ $invoice->created_at->format('d-m-Y') }}</td>
    </tr>
    <tr>
      <td><strong>Dosen:</strong> {{ $invoice->pengajuan->user->name }}</td>
      <td><strong>Program:</strong> {{ $invoice->pengajuan->jenisProgram->nama }}</td>
    </tr>
    <tr>
      <td><strong>Durasi:</strong> {{ $invoice->pengajuan->tanggal_mulai }} s/d {{ $invoice->pengajuan->tanggal_selesai }}</td>
      <td><strong>Status:</strong> {{ ucfirst($invoice->status) }}</td>
    </tr>
  </table>

  <h4>Rincian Biaya</h4>
  <table class="table">
    <thead>
      <tr>
        <th>Deskripsi</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Biaya program {{ $invoice->pengajuan->jenisProgram->nama }}</td>
        <td>Rp{{ number_format($invoice->total, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <th>Total</th>
        <th>Rp{{ number_format($invoice->total, 0, ',', '.') }}</th>
      </tr>
    </tbody>
  </table>

  <p style="margin-top: 30px;">Harap melakukan pembayaran sesuai jumlah di atas dan unggah bukti melalui sistem.</p>
</body>
</html>
