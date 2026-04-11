<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FasilitasBalai extends Model
{
    use HasFactory;
    protected $table = 'fasilitas_balai';
    protected $guarded = ['id'];
}
