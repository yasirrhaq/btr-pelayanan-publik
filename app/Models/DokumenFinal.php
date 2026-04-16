<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenFinal extends Model
{
    protected $table = 'dokumen_final';
    protected $guarded = ['id'];

    protected $casts = [
        'is_downloadable' => 'boolean',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
