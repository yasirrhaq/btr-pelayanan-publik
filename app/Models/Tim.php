<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tim extends Model
{
    use SoftDeletes;

    protected $table = 'tim';
    protected $guarded = ['id'];

    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class);
    }

    public function anggota()
    {
        return $this->hasMany(TimAnggota::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tim_anggota')
                    ->withPivot('jabatan')
                    ->withTimestamps();
    }

    public function katim()
    {
        return $this->anggota()->where('jabatan', 'katim');
    }

    public function permohonan()
    {
        return $this->hasMany(Permohonan::class);
    }
}
