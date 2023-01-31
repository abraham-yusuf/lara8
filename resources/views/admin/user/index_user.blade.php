@extends('admin.layout')
@section('title', 'Halaman User MMTop')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h5>DATA USER</h5>
                <button data-toggle="modal" data-target="#modalTambahData" class="btn btn-success btn-sm">Tambah</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="datatable">
                        <thead>
                            <tr class="">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Nomer Telepon</th>
                                <th>Avatar</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $no => $dt)
                                <tr>
                                    <td class="align-middle">{{ $no + 1 }}</td>
                                    <td class="align-middle">{{ $dt->nama }}</td>
                                    <td class="align-middle">{{ $dt->username }}</td>
                                    <td class="align-middle">{{ $dt->role }}</td>
                                    <td class="align-middle">{{ $dt->nomer_tlpn }}</td>
                                    <td><img width="50"
                                            src="{{ $dt->avatar ? env('APP_URL') . $dt->avatar : 'https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png' }}"
                                            alt="user image"></td>
                                    <td class="text-center">
                                        <button data-id="{{ $dt->id }}" id="btn-edit"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                                        <button data-id="{{ $dt->id }}" id="btn-hapus"
                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </td>
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
                            <label for="nama">Nama</label>
                            <input type="type" name="nama" id="nama" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="type" name="username" id="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="level">Level</label>
                            <select name="level" id="level" class="custom-select">
                                <option value="" disabled hidden selected>-- Piliih Role --</option>
                                <option value="administrasi">Administrasi</option>
                                <option value="gudang">Gudang</option>
                                <option value="manager">Manager</option>
                                <option value="kasir">Kasir</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status_aktif">Status Aktif</label>
                            <select name="status_aktif" id="status_aktif" class="custom-select">
                                <option value="" disabled hidden selected>-- Piliih Status Aktif --</option>
                                <option value="aktif">Aktif</option>
                                <option value="tidak">Tidak</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="type" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nomer_tlpn">Nomer Telepon</label>
                            <input type="type" name="text" id="nomer_tlpn" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Comfirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="avatar">Avatar</label>
                            <input type="file" name="avatar" id="avatar" class="form-control">
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
    <!-- modal edit data -->
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
                const data = new FormData(document.querySelector('#formTambah'));

                //check extensi avatar
                const foto = $('#avatar').val();
                if (!foto.match(/.(jpg|png|jpeg|gift)$/i)) {
                    Swal.fire(
                        'Opss',
                        'extensi file anda salah',
                        'warning'
                    )
                    return false;
                }

                checkEmail($('#email').val());
                $.ajax({
                    url: '/user',
                    data: data,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: true,
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
                            url: `/user/${id}`,
                            method: 'delete',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            dataType: 'json',
                            success: function(hasil) {
                                console.log(hasil);
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
                    url: `/user/${id}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(hasil) {
                        $(`#formEditData`).html(`
                    @csrf()
                    <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="type" name="nama" id="nama" value="${hasil.nama}" class="form-control">
                        <input type="hidden" id="id" value="${hasil.id}">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="type" name="username" id="username" value="${hasil.username}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="Role">Role</label>
                        <select name="role" id="role" class="custom-select">
                            <option value="" disabled hidden selected>-- Piliih Role --</option>
                            <option ${hasil.role === 'administrasi'?'selected':''} value="administrasi">Administrasi</option>
                            <option ${hasil.role === 'gudang'?'selected':''} value="gudang">gudang</option>
                            <option ${hasil.role === 'manager'?'selected':''} value="manager">Manager</option>
                            <option ${hasil.role === 'kasir'?'selected':''} value="kasir">Kasir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status_aktif">Status Aktif</label>
                        <select name="status_aktif" id="status_aktif" class="custom-select">
                            <option value="" disabled hidden selected>-- Piliih Status Aktif --</option>
                            <option ${hasil.status_aktif === 'aktif'?'selected':''} value="aktif">Aktif</option>
                            <option ${hasil.status_aktif === 'tidak'?'selected':''} value="tidak">Tidak</option>
                        </select>
                    </div>
                    <div class="form-group">
                            <label for="nomer_tlpn">Nomer Telepon</label>
                            <input type="type" name="text" id="nomer_tlpn" value="${hasil.nomer_tlpn}" class="form-control">
                        </div>
                    <div class="form-group">
                        <label class="d-block">Image</label>
                        <img class="d-block" width="150" src="{{ env('APP_URL') }}${hasil.avatar}" alt="image sub">
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
                                `<input class="form-control-file mt-3" required="" type="file" name="avatar" class="form-control">`
                            );
                        })
                        $('#modalEdit').modal('show');
                    }
                })
            })
            //edit data
            $(document).on('submit', '#formEditData', function(e) {
                e.preventDefault();
                const data = new FormData(document.querySelector('#formEditData'));
                data.append('_method', 'PUT')
                //check extensi avatar
                const foto = $('#avatar').val();
                if (foto != undefined && foto != "") {
                    if (!foto.match(/.(jpg|png|jpeg|gift)$/i)) {
                        Swal.fire(
                            'Opss',
                            'extensi file anda salah',
                            'warning'
                        )
                        return false;
                    }
                }
                const id = $('#id').val();
                $.ajax({
                    url: '/user/' + id,
                    data: data,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: true,
                    method: "POST",
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
