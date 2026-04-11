<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusLayanan extends Model
{
    use HasFactory;

    protected $table = 'status_layanan';
    protected $guarded = ['id'];
}
