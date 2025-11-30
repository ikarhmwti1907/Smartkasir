@extends('layouts.app')
@section('title', 'Data Barang')

@section('content')

<style>
/* ==========================================
   ★ Modern POS Inventory Table Upgrade ★
   ========================================== */

/* Card */
.card-modern {
    border-radius: 14px;
    border: none;
    overflow: hidden;
}

/* Table */
.table-modern thead {
    background: #1F3A5F;
    color: #FFF;
}

.table-modern tbody tr {
    transition: 0.2s ease;
    color: #000;
}

.table-modern tbody tr:hover {
    background: #F7F7F7;
    transform: scale(1.01);
    color: #000;
}

/* Buttons */
.btn-add {
    background: #F47C20;
    border: none;
    color: #FFF;
}

.btn-add:hover {
    background: #d56d1c;
}

/* Edit (Yellow) */
.btn-edit {
    background: #FFC107;
    border: none;
    color: #000;
    font-weight: 600;
}

.btn-edit:hover {
    background: #e0a800;
}

/* Delete (Red) */
.btn-delete {
    background: #DC3545;
    border: none;
    color: white;
}

.btn-delete:hover {
    background: #b02a37;
}

/* Harga (Black) */
.price-black {
    color: #000 !important;
    font-weight: 700;
}

/* Stok */
.badge-stok {
    font-weight: 600;
    padding: 0.5em 0.7em;
    color: #fff;
}

.badge-stok.low {
    background-color: #DC3545 !important;
}

.badge-stok.normal {
    background-color: #0D6EFD !important;
}

/* =============================
   Pencarian
============================= */
.search-box input {
    background: #FFF;
    color: #000;
    border: 1px solid #CED4DA;
}

.search-box input::placeholder {
    color: #6C757D;
}

.search-box button {
    background: #F47C20;
    color: #FFF;
    border: none;
}

.search-box input:focus {
    outline: none;
    border-color: #F47C20;
    box-shadow: 0 0 5px rgba(244, 124, 32, 0.5);
}

.search-box button:hover {
    background: #d56d1c;
}

/* Dark Mode */
body.dark-mode .table-modern thead {
    background: #2A2A2A !important;
    color: #FFF !important;
}

body.dark-mode .table-modern tbody tr {
    color: #FFF !important;
}

body.dark-mode .table-modern tbody tr:hover {
    background: #3A3A3A !important;
    color: #FFF !important;
}

body.dark-mode .search-box input {
    background: #1E1E1E;
    color: #FFF;
    box-shadow: none;
    border: 1px solid #444;
}

body.dark-mode .search-box input::placeholder {
    color: #AAA;
}

body.dark-mode .search-box button {
    background: #F47C20 !important;
    color: #FFF !important;
}

body.dark-mode .search-box button:hover {
    background: #d56d1c !important;
}

body.dark-mode .btn-add {
    background: #F47C20 !important;
    color: #FFF !important;
}

/* Edit yellow tetap terlihat di dark mode */
body.dark-mode .btn-edit {
    background: #FFD54F !important;
    color: #000 !important;
}

/* Delete tetap merah */
body.dark-mode .btn-delete {
    background: #E63946 !important;
}

/* Harga tetap jelas */
body.dark-mode .price-black {
    color: #FFF !important;
}

/* Notifikasi alert */
.alert {
    color: #000;
}

body.dark-mode .alert {
    color: #FFF;
}
</style>

<div class="container mt-3">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('barang.create') }}" class="btn btn-add shadow-sm px-3 py-2">
            <i class="bi bi-plus-circle me-1"></i> Tambah Barang
        </a>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Pencarian -->
    <div class="search-box mb-3 d-flex justify-content-end">
        <form action="{{ route('barang.index') }}" method="GET" class="d-flex w-100">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama barang..."
                value="{{ request('search') }}">
            <button type="submit" class="btn btn-add">
                <i class="bi bi-search"></i> Cari
            </button>

            @if(request('search'))
            <a href="{{ route('barang.index') }}" class="btn btn-secondary ms-2">Reset</a>
            @endif
        </form>
    </div>

    <!-- Tabel -->
    <div class="card card-modern shadow-sm">
        <div class="card-body p-0">
            <table class="table table-modern table-hover align-middle mb-0">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @forelse($barangs as $barang)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-start fw-semibold">{{ $barang->nama_barang }}</td>

                        {{-- Stok dinamis --}}
                        <td>
                            <span class="badge badge-stok {{ $barang->stok == 0 ? 'low' : 'normal' }}">
                                {{ $barang->stok }}
                            </span>
                        </td>

                        <td class="price-black">
                            Rp {{ number_format($barang->harga, 0, ',', '.') }}
                        </td>
                        <td>
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-edit btn-sm me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <button class="btn btn-delete btn-sm btn-hapus" data-id="{{ $barang->id }}"
                                data-nama="{{ $barang->nama_barang }}" data-bs-toggle="modal"
                                data-bs-target="#hapusModal">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-muted py-3">Tidak ada data barang.</td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="hapusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">

            <!-- HEADER -->
            <div class="modal-header" style="background:#dc3545; color:white;">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body text-center">
                <i class="bi bi-trash3-fill text-danger" style="font-size: 60px;"></i>
                <h5 class="mt-3">Yakin ingin menghapus barang ini?</h5>
                <p id="namaBarangHapus" class="text-muted mb-0"></p>
            </div>

            <!-- FOOTER -->
            <div class="modal-footer justify-content-center">
                <button class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>

                <form method="POST" id="formHapus">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-delete px-4">
                        <i class="bi bi-trash3-fill me-1"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const hapusButtons = document.querySelectorAll(".btn-hapus");
    const namaBarangHapus = document.getElementById("namaBarangHapus");
    const formHapus = document.getElementById("formHapus");

    hapusButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            let id = this.dataset.id;
            let nama = this.dataset.nama;

            namaBarangHapus.innerHTML = "<strong>" + nama + "</strong>";
            formHapus.action = "/barang/" + id;
        });
    });
});
</script>

@endsection