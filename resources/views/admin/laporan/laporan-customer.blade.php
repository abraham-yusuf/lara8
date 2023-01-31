<title>Laporan List Customer MMTop</title>
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
    <h4>Laporan List Customer</h4>
</center>
<hr /><br />
<table width="100%">
    <thead>
        <tr style="text-align:center">
            <th>No</th>
            <th>NIK</th>
            <th>Nama Customer</th>
            <th>Nomer Telepon</th>
            <th>Alamat</th>
            <th>Tanggal Daftar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $no => $dt)
            <tr style="text-align:center">
                <td>{{ $no + 1 }}</td>
                <td>{{ $dt->nik }}</td>
                <td>{{ $dt->nama }}</td>
                <td>{{ $dt->nomer_tlpn }}</td>
                <td>{{ $dt->alamat }}</td>
                <td>{{ $dt->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
