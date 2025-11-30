@extends('layouts.app')
@section('title', 'Tambah Barang')

@section('content')
<div class="container mt-3">
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('barang.store') }}" method="POST" id="formBarang">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Stok</label>
                    <input type="number" name="stok" class="form-control" required min="0">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Satuan</label>
                    <select name="satuan" class="form-control" id="satuan" required>
                        <option value="pcs">Per Buah</option>
                        <option value="lusin">Per Lusin</option>
                        <option value="rol">Per Rol</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Harga per Satuan</label>
                    <input type="number" name="harga_satuan" class="form-control" id="harga" required min="0">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Harga per pcs</label>
                    <input type="number" class="form-control" id="harga_pcs" readonly>
                </div>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-1"></i> Simpan
                </button>

                <a href="{{ route('barang.index') }}" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                </a>
            </form>

        </div>
    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const hargaInput = document.getElementById("harga");
    const satuanSelect = document.getElementById("satuan");
    const hargaPcs = document.getElementById("harga_pcs");

    const updateHargaPcs = () => {
        let harga = parseInt(hargaInput.value) || 0;
        let satuan = satuanSelect.value;

        let hargaPerPcs = harga;
        if (satuan === "lusin") hargaPerPcs = harga / 12;
        if (satuan === "rol") hargaPerPcs = harga / 10;

        hargaPcs.value = Math.round(hargaPerPcs);
    };

    // Update harga per pcs saat input harga atau ubah satuan
    hargaInput.addEventListener("input", updateHargaPcs);
    satuanSelect.addEventListener("change", updateHargaPcs);

    updateHargaPcs(); // init
});
</script>
@endsection