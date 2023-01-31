<title>Laporan Barang Masuk MMTop</title>
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
    <h4>Laporan Barang Masuk</h4>
</center>
<hr /><br />
<table width="100%">
    <thead>
        <tr style="text-align:center">
            <th>No</th>
            <th>Nama Barang</th>
            <th>Nama Supplier</th>
            <th>Tanggal</th>
            <th>Stok Awal</th>
            <th>Stok Masuk</th>
            <th>Stok Akhir</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barang_masuk as $no => $dt)
            <tr style="text-align:center">
                <td>{{ $no + 1 }}</td>
                <td>{{ $dt->barang->nama }}</td>
                <td>{{ $dt->supplier->nama }}</td>
                <td>{{ $dt->created_at }}</td>
                <td>{{ $dt->jumlah_sebelumnya }}</td>
                <td>{{ $dt->jumlah }}</td>
                <td>{{ $dt->total_stok }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
