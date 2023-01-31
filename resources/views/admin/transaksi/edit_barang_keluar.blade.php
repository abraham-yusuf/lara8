@extends('admin.layout')
@section('title', 'Halaman Tambah Barang Keluar MMTop')

@section('content')
    <div class="container-fluid" id="container-wrapper">

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h5>EDIT BARANG KELUAR</h5>
            </div>
            <div class="card-body">
                <form id="formEdit">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_keluar">No PO</label>
                                    <input type="text" name="no_keluar" readonly value="{{ $barangkeluar->no_keluar }}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="no_surat_jalan">No Surat jalan</label>
                                    <input type="text" name="no_surat_jalan" readonly
                                        value="{{ $barangkeluar->no_surat_jalan }}" class="form-control">
                                </div>
                            </div>
                            @php
                                $date = new DateTime($barangkeluar->created_at);
                            @endphp
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tgl_keluar">Tanggal Keluar</label>
                                    <input required type="date" name="tgl_keluar" value="{{ $date->format('Y-m-d') }}"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="yg_mengeluarkan">Yang Mengeluarkan</label>
                                    <input required type="text" value="{{ $barangkeluar->yg_mengeluarkan }}"
                                        name="yg_mengeluarkan" id="yg_mengeluarkan" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Buat</label>
                            <textarea class="form-control" name="buat" id="buat" cols="30" rows="5">{{ $barangkeluar->buat }}</textarea>

                        </div>
                        <div class="form-group">
                            <label for="id_barang">Barang</label>
                            <select required class="custom-select" name="id_barang" id="id_barang">
                                <option value="" disabled selected hidden>-- Select Barang --</option>
                                @foreach ($barang as $bar)
                                    <option {{ $barangkeluar->id_barang == $bar->id ? 'selected' : '' }}
                                        value="{{ $bar->id }}">{{ $bar->nama_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input required type="number" value="{{ $barangkeluar->jumlah }}" name="jumlah" id="jumlah"
                                min="1" value="" class="form-control">
                            <span class="alert-barang-kosong text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Sebelumnya</label>
                            <input readonly type="number" value="{{ $barangkeluar->jumlah_sebelumnya }}"
                                name="jumlah_sebelumnya" id="jumlah_sebelumnya" min="1" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Sisa Stok</label>
                            <input readonly type="number" value="{{ $barangkeluar->sisa_stok }}" name="sisa_stok"
                                id="sisa_stok" min="1" class="form-control">
                        </div>
                        <div class="form-group">
                            <label id="satuan">Satuan</label>
                            <select required class="custom-select" name="satuan" id="satuan">
                                <option value="" disabled selected hidden>-- Select Satuan --</option>
                                <option {{ $barangkeluar->satuan == 'pcs' ? 'selected' : '' }} value="pcs">pcs</option>
                                <option {{ $barangkeluar->satuan == 'btg' ? 'selected' : '' }} value="btg">btg</option>
                                <option {{ $barangkeluar->satuan == 'lb' ? 'selected' : '' }} value="lb">lb</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" href="/barang-keluar">Cancle</a>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function() {

            $(document).on('submit', '#formEdit', function(e) {
                e.preventDefault();
                const data = $(this).serialize();
                const id = "{{ $barangkeluar->id }}";
                $.ajax({
                    url: `/barang-keluar/${id}`,
                    data: data,
                    dataType: 'json',
                    type: 'PUT',
                    success: function(hasil) {
                        if (hasil) {
                            Swal.fire(
                                'sukses',
                                'sukses edit data',
                                'success'
                            ).then(() => {
                                document.location.href = '/barang-keluar';
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
            //end

            //check stok
            $(document).on('keyup change', '#jumlah', function() {
                const id_barang = $('#id_barang').val();
                var jumlah_keluar = $('#jumlah').val();

                $('.alert-barang-kosong').html(``);
                if (id_barang === undefined || id_barang === '' || id_barang === null) {
                    $('.alert-barang-kosong').html(`Barang Harus Di Pilih Dahulu`);
                    $('#btn-add').attr('disabled', 'disabled');
                    return false;
                }
                $.ajax({
                    url: '/barang-keluar',
                    data: {
                        checkStok: true,
                        id_barang,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function(result) {
                        let jumlah = result.jumlah;
                        $('#jumlah_sebelumnya').val(jumlah);
                        $('#jumlah').attr('max', `${jumlah}`);
                        const total = parseInt(jumlah) - parseInt(jumlah_keluar);
                        $('#sisa_stok').val(total);
                    }
                })
            })
        })
    </script>
@endsection
