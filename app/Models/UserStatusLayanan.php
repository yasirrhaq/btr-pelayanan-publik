<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStatusLayanan extends Model
{
    use HasFactory;

    protected $table = 'user_status_layanan';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function status()
    {
        return $this->hasOne(StatusLayanan::class, 'id', 'status_id');
    }
    public function jenis()
    {
        return $this->hasOne(JenisLayanan::class, 'id', 'layanan_id');
    }
}
