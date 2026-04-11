<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlLayanan extends Model
{
    use HasFactory;
    protected $table = 'url_layanan';
    protected $guarded = ['id'];
}