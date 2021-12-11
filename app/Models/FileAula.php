<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileAula extends Model
{
    use HasFactory;

    protected $fillable = ['file_aula','aula_id'];
}
