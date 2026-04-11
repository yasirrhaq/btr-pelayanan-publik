<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitusTerkait extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'situs_terkait';
}
