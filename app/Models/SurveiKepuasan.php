<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveiKepuasan extends Model
{
    protected $table = 'survei_kepuasan';
    protected $guarded = ['id'];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jawaban()
    {
        return $this->hasMany(SurveiJawaban::class);
    }

    public function rataRataNilai(): float
    {
        return $this->jawaban()->avg('nilai') ?? 0;
    }
}
