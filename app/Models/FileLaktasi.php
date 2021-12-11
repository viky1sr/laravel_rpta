<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileLaktasi extends Model
{
    use HasFactory;

    protected $fillable = ['laktasi_id','file_laktasi'];
}
