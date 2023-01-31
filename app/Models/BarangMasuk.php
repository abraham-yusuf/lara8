<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// DB
use Illuminate\Support\Facades\DB;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = 'barang_masuk';
    protected $fillable = ['kode_barang', 'supplier_id', 'satuan_id', 'jumlah', 'jumlah_sebelumnya', 'total_stok', 'penerima'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'kode_barang');
    }
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public static function laporan($dari, $sampai)
    {
        return DB::table("barang_masuk")
            ->select("barang_masuk.*", "barang.nama AS nama_barang", "supplier.nama AS nama_supplier", "satuan.satuan")
            ->join('barang', "barang.kode_barang", "=", "barang_masuk.kode_barang")
            ->join('supplier', "barang_masuk.supplier_id", "=", "supplier.id")
            ->join('satuan', "barang_masuk.satuan_id", "=", "satuan.id")
            ->whereBetween('barang_masuk.created_at', [$dari, $sampai])
            ->get();
    }
}
