@extends('layouts.app')
@section('title', 'Edit Barang')

@section('content')
<div class="container mt-3">
    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('barang.update', $barang->id) }}" method="POST" id="formBarang">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="fw-semibold">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" value="{{ $barang->nama_barang }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Stok</label>
                    <input type="number" name="stok" class="form-control" value="{{ $barang->stok }}" required min="0">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Satuan</label>
                    <select name="satuan" class="form-control" id="satuan" required>
                        <option value="pcs" {{ $barang->satuan == 'pcs' ? 'selected' : '' }}>Per Buah</option>
                        <option value="lusin" {{ $barang->satuan == 'lusin' ? 'selected' : '' }}>Per Lusin</option>
                        <option value="rol" {{ $barang->satuan == 'rol' ? 'selected' : '' }}>Per Rol</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Harga per Satuan</label>
                    <input type="number" name="harga_satuan" class="form-control" id="harga"
                        value="{{ $barang->harga }}" required min="0">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Harga per pcs</label>
                    <input type="number" class="form-control" id="harga_pcs" readonly>
                </div>

                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-save me-1"></i> Update
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