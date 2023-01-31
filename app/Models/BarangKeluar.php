<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BarangKeluar extends Model
{
    use HasFactory;
    protected $table = 'barang_keluar';
    protected $fillable = ['id_barang', 'buat', 'satuan', 'jumlah', 'yg_mengeluarkan', 'sisa_stok', 'no_keluar', 'no_surat_jalan', 'jumlah_sebelumnya'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    public function customer()
    {
        // return $this->belongsTo(Customer::class, 'id_customer');
    }
    public static function generateNoPo()
    {
        $kode_max = DB::select("SELECT MAX(RIGHT(no_keluar,4)) as kode_max FROM barang_keluar");
        if ($kode_max) {
            $kode_max =  collect($kode_max)->pluck('kode_max')->toArray()[0];
            $kode_interval =  (int) $kode_max + 1;
        } else {
            $kode_interval =  1;
        }
        return 'PO-' . str_pad($kode_interval, 4, '0', STR_PAD_LEFT);
    }
    public static function generateSJ()
    {
        $kode_max = DB::select("SELECT MAX(RIGHT(no_surat_jalan,4)) as kode_max FROM barang_keluar");
        if ($kode_max) {
            $kode_max =  collect($kode_max)->pluck('kode_max')->toArray()[0];
            $kode_interval =  (int) $kode_max + 1;
        } else {
            $kode_interval =  1;
        }
        return 'NSJ-' . str_pad($kode_interval, 4, '0', STR_PAD_LEFT);
    }
}
