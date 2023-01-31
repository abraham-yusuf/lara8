<?php

namespace App\Http\Controllers;

// add model
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $obats = Obat::with("satuan")->get();
        $barangs = Barang::with("satuan")->get();
        $satuans = Satuan::all();
        $kode_barang = Barang::generateKode();
        return view('admin.barang.index', compact('barangs', 'kode_barang', 'satuans'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['stok_awal'] = $data['jumlah'];
        //buat upload gambar
        if ($request->hasFile('pic')) {
            if ($request->file('pic')->isValid()) {
                $fileName = time() . '-' . date('M') . '.' . $request->file('pic')->extension();
                $request->file('pic')->move(public_path('assets/image/obat'), $fileName);
                $data['pic'] = "assets/image/obat/$fileName";
            }
        }
        $create = Barang::create($data);
        if ($create) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    public function destroy($kode_barang)
    {
        $barang = Barang::find($kode_barang);
        if ($barang) {
            $barang->delete();
            return response()->json(true);
        } else {
            return response()->json(true);
        }
    }
    public function show($kode_barang)
    {
        $barang = Barang::with("satuan")->find($kode_barang);
        return response()->json($barang);
    }
    public function update($kode_barang, Request $request)
    {
        $barang = Barang::find($kode_barang);
        if ($barang) {
            $data = $request->except('_token');
            // if ($obat->stok_awal != $data['stok_awal']) {
            //     if ($data['stok_awal'] > $obat->stok_awal) {
            //         $total =  $data['stok_awal'] - $obat->stok_awal;
            //         $data['jumlah'] = $obat->jumlah + $total;
            //     } else {
            //         $total =   $obat->stok_awal - $data['stok_awal'];
            //         $data['jumlah'] = $obat->jumlah - $total;
            //     }
            // }
            if ($request->hasFile('pic')) {
                if ($request->file('pic')->isValid()) {
                    if (file_exists(public_path($request->file("pic")) && $request->file("pic") != null)) {
                        unlink(public_path($request->file("pic")));
                    }
                    $fileName = time() . '-' . date('M') . '.' . $request->file('pic')->extension();
                    $request->file('pic')->move(public_path('assets/image/pic'), $fileName);
                    $data['pic'] = "assets/image/pic/$fileName";
                }
            }
            $barang->fill($data);
            if ($barang->save()) {
                return response()->json(true);
            } else {
                return response()->json(false);
            }
        } else {
            return response()->json(false);
        }
    }
}
