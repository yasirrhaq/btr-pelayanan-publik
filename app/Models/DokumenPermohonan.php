<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPermohonan extends Model
{
    protected $table = 'dokumen_permohonan';
    protected $guarded = ['id'];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
