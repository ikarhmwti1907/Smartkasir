<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang;

class DashboardController extends Controller
{
    public function index()
{
    $pendapatan = Transaksi::sum('total');
    $totalTransaksi = Transaksi::count();
    $totalBarang = Barang::count();
    $recent = Transaksi::orderBy('id','DESC')->take(5)->get();

    // Data Grafik Pendapatan
    $chart = Transaksi::selectRaw('MONTH(created_at) as bulan, SUM(total) as total')
        ->groupBy('bulan')
        ->pluck('total');

    $label = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

    return view('dashboard', [
        'pendapatan'   => $pendapatan,
        'totalTransaksi'=> $totalTransaksi,
        'totalBarang'  => $totalBarang,
        'recent'       => $recent,
        'chartData'    => $chart,
        'chartLabel'   => $label
    ]);
}


}