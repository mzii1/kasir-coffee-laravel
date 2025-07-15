<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Metode</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaksis as $transaksi)
            <tr>
                <td>{{ $transaksi->tanggal }}</td>
                <td>{{ $transaksi->total }}</td>
                <td>{{ $transaksi->metode_pembayaran }}</td>
                <td>
                    @foreach ($transaksi->details as $detail)
                        {{ $detail->menu->nama }} x {{ $detail->jumlah }}<br>
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
