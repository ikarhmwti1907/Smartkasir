<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // ============================
    // Laporan Data Barang
    // ============================
    public function laporanBarang(Request $request)
    {
        $bulan = $request->get('bulan', date('Y-m')); // format YYYY-MM

        // Ambil semua barang + hitung jumlah terjual di bulan tersebut
        $barangs = Barang::leftJoin('detail_transaksis', 'barangs.id', '=', 'detail_transaksis.barang_id')
            ->leftJoin('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->select(
                'barangs.id',
                'barangs.nama_barang',
                'barangs.stok',
                'barangs.harga',
                DB::raw('
                    COALESCE(
                        SUM(
                            CASE 
                                WHEN DATE_FORMAT(transaksis.tanggal, "%Y-%m") = "'.$bulan.'" 
                                THEN detail_transaksis.jumlah 
                                ELSE 0 
                            END
                        ), 0
                    ) AS jumlahTerjual
                ')
            )
            ->groupBy(
                'barangs.id',
                'barangs.nama_barang',
                'barangs.stok',
                'barangs.harga'
            )
            ->get();

        // Pastikan jumlahTerjual integer
        $barangs->transform(function ($b) {
            $b->jumlahTerjual = (int) $b->jumlahTerjual;
            return $b;
        });

        // Modal hanya muncul kalau tidak ada barang sama sekali
        $adaData = Transaksi::whereRaw('DATE_FORMAT(tanggal, "%Y-%m") = ?', [$bulan])->exists();

        return view('laporan.barang', compact('barangs', 'bulan', 'adaData'));
    }


    // ============================
    // Laporan Transaksi
    // ============================
    public function transaksi(Request $request)
    {
        $bulan = $request->get('bulan', date('Y-m'));

        $data = Transaksi::whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$bulan])
            ->orderBy('created_at', 'DESC')
            ->get();

        $adaData = $data->count() > 0;

        return view('laporan.transaksi', compact('data', 'bulan', 'adaData'));
    }
}
