<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $guarded = ['id'];

    protected $casts = [
        'nominal'       => 'decimal:2',
        'tanggal_bayar' => 'datetime',
        'verified_at'   => 'datetime',
    ];

    public const STATUS_BELUM_BAYAR         = 'belum_bayar';
    public const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';
    public const STATUS_SUDAH_BAYAR         = 'sudah_bayar';
    public const STATUS_DITOLAK             = 'ditolak';

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
