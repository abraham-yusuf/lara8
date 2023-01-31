<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// tambah DB
use Illuminate\Support\Facades\DB;

class DetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksi';
    protected $fillable = ['kode_barang', 'nomer_faktur', 'satuan_id', 'nama_barang', 'harga_satuan', 'total_harga', 'jumlah', 'stok_sebelumnya', 'sisa_stok'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
    public function Barang()
    {
        return $this->belongsTo(Barang::class, "kode_barang");
    }
    public function satuan()
    {
        return $this->hasOne(Satuan::class, "id", "satuan_id");
    }
}
