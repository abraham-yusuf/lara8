<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::all();
        return view('admin.supplier.index_supplier', compact('supplier'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $create = Supplier::create($data);
        if ($create) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        if ($supplier) {
            BarangMasuk::where('id_supplier', $id)->delete();
            $supplier->delete();
            return response()->json(true);
        } else {
            return response()->json(true);
        }
    }
    public function show($id)
    {
        $suplier = Supplier::find($id);
        return response()->json($suplier);
    }
    public function update($id, Request $request)
    {
        $suplier = Supplier::find($id);
        $data = $request->except('_token');
        $suplier->fill($data);
        if ($suplier->save()) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
}
