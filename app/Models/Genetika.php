<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genetika extends Model
{
    use HasFactory;

    protected $fillable = [
        'model','status','tanggal_pemesanan','waktu_booking','instansi',
        'nama_pemesan','no_hp','lama_booking','tujuan_kegiatan','created_by','type','total_runing'
    ];
}
