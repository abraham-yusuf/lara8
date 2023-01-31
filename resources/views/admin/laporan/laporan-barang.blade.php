<title>Laporan Barang MMTop</title>
<div style="line-height: 7px; text-align: center; margin-bottom: 30px">
    <h2 style="font-weight: bold">MM Top Bakery</h2>
    <p>Kp. Rawa Lumpang</p>
    <p>Jl. Selembaran Jati, Kec. Kosambi,</p>
    <p>Kabupaten Tangerang, Banten 15214</p>
    <p>Tlp/WA : 0878-7781-0164 | Fax : (+628) 78-7781-0164</p>
</div>
<hr>
<br>
<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<center>
    <h4>Laporan Barang</h4>
</center>
<hr /><br />
<table width="100%">
    <thead>
        <tr style="text-align:center">
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Stok Awal</th>
            <th>Stok Masuk</th>
            {{-- <th>Stok Keluar</th> S. Keluar Ganti Jadi Terjual --}}
            <th>Terjual</th>
            <th>Stok Akhir</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barangs as $no => $dt)
            @php
                $totalStokKeluar = 0;
                foreach ($dt->detailTransaksi as $order) {
                    if ($order->barang->satuan_id != $order->satuan_id) {
                        $totalStokKeluar += $order->satuan->jumlah_persatuan * $order->jumlah;
                    } else {
                        $totalStokKeluar += $order->jumlah;
                    }
                }
                // $totalStokKeluar = array_sum(array_column($dt->detailTransaksi->toArray(), 'jumlah'));
                $totalStokMasuk = array_sum(array_column($dt->barangMasuk->toArray(), 'jumlah'));
            @endphp
            <tr style="text-align:center">
                <td>{{ $no + 1 }}</td>
                <td>{{ $dt->kode_barang }}</td>
                <td>{{ $dt->nama }}</td>
                <td>{{ $dt->stok_awal }}</td>
                <td>{{ $totalStokMasuk }}</td>
                <td>{{ $totalStokKeluar }}</td>
                <td>{{ $dt->stok_awal + $totalStokMasuk - $totalStokKeluar }}</td>
                <td>Rp.{{ number_format($dt->sub_total, 2, ',', '.') }}</td>

            </tr>
        @endforeach
    </tbody>
</table>
