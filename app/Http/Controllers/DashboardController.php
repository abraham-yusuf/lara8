<?php

namespace App\Http\Controllers;

// Add Dari Model
use App\Models\Customer;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
    }
    public function index()
    {
        $transaksiHariIni = Transaksi::whereDate("tanggal_transaksi", date('Y-m-d'))->get();
        $total_price = array_sum(array_column($transaksiHariIni->toArray(), 'sub_total'));
        $total_transaksi = $transaksiHariIni->count();
        $total_customer = Customer::all()->count();
        return view('admin.dashboard', compact("total_price", 'total_transaksi', 'total_customer'));
    }
}
