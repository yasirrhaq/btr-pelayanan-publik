<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormatNomor extends Model
{
    protected $table = 'format_nomor';
    protected $guarded = ['id'];

    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class);
    }
}
