@extends('admin.layout')
@section('title', 'Halaman Detail Transaksi MMTop')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h5>DATA DETAIL TRANSAKSI</h5>
                <a class="btn btn-warning" href="{{ URL::to('/order-barang') }}">Back</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Stok Sebelumnya</th>
                                <th>Jumlah Keluar</th>
                                <th>Sisa Stok</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detail_transaksi as $no => $dt)
                                <tr>
                                    <td>{{ $no + 1 }}</td>
                                    <td>{{ $dt->kode_barang }}</td>
                                    <td>{{ $dt->kode_barang }}</td>
                                    <td>{{ $dt->satuan->satuan }}</td>
                                    <td>{{ $dt->stok_sebelumnya }}</td>
                                    <td>{{ $dt->jumlah }}</td>
                                    <td>{{ $dt->sisa_stok }}</td>
                                    <td>Rp.{{ number_format($dt->harga_satuan, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="7">Sub Total:</th>
                                <td>Rp.{{ number_format($transaksi->sub_total, 2, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!---Container Fluid-->
    </div>
@stop
