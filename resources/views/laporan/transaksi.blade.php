@extends('layouts.app')
@section('title', 'Laporan Transaksi')

@section('content')
<div class="container mt-4">

    <!-- Filter Bulan -->
    <form action="{{ route('laporan.transaksi') }}" method="GET" class="mb-3 d-flex gap-2 align-items-center">
        <label class="mb-0 fw-semibold">Pilih Bulan:</label>
        <input type="month" name="bulan" class="form-control w-auto" value="{{ $bulan ?? date('Y-m') }}">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Bayar</th>
                            <th>Kembalian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $row->tanggal }}</td>
                            <td class="fw-semibold text-dark">Rp {{ number_format($row->total,0,',','.') }}</td>
                            <td>Rp {{ number_format($row->bayar,0,',','.') }}</td>
                            <td class="fw-semibold text-dark">Rp {{ number_format($row->kembalian,0,',','.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-muted">Tidak ada data transaksi di bulan ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if(isset($adaData) && !$adaData)
<!-- Modal Pemberitahuan -->
<div class="modal fade" id="modalTidakAda" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Pemberitahuan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Tidak ada laporan di bulan
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y') }}.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    new bootstrap.Modal(document.getElementById('modalTidakAda')).show();
});
</script>
@endif

@endsection