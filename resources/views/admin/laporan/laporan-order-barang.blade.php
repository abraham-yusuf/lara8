<title>Laporan Order Barang MMTop</title>
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
    <h4>Laporan Order Barang</h4>
</center>
<hr /><br />
<table style="width: 100%">
    <thead>
        <tr style="text-align:center">
            <th>No</th>
            <th>Nama Customer</th>
            <th>Kasir</th>
            <th>Total Pembelian</th>
            <th>Tanggal Pembelian</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $no => $dt)
            <tr style="text-align:center">
                <td>{{ $no + 1 }}</td>
                <td>{{ $dt->customer->nama }}</td>
                <td>{{ $dt->user->nama }}</td>
                <td>Rp.{{ number_format($dt->sub_total, 2, ',', '.') }}</td>
                <td>{{ $dt->tanggal_transaksi }}</td>
                <td>{{ $dt->keterangan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
