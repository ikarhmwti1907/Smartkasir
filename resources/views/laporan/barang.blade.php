@extends('layouts.app')
@section('title', 'Laporan Data Barang')

@section('content')

<div class="container mt-4">

    <!-- Filter Bulan -->
    <form action="{{ route('laporan.barang') }}" method="GET" 
          class="mb-3 d-flex gap-2 align-items-center">
        <label class="mb-0 fw-semibold">Pilih Bulan:</label>
        <input type="month" id="filterBulan" name="bulan" 
               class="form-control w-auto" value="{{ $bulan }}">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Jumlah Terjual</th>
                            <th>Harga per Buah</th>
                            <th>Harga per Lusin</th>
                            <th>Harga per Rol</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($barangs as $b)
                            @php
                                $harga_pcs = $b->harga;
                                $harga_lusin = round($b->harga * 12);
                                $harga_rol = round($b->harga * 10);
                                $jumlah_terjual = (int) $b->jumlahTerjual;
                                $rowClass = $jumlah_terjual == 0 ? 'table-secondary' : '';
                            @endphp

                            <tr class="{{ $rowClass }}">
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start">{{ $b->nama_barang }}</td>
                                <td>{{ $b->stok }}</td>
                                <td>{{ $jumlah_terjual }}</td>
                                <td class="text-dark fw-semibold">
                                    Rp {{ number_format($harga_pcs,0,',','.') }}
                                </td>
                                <td class="text-dark fw-semibold">
                                    Rp {{ number_format($harga_lusin,0,',','.') }}
                                </td>
                                <td class="text-dark fw-semibold">
                                    Rp {{ number_format($harga_rol,0,',','.') }}
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">Tidak ada data barang.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{{-- Modal Tidak Ada Transaksi --}}
@if(!$adaData)
<div class="modal fade" id="modalTidakAda" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Pemberitahuan
                </h5>
                <button type="button" 
                        class="btn-close btn-close-white" 
                        data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>
                    Tidak ada transaksi di bulan 
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y') }}.
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endif


<script>
document.addEventListener("DOMContentLoaded", () => {
    @if(!$adaData)
        new bootstrap.Modal(document.getElementById('modalTidakAda')).show();
    @endif
});
</script>

@endsection
