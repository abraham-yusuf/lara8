<title>Laporan Stok Akhir MMTop</title>
<div style="line-height: 7px; text-align: center; margin-bottom: 30px">
    <h2 style="font-weight: bold">MM Top Bakery</h2>
    <p>Kp. Rawa Lumpang</p>
    <p>Jl. Selembaran Jati, Kec. Kosambi,</p>
    <p>Kabupaten Tangerang, Banten 15214</p>
    <p>Tlp/WA : 0878-7781-0164 | Fax : (+628) 78-7781-0164</p>
</div>
<hr>
<br>
<center>
    <h4>Laporan Stok Akhir MMTop</h4>
</center>
<hr /><br />
<table border="1" width="100%">
    <thead>
        <tr style="text-align:center">
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama barang</th>
            <th>Stok Awal</th>
            <th>Total Masuk</th>
            <th>Total Keluar</th>
            <th>Stok Akhir</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataBarang as $no => $dt)
            <tr style="text-align:center">
                <td>{{ $no + 1 }}</td>
                <td>{{ $dt['kode_barang'] }}</td>
                <td>{{ $dt['nama_barang'] }}</td>
                <td>{{ $dt['stok_awal'] }}</td>
                <td>{{ $dt['totalMasuk'] }}</td>
                <td>{{ $dt['totalKeluar'] }}</td>
                <td>{{ $dt['jumlah'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
