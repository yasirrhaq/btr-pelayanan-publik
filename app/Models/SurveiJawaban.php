<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveiJawaban extends Model
{
    protected $table = 'survei_jawaban';
    protected $guarded = ['id'];

    public function surveiKepuasan()
    {
        return $this->belongsTo(SurveiKepuasan::class);
    }

    public function pertanyaan()
    {
        return $this->belongsTo(SurveiPertanyaan::class, 'survei_pertanyaan_id');
    }
}
