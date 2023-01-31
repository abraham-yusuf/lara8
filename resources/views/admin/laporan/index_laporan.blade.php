@extends('admin.layout')
@section('title', 'Halaman Laporan MMTop')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">

        <div class="card">
            <div class="card-header">
                <h5>HALAMAN LAPORAN MMTOP</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('report-pdf') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <select name="option-report" id="option-report" class="form-control">
                            <option value="all">Semua Data</option>
                            <option value="range-date">Berdasarkan Tanggal</option>
                        </select>
                    </div>
                    <div class="from-group" id="box-range-date">

                    </div>
                    <div class="form-group">
                        <label for="laporan">Type Laporan</label>
                        <select required name="laporan" id="laporan" class="custom-select">
                            <option value="" disabled hidden selected>-- Pilih Laporan --</option>
                            <option value="stok-akhir">Stok Akhir</option>
                            <option value="order">Order</option>
                            <option value="barang-masuk">Barang Masuk</option>
                            <option value="barang-keluar">Barang Keluar</option>
                            <option value="customer">Customer</option>
                            <option value="barang">Barang</option>
                        </select>
                    </div>
                    <button class="btn btn-success" type="submit">Save</button>
                </form>
            </div>
        </div>
        <!---Container Fluid-->
    </div>
@stop


@section('javascript')
    <script>
        $(document).on("change", "#option-report", function() {
            const optionReport = $(this).val();
            console.log(optionReport);
            $("#box-range-date").html(``)
            if (optionReport == 'range-date') {
                $("#box-range-date").html(`<div class="form-group">
                    <label for="dari">Dari</label>
                    <input type="date" name="dari" id="dari" class="form-control">
                </div>
                <div class="form-group">
                    <label for="sampai">Sampai</label>
                    <input type="date" name="sampai" id="sampai" class="form-control">
                </div>`)
            }
        })
    </script>


@stop
