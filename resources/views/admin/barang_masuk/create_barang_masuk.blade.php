@extends('admin.layout')
@section('title', 'Halaman Tambah Barang Masuk')

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h5>TAMBAH BARANG</h5>
            </div>
            <div class="card-body">
                <form id="formTambah" method="post">
                    @csrf()
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_barang">Barang</label>
                            <select required name="kode_barang" id="kode_barang" class="form-control">
                                <option value="" disabled selected hidden>-- Pilih Barang --</option>
                                @foreach ($barang as $br)
                                    <option value="{{ $br->kode_barang }}">{{ $br->nama }}</option>
                                @endforeach
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="supplier_id">Supplier</label>
                            <select required name="supplier_id" id="supplier_id" class="form-control">
                                <option value="" disabled selected hidden>-- Pilih Supplier --</option>
                                @foreach ($supplier as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->nama }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah Stok Masuk</label>
                            <input required type="number" min="1" name="jumlah" id="jumlah" value="1"
                                class="form-control">
                            <span class="alert-barang-kosong text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan Barang</label>
                            <input readonly type="text" required id="satuan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="jumlah_sebelumnya">Jumlah Stok Sebelumnya</label>
                            <input readonly type="number" required name="jumlah_sebelumnya" id="jumlah_sebelumnya"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="total_stok">Total</label>
                            <input readonly type="number" required name="total_stok" id="total_stok" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="penerima">Penerima</label>
                            <input type="text" required name="penerima" id="penerima" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <select required name="satuan_id" class="form-control" id="satuan">
                                <option value="" disabled hidden selected>-- Pilih Satuan --</option>
                                @foreach ($satuans as $satuan)
                                    <option value="{{ $satuan->id }}">{{ $satuan->satuan }}</option>
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


@section('modal')
    <!-- Modal tambah -->
    <div class="modal fade" id="modalTambahData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formTambahBarang" method="post">
                    @csrf()
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang</label>
                            <input type="type" readonly value="{{ $kode_barang }}" name="kode_barang" id="kode_barang"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="type" name="nama_barang" id="nama" class="form-control">
                            <!-- </div>
                                                                                                                                                                                                                                                                                                                                                            <div class="form-group">
                                                                                                                                                                                                                                                                                                                                                                <label for="jumlah">Jumlah</label> -->
                            <input type="hidden" name="jumlah" id="jumlah" value="0" class="form-control">
                            <!-- </div> -->
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <select name="satuan" class="form-control" id="satuan">
                                    <option value="" disabled hidden selected>-- Pilih Satuan --</option>
                                    <option value="pcs">pcs</option>
                                    <option value="btg">btg</option>
                                    <option value="lb">lb</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {

            //check if barang jika tidak ada di data barang
            $(document).on('change', '#kode_barang', function() {
                const value = $(this).val();
                if (value === 'lainnya') {
                    location.href = "/barang-masuk"
                    // $('#modalTambahData').modal('show');
                }
            })
            //end


            $(document).on('submit', '#formTambah', function(e) {
                e.preventDefault();
                const data = $(this).serialize();

                $.ajax({
                    url: '/barang-masuk',
                    data: data,
                    dataType: 'json',
                    type: 'post',
                    success: function(hasil) {
                        if (hasil) {
                            $('#modalTambah').modal('hide')
                            Swal.fire(
                                'sukses',
                                'sukses menambah data',
                                'success'
                            ).then(() => {
                                document.location.href = '/barang-masuk';
                            })
                        } else {
                            Swal.fire(
                                'Gagal',
                                'gagal menambah data',
                                'error'
                            )
                        }
                    }
                })
            })
            //end

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
                        $('#jumlah_sebelumnya').val(jumlah);
                        const total = parseInt(jumlah) + parseInt(jumlah_masuk);
                        $('#total_stok').val(total);
                        $('#satuan').val(result.satuan.satuan)
                    }
                })
            })
        })
    </script>
@endsection
