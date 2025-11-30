<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Struk Transaksi</title>
    <style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: monospace;
        font-size: 13px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .struk {
        width: 270px;
        /* 58mm printer */
    }

    .center {
        text-align: center;
    }

    .line {
        border-top: 1px dashed #000;
        margin: 6px 0;
    }

    table {
        width: 100%;
        font-size: 13px;
        border-collapse: collapse;
    }

    td {
        padding: 2px 0;
    }

    img.logo {
        max-width: 80px;
        margin-bottom: 4px;
    }

    small {
        display: block;
    }
    </style>
</head>

<body onload="window.print()">

    <div class="struk">

        <!-- Logo & Header -->
        <div class="center">
            <img src="data:image/jpg;base64,{{ $logoBase64 }}" alt="Logo Toko" class="logo"><br>
            <strong>SMART KASIR</strong><br>
            <small>Jl. Contoh Alamat No.123, Bandung</small>
            <small>Telp: 0812-3456-7890</small>
            <small>{{ $transaksi->tanggal }}</small>
        </div>

        <div class="line"></div>

        <!-- Detail Barang -->
        <table>
            @foreach ($transaksi->details as $item)
            <tr>
                <td colspan="2">{{ $item->nama_barang }}</td>
            </tr>
            <tr>
                <td>
                    {{ $item->jumlah }} {{ $item->satuan ?? 'pcs' }} x
                    Rp {{ number_format($item->harga_barang) }}
                </td>
                <td style="text-align:right;">
                    Rp {{ number_format($item->subtotal) }}
                </td>
            </tr>
            @endforeach
        </table>

        <div class="line"></div>

        <!-- Total Bayar -->
        <table>
            <tr>
                <td>Total</td>
                <td style="text-align:right;">Rp {{ number_format($transaksi->total) }}</td>
            </tr>
            <tr>
                <td>Bayar</td>
                <td style="text-align:right;">Rp {{ number_format($transaksi->bayar) }}</td>
            </tr>
            <tr>
                <td>Kembalian</td>
                <td style="text-align:right;">Rp {{ number_format($transaksi->kembalian) }}</td>
            </tr>
        </table>

        <div class="line"></div>

        <!-- Footer -->
        <div class="center">
            <small>Terima kasih telah berbelanja!</small>
            <small>www.smartkasir.com</small>
        </div>

    </div>

</body>

</html>