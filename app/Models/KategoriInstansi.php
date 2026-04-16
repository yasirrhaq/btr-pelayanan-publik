<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriInstansi extends Model
{
    protected $table = 'kategori_instansi';
    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
