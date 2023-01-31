<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// tambahan DB
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customer";
    protected $keyType = 'string';
    protected $primaryKey = 'nik';
    protected $fillable = ['nik', 'nama', 'nomer_tlpn', "alamat"];

    public static function laporan($dari, $sampai)
    {
        return DB::table("customer")
            ->whereBetween('created_at', [$dari, $sampai])
            ->get();
    }
}
