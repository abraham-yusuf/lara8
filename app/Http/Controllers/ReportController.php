<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\DetailBarangkeluar;
use App\Models\Satuan;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use App\Models\Order;
use Carbon\Carbon;

class ReportController extends Controller
{
    //
    public function index()
    {
        return view('admin.laporan.index_laporan');
    }
    public function reportPdf()
    {
        if (request()->input('dari') &&  request()->input('sampai')) {
            $dari =   Carbon::createFromFormat('Y-m-d', request()->input('dari'));
            $sampai = Carbon::createFromFormat('Y-m-d', request()->input('sampai'));
        }
        if (request()->input('laporan') == 'order') {
            //laporan order
            if (request()->input('option-report') == "all") {
                $orders = Transaksi::with("user", "customer")->get();
            } else {
                $orders = Transaksi::with("user", "customer")->whereDate('created_at', '>=', $dari)
                    ->whereDate('created_at', '<=', $sampai)->get();
            }
            return PDF::loadView('admin.laporan.laporan-order-barang', compact('orders'))->stream('laporan_barang_barang.pdf');
        } else if (request()->input('laporan') == "barang-masuk") {
            //laporan barang masuk
            if (request()->input('option-report') == "all") {
                $barang_masuk = BarangMasuk::with("barang", "supplier", "satuan")->get();
            } else {
                $barang_masuk = BarangMasuk::with("barang", "supplier", "satuan")->whereDate('created_at', '>=', $dari)
                    ->whereDate('created_at', '<=', $sampai)->get();
            }
            // dd($barang_masuk);
            return PDF::loadView('admin.laporan.laporan-barang-masuk', compact('barang_masuk'))->stream('laporan_barang_masuk.pdf');
        } else if (request()->input('laporan') == "customer") {
            //laporan customer
            if (request()->input('option-report') == "all") {
                $customers = Customer::all();
            } else {
                $customers = Customer::whereDate('created_at', '>=', $dari)
                    ->whereDate('created_at', '<=', $sampai)->get();
            }
            return PDF::loadView('admin.laporan.laporan-customer', compact('customers'))->stream('laporan_customer.pdf');
        } else if (request()->input('laporan') == "barang") {
            //laporan barang
            if (request()->input('option-report') == "all") {
                $barangs = Barang::with(['barangMasuk', 'detailTransaksi' => function ($query) {
                    $query->with('satuan', 'barang');
                    // $query->select('satuan.satuan', 'satuan.jumlah_persatuan');
                }])->get();
            } else {
                $barangs = Barang::with(["detailTransaksi" => function ($q) {
                    $q->select("satuan.satuan * detailTransaksi.jumlah as jumlah_keluar");
                    $q->join('satuan', 'satuan.id', '=', 'detailTransaksi.satuan_id');
                }])->with(['barangMasuk'])->whereDate('created_at', '>=', $dari)
                    ->whereDate('created_at', '<=', $sampai)->get();
            }
            // dd($barangs);
            return PDF::loadView('admin.laporan.laporan-barang', compact('barangs'))->stream('laporan_barang.pdf');
        }
    }
}
