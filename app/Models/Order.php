<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order_barang';
    protected $fillable = ['invoice', 'id_barang', 'id_customer', 'jumlah', 'keterangan', 'status'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }
    public static function generateInvoice()
    {
        $kode_max = DB::select("SELECT MAX(RIGHT(invoice,4)) as kode_max FROM order_barang");
        if ($kode_max) {
            $kode_max =  collect($kode_max)->pluck('kode_max')->toArray()[0];
            $kode_interval =  (int) $kode_max + 1;
        } else {
            $kode_interval =  1;
        }
        return 'INV' . str_pad($kode_interval, 4, '0', STR_PAD_LEFT);
    }
}
