@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle-fill me-1"></i> {{ session('error') }}
    </div>
    @endif

    <!-- Form Input Transaksi -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-dark text-white fw-semibold">
            <i class="bi bi-pencil-square me-1"></i> Input Transaksi
        </div>
        <div class="card-body">

            <button type="button" id="tambahBarang" class="btn btn-secondary mb-3">
                <i class="bi bi-plus-circle me-1"></i> Tambah Barang
            </button>

            <form action="{{ route('transaksi.store') }}" method="POST" id="formTransaksi">
                @csrf
                <table class="table table-bordered text-center align-middle" id="tabelBarang">
                    <thead class="table-secondary">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="position: relative;">
                                <input type="text" name="nama_barang[]" class="form-control nama-barang"
                                    placeholder="Ketik nama barang..." autocomplete="off">
                                <div class="hasil-pencarian"></div>
                                <input type="hidden" name="barang_id[]" class="barang-id">
                                <input type="hidden" name="stok[]" class="stok-barang">
                                <input type="hidden" class="harga-dasar">
                            </td>
                            <td>
                                <select name="satuan[]" class="form-control satuan" required>
                                    <option value="pcs">Per Buah</option>
                                    <option value="lusin">Per Lusin</option>
                                    <option value="rol">Per Rol</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="harga_satuan[]" class="form-control harga-satuan" min="0"
                                    value="0" readonly>
                            </td>
                            <td>
                                <input type="number" min="1" name="jumlah[]" class="form-control jumlah text-center"
                                    value="1">
                            </td>
                            <td class="subtotal fw-semibold text-black">Rp 0</td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm hapus-baris">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mb-3">
                    <label class="fw-semibold">Total (Rp)</label>
                    <input type="text" id="total" name="total" class="form-control fw-bold text-black" readonly>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Bayar (Rp)</label>
                    <input type="number" id="bayar" name="bayar" class="form-control text-black" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Kembalian (Rp)</label>
                    <input type="text" id="kembalian" class="form-control fw-bold text-black" readonly>
                </div>

                <button class="btn btn-success" type="submit" id="submitTransaksi">
                    <i class="bi bi-save me-1"></i> Simpan Transaksi
                </button>
            </form>
        </div>
    </div>

    <!-- Filter & Riwayat Transaksi -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex gap-2 align-items-center">
            <label class="mb-0 fw-semibold">Pilih Bulan:</label>
            <input type="month" id="filterBulan" class="form-control w-auto"
                value="{{ request('bulan', date('Y-m')) }}">
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white fw-semibold">
            <i class="bi bi-receipt-cutoff me-1"></i> Riwayat Transaksi
        </div>

        <div class="card-body">
            <table class="table table-bordered text-center align-middle" id="tabelRiwayat">
                <thead class="table-secondary">
                    <tr>
                        <th>Tanggal</th>
                        <th>Detail Barang</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transaksis as $t)
                    <tr>
                        <td>{{ $t->tanggal }}</td>
                        <td class="text-start">
                            @foreach($t->details as $item)
                            • {{ $item->barang->nama_barang }} ({{ $item->jumlah }}) - Rp
                            {{ number_format($item->subtotal) }} <br>
                            @endforeach
                        </td>
                        <td class="fw-semibold text-black">Rp {{ number_format($t->total) }}</td>
                        <td class="text-black">Rp {{ number_format($t->bayar) }}</td>
                        <td class="fw-semibold text-black">Rp {{ number_format($t->kembalian) }}</td>
                        <td>
                            <a href="{{ route('transaksi.cetak', $t->id) }}" target="_blank"
                                class="btn btn-sm btn-primary">
                                <i class="bi bi-printer"></i> Cetak
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- Modal Uang Kurang -->
<div class="modal fade" id="modalUangKurang" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="bi bi-x-circle-fill me-1"></i> Pembayaran Kurang
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Pembayaran tidak mencukupi total transaksi.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Stok Over -->
<div class="modal fade" id="modalStokOver" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-warning">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Stok Melebihi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Jumlah barang melebihi stok yang tersedia.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Style Tambahan -->
<style>
.hasil-pencarian {
    position: absolute;
    top: 45px;
    left: 0;
    width: 100%;
    background: #fff;
    border: 1px solid #ced4da;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 9999;
    max-height: 250px;
    overflow-y: auto;
    display: none;
}

.list-group-item {
    padding: 10px 14px;
    cursor: pointer;
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.list-group-item:hover {
    background: #f0f8ff;
}

.disabled-item {
    background: #f8d7da !important;
    color: #721c24 !important;
    cursor: not-allowed !important;
}

.over-stok {
    background: #ffdddd !important;
}

/* Warna teks kolom Nama Barang */
.nama-barang {
    color: #000;
}

.nama-barang::placeholder {
    color: #6c757d;
}

/* Dark mode */
body.dark-mode .nama-barang {
    color: #FFF;
}

body.dark-mode .nama-barang::placeholder {
    color: #AAA;
}

/* Warna harga di total, bayar, kembalian */
#total,
#bayar,
#kembalian {
    color: #000;
}

