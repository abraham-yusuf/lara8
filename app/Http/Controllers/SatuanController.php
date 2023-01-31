<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satuans = Satuan::all();
        return view('admin.satuan.index', compact('satuans'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $create = Satuan::create($data);
        if ($create) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    public function destroy($id)
    {
        $satuan = Satuan::find($id);
        if ($satuan) {
            $satuan->delete();
            return response()->json(true);
        } else {
            return response()->json(true);
        }
    }
    public function show($id)
    {
        $satuan = Satuan::find($id);
        return response()->json($satuan);
    }
    public function update($id, Request $request)
    {
        $satuan = Satuan::find($id);
        $data = $request->except('_token');
        $satuan->fill($data);
        if ($satuan->save()) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
}
