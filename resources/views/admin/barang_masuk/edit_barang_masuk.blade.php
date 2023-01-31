@extends('admin.layout')
@section('title', 'Halaman Edit Barang Masuk MMTop')

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h5>EDIT BARANG MASUK</h5>
            </div>
            <div class="card-body">
                <form id="formEditData" method="post">
                    @csrf()
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_barang">Barang</label>
                            <select required name="kode_barang" id="kode_barang" class="form-control">
                                <option value="" disabled selected hidden>-- Pilih Barang --</option>
                                @foreach ($barang as $br)
                                    <option {{ $br->kode_barang == $barangMasuk->kode_barang ? 'selected' : '' }}
                                        value="{{ $br->kode_barang }}">{{ $br->nama }}</option>
                                @endforeach
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="supplier_id">Supplier</label>
                            <select required name="supplier_id" id="supplier_id" class="form-control">
                                <option value="" disabled selected hidden>-- Pilih Barang --</option>
                                @foreach ($supplier as $sup)
                                    <option {{ $sup->id == $barangMasuk->supplier_id ? 'selected' : '' }}
                                        value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah Stok Masuk</label>
                            <input required type="number" min="1" name="jumlah" id="jumlah"
                                value="{{ $barangMasuk->jumlah }}" class="form-control">
                            <span class="alert-barang-kosong text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="jumlah_sebelumnya">Jumlah Sebelumnya</label>
                            <input readonly type="number" value="{{ $barangMasuk->jumlah_sebelumnya }}" required
                                name="jumlah_sebelumnya" id="jumlah_sebelumnya" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="total_stok">Total</label>
                            <input readonly type="number" value="{{ $barangMasuk->total_stok }}" required name="total_stok"
                                id="total_stok" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="penerima">Penerima</label>
                            <input type="text" required name="penerima" value="{{ $barangMasuk->penerima }}" id="penerima"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <select required name="satuan_id" class="form-control" id="satuan">
                                <option value="" disabled hidden selected>-- Pilih Satuan --</option>
                                @foreach ($satuans as $satuan)
                                    <option {{ $satuan->id == $barangMasuk->satuan_id ? 'selected' : '' }}
                                        value="{{ $satuan->id }}">{{ $satuan->satuan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" href="/barang-masuk">Cancel</a>
                        <button id="btn-add" type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            //edit data
            $(document).on('submit', '#formEditData', function(e) {
                e.preventDefault();
                const id = "{{ $barangMasuk->id }}"
                $.ajax({
                    url: '/barang-masuk/' + id,
                    data: $(this).serialize(),
                    dataType: 'json',
                    method: "PUT",
                    success: function(hasil) {
                        if (hasil) {
                            Swal.fire(
                                'sukses',
                                'sukses edit data',
                                'success'
                            ).then(() => {
                                document.location.href = '/barang-masuk';
                            })
                        } else {
                            Swal.fire(
                                'Gagal',
                                'gagal edit data',
                                'error'
                            )
                        }
                    }
                })
            })
            //check stok
            $(document).on('keyup change', '#jumlah', function() {
                const kode_barang = $('#kode_barang').val();
                var jumlah_masuk = $('#jumlah').val();
                $('.alert-barang-kosong').html(``);
                if (kode_barang === undefined || kode_barang === '' || kode_barang === null) {
                    $('.alert-barang-kosong').html(`Barang Harus Di Pilih Dahulu`);
                    $('#btn-add').attr('disabled', 'disabled');
                    return false;
                }
                $.ajax({
                    url: '/barang-masuk',
                    data: {
                        checkStok: true,
                        kode_barang,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function(result) {
                        let jumlah = result.jumlah;
                        $('#jumlah_sebelumnya').val(parseInt(jumlah) -
                            {{ $barangMasuk->jumlah }});
                        const total = (parseInt(jumlah) - {{ $barangMasuk->jumlah }}) + parseInt(
                            jumlah_masuk);
                        $('#total_stok').val(total);
                    }
                })
            })
        })
    </script>
@endsection
