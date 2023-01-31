@extends('admin.layout')
@section('title', 'Halaman Data Barang MMTop')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h5>Data Barang</h5>
                <button data-toggle="modal" data-target="#modalTambahData" class="btn btn-success btn-sm">Tambah</button>
                {{-- @if (auth()->user()->role == 'admin')
                @endif --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                {{-- <th>Notif</th> --}}
                                <th>Satuan</th>
                                {{-- <th>Tanggal Kadaluarsa</th> --}}
                                <th>Harga</th>
                                @if (auth()->user()->role == 'gudang' || auth()->user()->role == 'manager')
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs as $no => $dt)
                                <tr>
                                    <td class="align-middle">{{ $no + 1 }}</td>
                                    <td class="align-middle">{{ $dt->nama }}</td>
                                    <td class="align-middle">{{ $dt->jumlah }}</td>
                                    {{-- <td class="align-middle">{{ $dt->notif }}</td> --}}
                                    <td class="align-middle">{{ $dt->satuan->satuan }}</td>
                                    {{-- <td class="align-middle">{{ $dt->tanggal_kadaluarsa }}</td> --}}
                                    <td class="align-middle">Rp.{{ number_format($dt->harga_satuan, 2, ',', '.') }}</td>
                                    @if (auth()->user()->role == 'gudang' || auth()->user()->role == 'manager')
                                        <td class="text-center">
                                            <div class="d-flex">
                                                <button data-id="{{ $dt->kode_barang }}" id="btn-edit"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                                                <button data-id="{{ $dt->kode_barang }}" id="btn-hapus"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                            </div>
                                            <button data-id="{{ $dt->kode_barang }}" id="btn-detail"
                                                class="btn btn-info btn-sm"><i class="fa fa-info"></i></button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!---Container Fluid-->
    </div>
@stop

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
                <form id="formTambah" method="post" enctype="multipart/form-data">
                    @csrf()
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang</label>
                            <input required type="type" readonly value="{{ $kode_barang }}" name="kode_barang"
                                id="kode_barang" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input required type="type" name="nama" id="nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input required type="type" name="jumlah" id="jumlah" class="form-control">
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
                        {{-- <div class="form-group">
                            <label for="notif">Notif</label>
                            <textarea class="form-control" name="notif" id="notif" cols="30" rows="3"></textarea>
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa</label>
                            <input required type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa"
                                class="form-control">
                        </div> --}}
                        <div class="form-group">
                            <label for="pic">Gambar</label>
                            <input required type="file" name="pic" id="pic" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="harga_satuan">Harga Satuan</label>
                            <input required type="number" name="harga_satuan" id="harga_satuan" class="form-control">
                        </div>
                        {{-- <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="3"></textarea>
                        </div> --}}
                        {{-- <div class="form-group">
                            <label for="aturan_pakai">Aturan Jual</label>
                            <textarea class="form-control" name="aturan_pakai" id="aturan_pakai" cols="30" rows="3"></textarea>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal tambah -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditData" method="post" enctype="multipart/form-data">

                </form>
            </div>
        </div>
    </div>
    <!-- Modal detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detail-barang">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //datatable
            let table = $('#datatable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                async: true
            })
            //add data
            $(document).on('submit', '#formTambah', function(e) {
                e.preventDefault();
                const data = new FormData(document.querySelector('#formTambah'));

                //check extensi avatar
                const foto = $('#pic').val();
                if (!foto.match(/.(jpg|png|jpeg|gift)$/i)) {
                    Swal.fire(
                        'Opss',
                        'extensi file anda salah',
                        'warning'
                    )
                    return false;
                }

                $.ajax({
                    url: '/barang',
                    data: data,
                    dataType: 'json',
                    type: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: true,
                    success: function(hasil) {
                        if (hasil) {
                            $('#modalTambah').modal('hide')
                            Swal.fire(
                                'sukses',
                                'sukses menambah data',
                                'success'
                            )
                        } else {
                            Swal.fire(
                                'Gagal',
                                'gagal menambah data',
                                'error'
                            )
                        }
                        setTimeout(() => {
                            location.reload();
                        }, 800);
                    }
                })
            })
            //end


            $(document).on('click', '#btn-hapus', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Kamu Yakin?',
                    text: "Kamu Akan Menghapus Data Ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: `/barang/${id}`,
                            method: 'delete',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            dataType: 'json',
                            success: function(hasil) {
                                if (hasil) {
                                    Swal.fire(
                                        'sukses',
                                        'sukses hapus data',
                                        'success'
                                    )
                                } else {
                                    Swal.fire(
                                        'Gagal',
                                        'gagal hapus data',
                                        'error'
                                    )
                                }
                                setTimeout(() => {
                                    location.reload();
                                }, 800);
                            }
                        })
                    }
                })
            })
            //btn show data
            $(document).on('click', '#btn-edit', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: `/barang/${id}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(hasil) {
                        $(`#formEditData`).html(`
                    @csrf()
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang</label>
                            <input required type="type" readonly
                                id="kode_barang" class="form-control" value="${hasil.kode_barang}">
                            <input required id="kode_barang" type="hidden" value="${hasil.kode_barang}">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input required type="type" value="${hasil.nama}" name="nama" id="nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input required type="type" value="${hasil.jumlah}" name="jumlah" id="jumlah" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <select required name="satuan_id" class="form-control" id="satuan">
                                <option value="" disabled hidden selected>-- Pilih Satuan --</option>
                                <?php foreach ($satuans as $satuan) : ?>
                                    <option ${hasil.satuan_id == {{ $satuan->id }}?"selected":""} value="{{ $satuan->id }}">{{ $satuan->satuan }}</option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pic">Gambar Barang</label>
                            <img src="${hasil.pic}" class="img-fluid d-block" width="100" alt="Responsive image">
                            <div id="box-image">
                            <button type="button" id="btn-edit-image" class="mt-2 btn btn-primary btn-sm">Ganti gambar</button>
                        </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
               `);
                        $('#btn-edit-image').on('click', function() {
                            $('#box-image').html(``);
                            $('#box-image').html(
                                `<input class="form-control-file mt-3" required="" type="file" name="pic" class="form-control">`
                            );
                        })
                        $('#modalEdit').modal('show');
                    }
                })
            })
            //edit data
            $(document).on('submit', '#formEditData', function(e) {
                e.preventDefault();
                const id = $('#kode_barang').val();
                $.ajax({
                    url: '/barang/' + id,
                    data: new FormData(document.querySelector('#formEditData')),
                    dataType: 'json',
                    method: "POST",
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: true,
                    success: function(hasil) {
                        if (hasil) {
                            $('#modalEdit').modal('hide');
                            Swal.fire(
                                'sukses',
                                'sukses edit data',
                                'success'
                            ).then(() => {
                                location.reload();
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
            //btn detail Barang
            $(document).on('click', '#btn-detail', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: `/barang/${id}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(hasil) {
                        $(`#detail-barang`).html(`<div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode_barang">Kode Barang</label>
                                    <input class="form-control" required id="kode_barang" readonly value="${hasil.kode_barang}">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input required type="type" readonly value="${hasil.nama}" name="nama" id="nama"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Satuan</label>
                                    <input required type="type" readonly value="${hasil.satuan.satuan}" name="nama" id="nama"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input required type="type" readonly value="${hasil.jumlah}" name="jumlah" id="jumlah"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pic">Gambar Barang</label>
                                <img src="${hasil.pic}" class="img-fluid d-block" width="200" alt="Responsive image">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>`);
                        $('#modalDetail').modal('show');
                    }
                })
            })
        })
    </script>

@stop
