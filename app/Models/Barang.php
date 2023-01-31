<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// tambah DB
use Illuminate\Support\Facades\DB;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $keyType = 'string';
    protected $primaryKey = 'kode_barang';
    protected $fillable = ['kode_barang', 'nama', 'jumlah', 'keterangan',"stok_awal", 'satuan_id', 'notif', "pic", "harga_satuan", "aturan_jual"];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    public static function generateKode()
    {
        $kode_max = DB::select("SELECT MAX(RIGHT(kode_barang,4)) as kode_max FROM barang");
        if ($kode_max) {
            $kode_max =  collect($kode_max)->pluck('kode_max')->toArray()[0];
            $kode_interval =  (int) $kode_max + 1;
        } else {
            $kode_interval =  1;
        }
        return 'MM' . str_pad($kode_interval, 4, '0', STR_PAD_LEFT);
    }
    public function satuan()
    {
        return $this->hasOne(Satuan::class, "id", "satuan_id");
    }
    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'kode_barang');
    }
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'kode_barang');
    }
    public function order()
    {
        return $this->hasOne(Order::class, "id", "order_barang");
    }
}
