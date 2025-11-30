<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller {

    public function laporanBarang(Request $request)
    {
        $bulan = $request->get('bulan', date('Y-m')); // format YYYY-MM

        // Ambil semua barang beserta relasi details yang terfilter per bulan
        $barangs = Barang::with(['details' => function($q) use ($bulan) {
            $q->whereHas('transaksi', function($q2) use ($bulan) {
                $q2->where('tanggal', 'like', $bulan . '%');
            });
        }])->get();

        // Cek apakah ada transaksi di bulan tersebut
        $adaData = $barangs->sum(function($b) {
            return $b->details->count();
        }) > 0;

        return view('laporan.barang', compact('barangs', 'bulan', 'adaData'));
    }

    public function transaksi(Request $request)
{
    $bulan = $request->get('bulan', date('Y-m')); // format YYYY-MM

    // Ambil transaksi sesuai bulan
    $data = Transaksi::where('created_at', 'like', $bulan . '%')
        ->orderBy('created_at', 'DESC')
        ->get();

    // Cek apakah ada data di bulan tersebut
    $adaData = $data->count() > 0;

    return view('laporan.transaksi', compact('data', 'bulan', 'adaData'));
}

}