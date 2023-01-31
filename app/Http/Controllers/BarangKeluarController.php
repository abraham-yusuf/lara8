<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
// use App\Models\BarangMasuk;
use App\Models\Customer;
use App\Models\DetailBarangkeluar;
// use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// Edit
// use App\Models\Transaksi;
// use App\Models\DetailTransaksi;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang_keluar = BarangKeluar::all();
        // $kode_barang = Barang::generateKode();
        return view('admin.barang_keluar.index_barang_keluar', compact('barang_keluar'));
    }
    public function halamanTambah()
    {
        $barang = Barang::all();
        $customer = Customer::all();
        $no_keluar = BarangKeluar::generateNoPo();
        $no_sj = BarangKeluar::generateSJ();
        return view('admin.barang_keluar.create_barang_keluar', compact('barang', 'customer', 'no_sj', 'no_keluar'));
    }
    public function store(Request $request)
    {
        if ($request->input('checkStok')) {
            $id_barang = $request->input('id_barang');
            $barang = barang::find($id_barang);
            return response()->json($barang);
        }
        $data = $request->except('_token', 'tgl_keluar');
        $data['created_at'] = $request->input('tgl_keluar') . date('H:m:i');
        try {
            $create = BarangKeluar::create($data);
            if (request()->session()->exists('databarang')) {
                foreach (request()->session()->get('databarang') as $key => $br) {
                    $barang = Barang::find($br['id_barang']);
                    $barang->fill([
                        'jumlah' =>  $barang->jumlah - $br['jumlahMasuk']
                    ]);
                    $barang->save();
                    DetailBarangkeluar::create([
                        'id_barang_keluar' => $create->id,
                        'id_barang' => $br['id_barang'],
                        'satuan' => $br['satuan'],
                        'sisa_stok' => $br['sisaStok'],
                        'jumlah_sebelumnya' => $br['stokSebelumnya'],
                        'jumlah' => $br['jumlahMasuk']
                    ]);
                }
            }
            DB::commit();
            request()->session()->forget('databarang');
            return response()->json(true);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(false);
        }
    }
    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::find($id);
        if ($barangKeluar) {
            foreach (DetailBarangkeluar::where('id_barang_keluar', $barangKeluar->id)->get() as $detail) {
                $barang = Barang::find($detail->id_barang);
                $total = $barang->jumlah + $detail->jumlah;
                Barang::where('id', $detail->id_barang)->update([
                    'jumlah' => $total
                ]);
            }
            DetailBarangkeluar::where('id_barang_keluar', $barangKeluar->id)->delete();
            $barangKeluar->delete();
            return response()->json(true);
        } else {
            return response()->json(true);
        }
    }
    public function show($id)
    {
        $barang = BarangKeluar::with('barang', 'customer')->find($id);
        return response()->json($barang);
    }
    public function halamanEdit($id)
    {
        $barang = Barang::all();
        $customer = Customer::all();
        $barangkeluar = BarangKeluar::find($id);
        return view('admin.barang_keluar.edit_barang_keluar', compact('barang', 'customer', 'barangkeluar'));
    }
    public function update($id, Request $request)
    {
        $data = $request->except('_token', 'tgl_keluar');
        $barang = BarangKeluar::find($id);
        $data['created_at'] = $request->input('tgl_keluar') . date('H:m:i');
        $barang->fill($data);
        if ($barang->save()) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    public function laporanSuratjalan($id)
    {
        $barang_keluar = BarangKeluar::with('customer')->find($id);
        $detailKeluar = DetailBarangkeluar::with('barang')->where('id_barang_keluar', $barang_keluar->id)->get();
        return view('admin.barang_keluar.surat_jalan', compact('barang_keluar', 'detailKeluar'));
    }
    public function addCart()
    {
        $dataBarang = request()->except("_token");
        $barang = Barang::find($dataBarang['id_barang']);
        $dataBarang['kode_barang'] = $barang->kode_barang;
        $dataBarang['nama_barang'] = $barang->nama_barang;
        if (request()->session()->exists('databarang') && !empty(session()->get('databarang'))) {
            request()->session()->push('databarang', $dataBarang);
        } else {
            request()->session()->put('databarang', []);
            request()->session()->push('databarang', $dataBarang);
        }
        return response(true);
    }
    public function viewDetailBarangKeluar($id)
    {
        $detailKeluar = DetailBarangkeluar::with('barang')->where('id_barang_keluar', $id)->get();
        return view('admin.barang_keluar.detailkeluar', compact('detailKeluar'));
    }
}
