<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveiPertanyaan extends Model
{
    protected $table = 'survei_pertanyaan';
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function jawaban()
    {
        return $this->hasMany(SurveiJawaban::class);
    }
}
