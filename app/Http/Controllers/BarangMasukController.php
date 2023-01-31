<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Satuan;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang_masuk = BarangMasuk::all();
        // $kode_barang = Barang::generateKode();
        return view('admin.barang_masuk.index', compact('barang_masuk'));
    }
    public function create()
    {
        $barang = Barang::all();
        $supplier = Supplier::all();
        $kode_barang = Barang::generateKode();
        $satuans = Satuan::all();
        return view('admin.barang_masuk.create_barang_masuk', compact('barang', 'supplier', 'kode_barang', 'satuans'));
    }
    public function store(Request $request)
    {
        if ($request->input('checkStok')) {
            $kode_barang = $request->input('kode_barang');
            $barang = Barang::with("satuan")->find($kode_barang);
            return response()->json($barang);
        }
        try {
            DB::beginTransaction();
            $data = $request->except('_token');
            $barang = Barang::find($data['kode_barang']);
            BarangMasuk::create($data);
            $barang->fill([
                'jumlah' => $data['jumlah'] + $barang->jumlah
            ]);
            $barang->save();
            DB::commit();
            return response()->json(true);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json($th->getMessage());
            // throw $th->getMessage();
        }
    }
    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::find($id);
        if ($barangMasuk) {
            $barang = Barang::find($barangMasuk->kode_barang);
            $total = $barang->jumlah - $barangMasuk->jumlah;
            Barang::where('kode_barang', $barangMasuk->kode_barang)->update([
                'jumlah' => $total
            ]);
            $barangMasuk->delete();
            return response()->json(true);
        } else {
            return response()->json(true);
        }
    }
    public function show($id)
    {
        $barang = BarangMasuk::with('barang:satuan', 'supplier')->find($id);
        return response()->json($barang);
    }
    public function edit($id)
    {
        $barang = Barang::all();
        $supplier = Supplier::all();
        $barangMasuk = BarangMasuk::find($id);
        $satuans = Satuan::all();
        return view('admin.barang_masuk.edit_barang_masuk', compact('barang', 'supplier', 'barangMasuk', 'satuans'));
    }
    public function update($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $barangMasuk = BarangMasuk::find($id);
            $data = $request->except('_token');
            $barangMasuk->fill($data);
            $barangMasuk->save();

            $barang = Barang::find($data['kode_barang']);
            $data['jumlah_sebelumnya'] = $data['total_stok'];
            $barang->fill([
                'jumlah' => $data['total_stok']
            ]);
            $barang->save();
            DB::commit();
            return response()->json(true);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(true);
            //throw $th;
        }
    }
}
