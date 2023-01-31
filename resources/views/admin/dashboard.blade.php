@extends('admin.layout')
@section('title', 'Dashboard MMTop')
@section('content')
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">

        <div class="card">
            <div class="card-header" style="background-color: mintcream">
                <h2 align="center" style="font-weight: bold">Selamat Datang {{ auth()->user()->nama }}</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Total Uang Yang Masuk Hari Ini:</h6>
                                <p class="card-text"><b>Rp.{{ number_format($total_price, 2, ',', '.') }}</b>
                                </p>
                                {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Total Pembeli Hari Ini:</h6>
                                <p class="card-text text-bold"><b>{{ $total_transaksi }} Pembeli</b>
                                </p>
                                {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">Total Customer:</h6>
                                <p class="card-text"><b>{{ $total_customer }} Customer</b>
                                </p>
                                {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!---Container Fluid-->
    </div>
@stop

@section('javascript')

@stop
