<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoPegawai extends Model
{
    use HasFactory;
    protected $table = 'info_pegawai';
    protected $guarded = ['id'];
}
