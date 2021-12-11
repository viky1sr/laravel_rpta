<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $fillable = [
        'tujuan_kegiatan','no_hp','nama_pemesan','instansi','waktu_booking','hari',
        'tanggal_pemesanan','status','kode_booking','created_by','type_booking','lama_booking',
        'lama_booking_date'
    ];

    public function is_status(){
        return $this->hasOne(MasterStatus::class,'status_id','status');
    }

    public function info_status(){
        return $this->hasOne(ReasonReject::class,'kode_booking','kode_booking');
    }
}
