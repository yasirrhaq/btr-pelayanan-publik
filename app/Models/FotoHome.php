<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoHome extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'foto_home';
}
