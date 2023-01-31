<link href="{{ URL::asset('assets/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/ruangAdmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
    <div class="card">
        <div class="card-header">
            <div style="line-height: 7px; text-align: center; margin-bottom: 30px">
                <h2 style="font-weight: bold">MM Top Bakery</h2>
                <p>Kp. Rawa Lumpang</p>
                <p>Jl. Selembaran Jati, Kec. Kosambi,</p>
                <p>Kabupaten Tangerang, Banten 15214</p>
                <p>Tlp/WA : 0878-7781-0164 | Fax : (+628) 78-7781-0164</p>
            </div>
            <hr>
            <h3 class="text-center font-weight-bold mt-5">LAPORAN SURAT JALAN</h3>
        </div>
        <div class="card-body">
            <form action="./functionAll.php?aksi=insertBarangKeluar" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">No keluar</label>
                            <input readonly required type="text" value="{{ $barang_keluar->no_keluar }}"
                                name="noSuratJalan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">No Suarat Jalan</label>
                            <input readonly required type="text" value="{{ $barang_keluar->no_surat_jalan }}"
                                name="noSuratJalan" class="form-control">
                        </div>
                        {{-- <div class="form-group">
                            <label for="">Tanggal Pembuatan</label>
                            <input readonly required type="text" name="tglBuat" value="{{$barang_keluar->created_at}}" class="form-control">
                        </div> --}}

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Customer</label>
                            <input readonly class="form-control" type="text" readonly
                                value="{{ $barang_keluar->Customer->nama }}">
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Pengiriman</label>
                            <input readonly required type="text" name="tglKirim"
                                value="{{ $barang_keluar->created_at }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Alamat Customer</label>
                            <textarea readonly required class="form-control" name="alamatCustomer" id="alamatCustomer" cols="20"
                                rows="1">{{ $barang_keluar->Customer->alamat }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-dinamis">
                    <h3 class="mt-3 mb-3 font-font-weight-bold">DATA ORDER</h3>
                    <table class="table mt-4">
                        <thead>
                            <tr>
                                <th>Kode Part</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailKeluar as $item)
                                <tr>
                                    <td>{{ $item->Barang->kode_barang }}</td>
                                    <td>{{ $item->Barang->nama_barang }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>

    <div class="container d-flex justify-content-between" style="margin-top: 50px">
        <div class="tdd-left text-center" style="height: 120px; width: 200px;">
            <p style="margin-bottom: 100px;">Hormat Kami.</p>
            <p style="margin-bottom: 0px">Requestor</p>
            {{-- <hr style="border-bottom: dotted;"> --}}
        </div>
        <div class="tdd-left">
            <p style="margin-bottom: 100px; ">Mengetahui</p>
            {{-- <hr style="border-bottom: dotted;"> --}}
            <p style="margin-bottom: 0px">Sales Manager</p>
        </div>
        <div class="tdd-left">
            <p style="margin-bottom: 100px;">Picking</p>
            {{-- <hr style="border-bottom: dotted;"> --}}
            <p style="margin-bottom: 0px">Gudang</p>
        </div>
        <div class="tdd-left">
            <p style="margin-bottom: 100px;">Checker</p>
            {{-- <hr style="border-bottom: dotted;"> --}}
            <p style="margin-bottom: 0px">KA. Gudag</p>
        </div>
        <div class="tdd-left">
            <p style="margin-bottom: 100px;">yang Menerima</p>
            {{-- <hr style="border-bottom: dotted;"> --}}
            <p style="margin-bottom: 0px">TDD / Nama Yang Jelas</p>
        </div>
    </div>
</div>
<script>
    window.print();
</script>
