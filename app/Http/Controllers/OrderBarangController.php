<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::with("customer")->orderBy("tanggal_transaksi", "ASC")->get();
        // $kode_barang = Barang::generateKode();
        return view('admin.transaksi.index', compact('transaksi'));
    }
    public function create()
    {
        $barangs = Barang::with("satuan")->get();
        $no_faktur = Transaksi::generateNoFaktur();
        $satuans = Satuan::all();
        $customers = Customer::all();
        return view('admin.transaksi.create_order', compact('barangs', 'no_faktur', 'satuans', 'customers'));
    }
    public function store(Request $request)
    {
        if ($request->input('checkStok')) {
            $kode_barang = $request->input('kode_barang');
            $jumlah_order = $request->input('jumlah_order');
            $satuan_id = $request->input('satuan_id');

            $barang = Barang::find($kode_barang);
            $satuan_beli = Satuan::find($satuan_id);
            if ($satuan_beli->id != $barang->satuan_id) {
                // if (str_contains($satuan->satuan, "strip")) {
                // } else {
                // }
                $jumlah_order_satuan = $satuan_beli->jumlah_persatuan * $jumlah_order;
                $barang['jumlah_order_satuan'] = $jumlah_order_satuan;
                $barang['sisa_barang'] = $barang->jumlah - $jumlah_order_satuan;
                $barang['total_harga'] = $barang->harga_satuan * $jumlah_order_satuan;
            } else {
                $barang['sisa_barang'] = $barang->jumlah - $jumlah_order;
                $barang['total_harga'] = $barang->harga_satuan * $jumlah_order;
                $barang['jumlah_order_satuan'] =  $jumlah_order;
            }
            return response()->json($barang);
        }
        try {
            if (!request()->session()->exists('dataBarang')) {
                return response()->json(false);
            }
            $data = $request->except('_token');
            $cartData = request()->session()->get('dataBarang');
            $data['kasir'] = auth()->user()->id;
            $data['status_transkasi'] = 'success';
            $data['sub_total'] = array_sum(array_column($cartData, 'total_harga'));
            DB::beginTransaction();
            $create = Transaksi::create($data);
            if (request()->session()->exists('dataBarang')) {
                foreach ($cartData as $key => $br) {
                    $barang = Barang::find($br['kode_barang']);
                    $barang->fill([
                        'jumlah' =>  $br['sisa_stok']
                    ]);
                    $barang->save();
                    DetailTransaksi::create([
                        'nomer_faktur' => $data['nomer_faktur'],
                        'kode_barang' => $br['kode_barang'],
                        'nama_barang' => $br['nama_barang'],
                        'satuan_id' => $br['satuan_id'],
                        'sisa_stok' => $br['sisa_stok'],
                        'stok_sebelumnya' => $br['stok_sebelumnya'],
                        'jumlah' => $br['jumlah_order'],
                        'harga_satuan' => $br['harga_satuan'],
                        'total_harga' => $br['total_harga'],
                    ]);
                }
            }
            DB::commit();
            request()->session()->forget('dataBarang');
            return response()->json(true);
        } catch (\ErrorException $er) {
            DB::rollBack();
            return response()->json(false);
        }
    }
    public function batal()
    {
        // dd("oko");
        request()->session()->forget('dataBarang');
        return redirect()->route('transaksi.show');
    }
    public function destroy($id)
    {
        $orderBarang = Transaksi::find($id);
        if ($orderBarang) {
            foreach (DetailTransaksi::where('nomer_faktur', $orderBarang->id)->get() as $detail) {
                $barang = Barang::find($detail->id_barang);
                $total = $barang->jumlah + $detail->jumlah;
                Barang::where('id', $detail->id_barang)->update([
                    'jumlah' => $total
                ]);
            }
            DetailTransaksi::where('id_barang_keluar', $orderBarang->id)->delete();
            $orderBarang->delete();
            return response()->json(true);
        } else {
            return response()->json(true);
        }
    }
    public function show($id)
    {
        $barang = Transaksi::with('barang')->find($id);
        return response()->json($barang);
    }
    public function edit($id)
    {
        $barang = Barang::all();
        // $customer = Customer::all();
        $barangkeluar = Transaksi::find($id);
        return view('admin.barang_keluar.edit_barang_keluar', compact('barang', 'barangkeluar'));
    }
    public function update($id, Request $request)
    {
        $data = $request->except('_token', 'tgl_keluar');
        $barang = Transaksi::find($id);
        $data['created_at'] = $request->input('tgl_keluar') . date('H:m:i');
        $barang->fill($data);
        if ($barang->save()) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    public function cetakFakturPdf($nomer_faktur)
    {
        $transaksi = Transaksi::with("user")->find($nomer_faktur);
        $detail_transaksi = DetailTransaksi::with('barang', 'satuan')->where('nomer_faktur', $transaksi->nomer_faktur)->get();
        return view('admin.transaksi.cetak-faktur', compact('transaksi', 'detail_transaksi'));
    }
    public function addCart()
    {
        $dataBarang = request()->except("_token");
        $barang = Barang::find($dataBarang['kode_barang']);
        $satuan = Satuan::find($dataBarang['satuan_id']);
        $dataBarang['kode_barang'] = $barang->kode_barang;
        $dataBarang['nama_barang'] = $barang->nama;
        $dataBarang['satuan'] = $satuan->satuan;
        $dataBarang['total_harga'] = preg_replace('/\D/', '', $dataBarang['total_harga']);
        $dataBarang['harga_satuan'] = preg_replace('/\D/', '', $dataBarang['harga_satuan']);
        // unset($dataBarang['satuan_id'])
        if (request()->session()->exists('dataBarang') && !empty(session()->get('dataBarang'))) {
            request()->session()->push('dataBarang', $dataBarang);
        } else {
            request()->session()->put('dataBarang', []);
            request()->session()->push('dataBarang', $dataBarang);
        }
        return response(true);
    }
    public function detailTransaksi($nomer_faktur)
    {
        $transaksi = Transaksi::find($nomer_faktur);
        $detail_transaksi = DetailTransaksi::with('barang')->where('nomer_faktur', $nomer_faktur)->get();
        return view('admin.transaksi.detail-transaksi', compact('detail_transaksi', 'transaksi'));
    }
}
