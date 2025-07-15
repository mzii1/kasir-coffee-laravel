<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h2>Laporan Transaksi</h2>
    <p>Periode: {{ request('tanggal_awal') }} s/d {{ request('tanggal_akhir') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Metode</th>
                <th>Total</th>
                <th>Detail Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $transaksi)
                <tr>
                    <td>{{ $transaksi->tanggal }}</td>
                    <td>{{ ucfirst($transaksi->metode_pembayaran) }}</td>
                    <td>Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
                    <td>
                        <ul style="padding-left: 15px;">
                            @foreach ($transaksi->details as $detail)
                                <li>
                                    {{ $detail->menu->nama ?? 'Menu Tidak Ditemukan' }} -
                                    {{ $detail->jumlah }} x Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
