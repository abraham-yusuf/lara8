@extends('admin.layout')
@section('title', 'Halaman Customer MMTop')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h5>DATA CUSTOMER</h5>
                <button data-toggle="modal" data-target="#modalTambahData" class="btn btn-success btn-sm">Tambah</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Nomer Telepon</th>
                                @if (auth()->user()->role == 'kasir' || auth()->user()->role == 'manager')
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $no => $dt)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $dt->nik }}</td>
                                    <td>{{ $dt->nama }}</td>
                                    <td>{{ $dt->alamat }}</td>
                                    <td>{{ $dt->nomer_tlpn }}</td>
                                    @if (auth()->user()->role == 'kasir' || auth()->user()->role == 'manager')
                                        <td class="text-center">
                                            <button data-id="{{ $dt->nik }}" id="btn-edit"
                                                class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                                            <button data-id="{{ $dt->nik }}" id="btn-hapus"
                                                class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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
                <form id="formTambah" method="post">
                    @csrf()
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nik">NIK</label>
                            <input type="type" name="nik" id="nik" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="type" name="nama" id="nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nomer_tlpn">Nomer Telepon</label>
                            <input type="type" name="nomer_tlpn" id="nomer_tlpn" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="3"></textarea>
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body detail-barang">

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
                const data = $(this).serialize();

                $.ajax({
                    url: '/customer',
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

            //check email
            function checkEmail(email) {
                $.ajax({
                    url: `/user`,
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        email,
                        checkEmail: true
                    },
                    dataType: 'json',
                    success: function(hasil) {
                        if (hasil) {
                            Swal.fire(
                                'Opss',
                                'email already exists',
                                'warning'
                            )
                            return false;
                        }
                    }
                })
            }

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
                            url: `/customer/${id}`,
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
                    url: `/customer/${id}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(hasil) {
                        $(`#formEditData`).html(`
                    @csrf()
                    <div class="modal-body">
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input type="type" name="nik" id="nik" value="${hasil.nik}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="type" name="nama" id="nama" value="${hasil.nama}" class="form-control">
                        <input type="hidden" id="nik_key" value="${hasil.nik}" >
                    </div>
                    <div class="form-group">
                        <label for="nomer_tlpn">Nomer Telepon</label>
                        <input type="type" name="nomer_tlpn" id="nomer_tlpn" value="${hasil.nomer_tlpn}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="3">${hasil.alamat}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
               `);
                        $('#modalEdit').modal('show');
                    }
                })
            })
            //edit data
            $(document).on('submit', '#formEditData', function(e) {
                e.preventDefault();
                const nik = $('#nik_key').val();
                $.ajax({
                    url: '/customer/' + nik,
                    data: $(this).serialize(),
                    dataType: 'json',
                    method: "PUT",
                    success: function(hasil) {
                        if (hasil) {
                            $('#modalEdit').modal('hide');
                            Swal.fire(
                                'sukses',
                                'sukses edit data',
                                'success'
                            )
                        } else {
                            Swal.fire(
                                'Gagal',
                                'gagal edit data',
                                'error'
                            )
                        }
                        setTimeout(() => {
                            location.reload();
                        }, 800);
                    }
                })
            })
        })
    </script>

@stop