body.dark-mode #total,
body.dark-mode #bayar,
body.dark-mode #kembalian {
    color: #FFF;
}
</style>

<!-- Script -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    const formatRupiah = x => "Rp " + new Intl.NumberFormat("id-ID").format(x);
    const getNum = v => parseInt(String(v).replace(/\D/g, "")) || 0;

    const hitungHargaSatuan = tr => {
        let hargaDasar = parseInt(tr.querySelector(".harga-dasar").value || 0);
        let satuan = tr.querySelector(".satuan").value;
        let harga = hargaDasar;
        if (satuan === "lusin") harga *= 12;
        if (satuan === "rol") harga *= 10;
        tr.querySelector(".harga-satuan").value = harga;
        return harga;
    }

    const hitungTotal = () => {
        let total = 0,
            valid = true;
        document.querySelectorAll("#tabelBarang tbody tr").forEach(tr => {
            let jumlahInput = parseInt(tr.querySelector(".jumlah").value || 0);
            let stok = parseInt(tr.querySelector(".stok-barang").value || 0);
            tr.querySelector(".jumlah").style.color = stok <= 0 ? 'red' : 'black';
            if (jumlahInput > stok) {
                tr.classList.add("over-stok");
                valid = false;
            } else tr.classList.remove("over-stok");
            let subtotal = hitungHargaSatuan(tr) * jumlahInput;
            tr.querySelector(".subtotal").textContent = formatRupiah(subtotal);
            total += subtotal;
        });
        document.getElementById("total").value = formatRupiah(total);
        let bayar = getNum(document.getElementById("bayar").value);
        document.getElementById("kembalian").value = formatRupiah(bayar - total);
        return valid;
    }

    document.getElementById("tambahBarang").addEventListener("click", () => {
        const tbody = document.querySelector("#tabelBarang tbody");
        const tr = tbody.querySelector("tr").cloneNode(true);
        tr.querySelectorAll("input").forEach(i => i.value = i.classList.contains("jumlah") ? 1 : "");
        tr.querySelectorAll(".subtotal").forEach(s => s.textContent = "Rp 0");
        tbody.appendChild(tr);
        initAutocomplete(tr.querySelector(".nama-barang"));
    });

    document.querySelector("#tabelBarang tbody").addEventListener("click", e => {
        if (e.target.closest(".hapus-baris")) {
            e.target.closest("tr").remove();
            hitungTotal();
        }
    });

    document.querySelector("#tabelBarang tbody").addEventListener("input", e => {
        if (e.target.classList.contains("jumlah") || e.target.classList.contains("satuan"))
            hitungTotal();
    });

    document.getElementById("bayar").addEventListener("input", hitungTotal);

    document.getElementById("formTransaksi").addEventListener("submit", e => {
        let totalValid = hitungTotal();
        let bayar = getNum(document.getElementById("bayar").value);
        let total = getNum(document.getElementById("total").value);

        if (!totalValid) {
            e.preventDefault();
            new bootstrap.Modal(document.getElementById("modalStokOver")).show();
            return false;
        }
        if (bayar < total) {
            e.preventDefault();
            new bootstrap.Modal(document.getElementById("modalUangKurang")).show();
            return false;
        }
    });

    function initAutocomplete(input) {
        const hasil = input.nextElementSibling;
        input.addEventListener("input", function() {
            let query = this.value.trim();
            if (!query) return hasil.style.display = 'none';
            fetch(`/barang/search?keyword=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    hasil.innerHTML = '';
                    data.forEach(b => {
                        const item = document.createElement('div');
                        item.classList.add('list-group-item');
                        if (b.stok <= 0) item.classList.add('disabled-item');
                        item.innerHTML =
                            `<span>${b.nama_barang}</span><small class="text-muted">Stok: ${b.stok} | Rp ${b.harga.toLocaleString('id-ID')}</small>`;
                        item.addEventListener('click', () => {
                            if (b.stok <= 0) return;
                            input.value = b.nama_barang;
                            input.closest('td').querySelector('.barang-id').value =
                                b.id;
                            input.closest('td').querySelector('.harga-dasar')
                                .value = b.harga;
                            input.closest('td').querySelector('.stok-barang')
                                .value = b.stok;
                            hasil.style.display = 'none';
                            hitungTotal();
                        });
                        hasil.appendChild(item);
                    });
                    hasil.style.display = data.length ? 'block' : 'none';
                });
        });
        document.addEventListener('click', e => {
            if (!input.contains(e.target) && !hasil.contains(e.target)) hasil.style.display = 'none';
        });
    }

    document.querySelectorAll(".nama-barang").forEach(initAutocomplete);

    document.getElementById("filterBulan").addEventListener("change", e => {
        window.location.href = `?bulan=${e.target.value}`;
    });
});
</script>
@endsection