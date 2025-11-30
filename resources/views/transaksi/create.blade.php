@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('transaksi.store') }}" method="POST">
        @csrf

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tbody-barang">
                <tr>
                    <td style="width: 30%">
                        <input type="text" class="form-control cari-barang" placeholder="Cari barang...">
                        <div class="hasil-pencarian mt-2"></div>

                        <input type="hidden" name="barang_id[]" class="barang-id">
                        <input type="hidden" name="stok[]" class="stok-barang">
                    </td>

                    <td class="harga fw-semibold text-black" data-harga="0">Rp 0</td>

                    <td>
                        <input type="number" min="1" name="jumlah[]" class="form-control jumlah" value="1">
                    </td>

                    <td class="subtotal fw-semibold text-black">Rp 0</td>

                    <td>
                        <button type="button" class="btn btn-outline-danger btn-sm hapus-baris">🗑</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="button" class="btn btn-success mb-3" id="tambah-baris">+ Tambah Barang</button>

        <div class="mb-3">
            <label>Total Bayar</label>
            <input type="number" name="bayar" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    // Cari Barang
    $(document).on('input', '.cari-barang', function() {
        let keyword = $(this).val();
        let hasil = $(this).closest('td').find('.hasil-pencarian');

        if (keyword.length < 1) {
            hasil.html('');
            return;
        }

        $.ajax({
            url: "{{ route('barang.search') }}",
            type: "GET",
            data: {
                keyword: keyword
            },
            success: function(data) {
                if (data.length === 0) {
                    hasil.html(
                        '<div class="list-group-item text-danger">Barang tidak ditemukan</div>'
                    );
                    return;
                }

                let list = '<div class="list-group">';
                data.forEach(item => {
                    list += `
                        <button type="button" class="list-group-item list-group-item-action pilih-barang"
                            data-id="${item.id}"
                            data-nama="${item.nama}"
                            data-harga="${item.harga}"
                            data-stok="${item.stok}"
                        >
                            ${item.nama} — Rp ${item.harga.toLocaleString()}
                        </button>
                    `;
                });
                list += '</div>';

                hasil.html(list);
            }
        });
    });

    $(document).on('click', '.pilih-barang', function() {
        let tr = $(this).closest('tr');

        tr.find('.cari-barang').val($(this).data('nama'));
        tr.find('.barang-id').val($(this).data('id'));
        tr.find('.stok-barang').val($(this).data('stok'));

        let harga = $(this).data('harga');
        tr.find('.harga').text('Rp ' + harga.toLocaleString());
        tr.find('.harga').data('harga', harga);

        let jumlah = tr.find('.jumlah').val();
        tr.find('.subtotal').text('Rp ' + (jumlah * harga).toLocaleString());

        $(this).closest('.hasil-pencarian').html('');
    });

    // Hitung Subtotal
    $(document).on('input', '.jumlah', function() {
        let tr = $(this).closest('tr');
        let harga = parseInt(tr.find('.harga').data('harga')) || 0;
        let jumlah = parseInt($(this).val()) || 1;

        tr.find('.subtotal').text('Rp ' + (jumlah * harga).toLocaleString());
    });

    $('#tambah-baris').click(function() {
        let row = $('#tbody-barang tr:first').clone();

        row.find("input").val("");
        row.find(".harga").text("Rp 0").data("harga", 0);
        row.find(".subtotal").text("Rp 0");
        row.find(".hasil-pencarian").html("");

        $('#tbody-barang').append(row);
    });

    $(document).on('click', '.hapus-baris', function() {
        if ($('#tbody-barang tr').length > 1) {
            $(this).closest('tr').remove();
        }
    });

});
</script>
@endsection