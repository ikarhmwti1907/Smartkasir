<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
{
    $bulan = $request->get('bulan', date('Y-m'));
    $transaksis = Transaksi::with('details.barang')
        ->whereYear('tanggal', explode('-', $bulan)[0])
        ->whereMonth('tanggal', explode('-', $bulan)[1])
        ->orderBy('tanggal', 'desc')
        ->get();

    return view('transaksi.index', compact('transaksis'));
}


    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'exists:barangs,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'integer|min:1',
            'satuan' => 'required|array|min:1',
            'satuan.*' => 'in:pcs,lusin,rol',
            'harga_satuan' => 'required|array|min:1',
            'harga_satuan.*' => 'numeric|min:0',
            'bayar' => 'nullable|numeric|min:0',
        ]);

        // Hitung total berdasarkan harga per satuan
        $total = 0;
        foreach ($request->barang_id as $i => $barangId) {
            $harga = $request->harga_satuan[$i];
            $jumlah = $request->jumlah[$i];
            $total += $harga * $jumlah;
        }

        if ($request->bayar === null) {
            return redirect()->back()->with('error', 'Masukkan nominal bayar terlebih dahulu!');
        }

        $bayar = $request->bayar;
        $kembalian = $bayar - $total;

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'tanggal' => now(),
                'total' => $total,
                'bayar' => $bayar,
                'kembalian' => $kembalian,
            ]);

            foreach ($request->barang_id as $i => $barangId) {
                $barang = Barang::findOrFail($barangId);
                $jumlah = $request->jumlah[$i];
                $satuan = $request->satuan[$i];
                $harga = $request->harga_satuan[$i];

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id'    => $barang->id,
                    'nama_barang'  => $barang->nama_barang,
                    'harga_barang' => $harga,
                    'jumlah'       => $jumlah,
                    'satuan'       => $satuan,
                    'subtotal'     => $jumlah * $harga
                ]);

                $barang->decrement('stok', $jumlah);
            }

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function cetakStruk($id)
    {
        $transaksi = Transaksi::with('details')->findOrFail($id);
        $path = public_path('images/logo.jpg');
        $logoBase64 = base64_encode(file_get_contents($path));
        return view('transaksi.struk', compact('transaksi', 'logoBase64'));
    }
}