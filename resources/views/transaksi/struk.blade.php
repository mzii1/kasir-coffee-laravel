<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-size: 10px; font-family: monospace; }
        table { width: 100%; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Coffee Cashier</h2>
    <p style="text-align: center;">jl. berharap sendiri No.03, Lombok Tengah, Nusa Tenggara Barat. 83513, Indonesia</p>
    
    <hr>
    <p>Kasir: {{ $transaksi->user->name ?? '-' }}</p>

    <p>No Transaksi: {{ $transaksi->id }}<br>
       Tanggal: {{ $transaksi->created_at->format('d-m-Y H:i') }}</p>
    <hr>
    <table>
        @foreach ($transaksi->items as $item)
        <tr>
            <td>{{ $item->menu->nama }}</td>
            <td>x{{ $item->jumlah }}</td>
            <td style="text-align: right;">Rp{{ number_format($item->subtotal) }}</td>
        </tr>
        @endforeach
    </table>
    <hr>
    <p style="text-align: right;">
        Total: <strong>Rp{{ number_format($transaksi->total) }}</strong><br>
        <!--
        Bayar: {{ number_format($transaksi->bayar) }}<br>
        Kembali: {{ number_format($transaksi->kembali) }}
-->
    </p>
    <p style="text-align: center;">Terima kasih!</p>
</body>
</html>
