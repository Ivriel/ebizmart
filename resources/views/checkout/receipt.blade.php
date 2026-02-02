<!DOCTYPE html>
<html>

<head>
    <title>Struk Pembayaran #{{ $sale->id }}</title>
    <style>
        body {
            font-family: 'Courier', monospace;
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        hr {
            border-top: 1px dashed #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header text-center">
        <h2>E-BIZMART</h2>
        <p>Jl. Toko Keren No. 123, Jakarta</p>
        <hr>
    </div>

    <p>
        No. Struk : {{ $sale->id }}<br>
        Atas nama : {{ $sale->user->nama_user }}<br>
        Tanggal : {{ \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y H:i:s') }}<br>
        Status Pembayaran : {{ $sale->status_transaksi }}
    </p>
    <hr>

    <table>
        <thead>
            <tr>
                <th align="left">Produk</th>
                <th align="center">Qty</th>
                <th align="right">Harga</th>
                <th align="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->detailTransactions as $detail)
                <tr>
                    <td>{{ $detail->stuff->nama_barang }}</td>
                    <td align="center">{{ $detail->jumlah }}</td>
                    <td align="right">{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td align="right">{{ number_format($detail->sub_total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>
    <table>
        <tr>
            <td class="text-right"><strong>TOTAL:</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($sale->total, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <hr>
    <div class="text-center">
        <p>-- Terima Kasih --</p>
    </div>
</body>

</html>