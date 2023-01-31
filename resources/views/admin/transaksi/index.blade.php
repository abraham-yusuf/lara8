@extends('admin.layout')
@section('title', 'Halaman Transaksi MMTop')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h5>DATA TRANSAKSI</h5>
                <a class="btn btn-primary" href="{{ route('transaksi.create') }}">Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomer Faktur</th>
                                <th>Nama Customer</th>
                                <th>Tanggal Transaksi</th>
                                <th>Total Harga</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $no => $dt)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $dt->nomer_faktur }}</td>
                                    <td>{{ $dt->customer->nama . '-' . $dt->customer->nik }}</td>
                                    <td>{{ $dt->tanggal_transaksi }}</td>
                                    <td>Rp.{{ number_format($dt->sub_total, 2, ',', '.') }}</td>
                                    <td class="d-flex">
                                        @if (auth()->user()->role == 'kasir' || auth()->user()->role === 'manager')
                                            <button data-id="{{ $dt->nomer_faktur }}" id="btn-hapus"
                                                class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                            <a href="{{ URL::to('/transaksi/detail/' . $dt->nomer_faktur) }}"
                                                class="btn btn-info btn-sm"><i class="fa fa-info"></i></a>
                                            <a href="{{ URL::to('/cetak-faktur/pdf/' . $dt->nomer_faktur) }}"
                                                class="btn btn-info btn-sm"><i class="fas fa-file-invoice"></i></a>
                                            {{-- <a href="/detail-barang-keluar/{{ $dt->nomer_faktur }}"
                                                class="btn btn-info btn-sm"><i class="fas fa-check"></i></a> --}}
                                        @else
                                            <a href="{{ URL::to('/transaksi/detail/' . $dt->nomer_faktur) }}"
                                                class="btn btn-info btn-sm"><i class="fa fa-info"></i></a>
                                        @endif
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
    <!-- Modal detail -->
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
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
                            url: `/barang-keluar/${id}`,
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
            $(document).on('click', '#btn-detail', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: `/barang-keluar/${id}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(hasil) {
                        $(`.detail-barang`).html(`
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_keluar">No PO</label>
                                <input type="text" readonly name="no_keluar" readonly value="${hasil.no_keluar}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="no_surat_jalan">No Surat jalan</label>
                                <input type="text" name="no_surat_jalan" readonly value="${hasil.no_surat_jalan}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_keluar">Tanggal Keluar</label>
                                <input required type="text" readonly name="tgl_keluar"  value="${hasil.created_at}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="yg_mengeluarkan">Yang Mengeluarkan</label>
                                <input readonly required type="text"  value="${hasil.yg_mengeluarkan}" name="yg_mengeluarkan" id="yg_mengeluarkan"  class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_barang">Barang</label>
                        <input readonly type="text" value="${hasil.barang.nama_barang}"  name="sisa_stok" id="sisa_stok" min="1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input required type="number"  value="${hasil.jumlah}" readonly name="jumlah" id="jumlah" min="1" value="" class="form-control">
                        <span class="alert-barang-kosong text-danger"></span>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Sebelumnya</label>
                        <input readonly type="number"  value="${hasil.jumlah_sebelumnya}"  name="jumlah_sebelumnya" id="jumlah_sebelumnya" min="1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Sisa Stok</label>
                        <input readonly type="number"  value="${hasil.sisa_stok}"  name="sisa_stok" id="sisa_stok" min="1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label id="satuan">Satuan</label>
                        <input readonly type="text"  value="${hasil.satuan}"  name="sisa_stok" id="sisa_stok" min="1" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary" href="/barang-keluar">Cancle</a>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
               `);
                        $('#modalDetail').modal('show');
                    }
                })
            })

        })
    </script>

@stop
