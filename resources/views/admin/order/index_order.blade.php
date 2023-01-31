@extends('admin.layout')
@section('title','Halaman Order MMTop')
@section('content')
<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between">
            <h5>DATA ORDER</h5>
            @if (auth()->user()->role === 'sales')
            <button data-toggle="modal" data-target="#modalTambahData" class="btn btn-success btn-sm">Tambah</button>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="datatable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Customer</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order as $no=>$dt)
                        <tr>
                            <td>{{$no+1}}</td>
                            <td>{{$dt->Barang->nama_barang}}</td>
                            <td>{{$dt->Customer->nama}}</td>
                            <td>{{$dt->jumlah}}</td>
                            <td><span style="background-color: green; padding: 5px; border-radius: 20px; color: white">{{$dt->status}}</span></td>
                            <td>{{$dt->keterangan}}</td>
                            @if (auth()->user()->role === 'administrasi')
                            <td><button data-id="{{$dt->id}}" id="btn-close" class="btn btn-success btn-sm"><i class="fas fa-tasks"></i></button></td>
                            @endif
                            @if (auth()->user()->role === 'sales' || auth()->user()->role === 'manager')
                            <td class="text-center">
                                <button data-id="{{$dt->id}}" id="btn-edit" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                                <button data-id="{{$dt->id}}" id="btn-hapus" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </td>
                            @endif
                            @if (auth()->user()->role === 'gudang')
                            <td class="text-center">
                                <button data-id="{{$dt->id}}" id="btn-ready-stok" class="btn btn-primary btn-sm"><i class="fas fa-check-square"></i></button>
                                <button data-id="{{$dt->id}}" id="btn-modal-stok" class="btn btn-warning btn-sm"><i class="far fa-calendar-times"></i></button>
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
                        <label for="invoice">Invoice</label>
                        <input type="type" readonly value="{{$invoice}}" name="invoice" id="invoice" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Customer</label>
                        <select required class="custom-select" name="id_customer" id="id_customer">
                            <option value="" disabled selected hidden>-- Select Email Customer --</option>
                            @foreach ($customer as $cus)
                            <option value="{{$cus->id}}">{{$cus->nama}}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_barang">Barang</label>
                        <select required class="custom-select" name="id_barang" id="id_barang">
                            <option value="" disabled selected hidden>-- Select Barang --</option>
                            @foreach ($barang as $bar)
                            <option value="{{$bar->id}}">{{$bar->nama_barang}}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input required type="type" name="jumlah" id="jumlah" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea required class="form-control" name="keterangan" id="keterangan" cols="30" rows="3"></textarea>
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
<!-- Modal stok not ready -->
<div class="modal fade" id="modalStokNotReady" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Stok Tidak tersedia, kasih keterangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="fromStokNotready" method="post">

                </form>
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
        $(document).on('submit', '#formTambah',  function(e) {
            e.preventDefault();
            const data = $(this).serialize();

            $.ajax({
                url: '/order',
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
        function checkEmail(email){
            $.ajax({
                url: `/user`,
                method: 'post',
                data: {
                    "_token": "{{csrf_token()}}",
                    email,
                    checkEmail: true
                },
                dataType: 'json',
                success: function(hasil) {
                      if(hasil){
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
                        url: `/order/${id}`,
                        method: 'delete',
                        data: {
                            "_token": "{{csrf_token()}}",
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
                url: `/order/${id}`,
                method: 'GET',
                dataType: 'json',
                success: function(hasil) {
                    $(`#formEditData`).html(`
                    @csrf()
                    <div class="modal-body">
                    <div class="form-group">
                        <label for="invoice">Invoice</label>
                        <input type="type" readonly value="${hasil.invoice}" name="invoice" id="invoice" class="form-control">
                        <input type="hidden"  value="${hasil.id}" id="id">
                    </div>
                    <div class="form-group">
                        <label>Customer</label>
                        <select required class="custom-select" name="id_customer" id="id_customer">
                            <option value="" disabled selected hidden>-- Select Customer --</option>
                            @foreach ($customer as $cus)
                            <option ${hasil.id_customer === <?= $cus->id ?>?'selected':''} value="{{$cus->id}}">{{$cus->nama}}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_barang">Barang</label>
                        <select required class="custom-select" name="id_barang" id="id_barang">
                            <option value="" disabled selected hidden>-- Select Barang --</option>
                            @foreach ($barang as $bar)
                            <option ${hasil.id_barang === <?= $bar->id ?>?'selected':''} value="{{$bar->id}}">{{$bar->nama_barang}}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" value="${hasil.jumlah}" min="1" name="jumlah" id="jumlah" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="3">${hasil.keterangan}</textarea>
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
            const id = $('#id').val();
            $.ajax({
                url: '/order/'+id,
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
        //ajax jika stok ready
        $(document).on('click', '#btn-ready-stok', function() {
            const id = $(this).data('id');
            $.ajax({
                url: `/order/ready-stok/${id}`,
                method: 'GET',
                dataType: 'json',
                success: function(hasil) {
                    if (hasil) {
                        Swal.fire(
                            'sukses',
                            'sukses ganti status ke stok tersedia',
                            'success'
                        )
                    } else {
                        Swal.fire(
                            'Gagal',
                            'gagal',
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
        //btn modal show modal stok
        $(document).on('click', '#btn-modal-stok', function() {
            const id = $(this).data('id');
            $('#fromStokNotready').html(` @csrf
            <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden"  value="${id}" id="id">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="3"></textarea>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
                    `);
            $('#modalStokNotReady').modal('show')

        })
        //end
        //ajax jika stok tidak tersedia
        $(document).on('submit', '#fromStokNotready', function(e) {
            e.preventDefault();
            const id = $('#id').val();
            $.ajax({
                url: '/order/stok-notready/'+id,
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
        //end
        //aksi close
        $(document).on('click', '#btn-close', function(e){
            e.preventDefault();
            const id = $(this).data('id');
            console.log(id);
            $.ajax({
                url: '/order/order-close/'+id,
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
        //end
    })
</script>

@stop
