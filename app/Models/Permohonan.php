<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permohonan extends Model
{
    use SoftDeletes;

    protected $table = 'permohonan';
    protected $guarded = ['id'];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'deadline'        => 'date',
        'is_berbayar'     => 'boolean',
    ];

    public const STATUS_BARU         = 'baru';
    public const STATUS_VERIFIKASI   = 'verifikasi';
    public const STATUS_PENUGASAN    = 'penugasan';
    public const STATUS_PEMBAYARAN   = 'pembayaran';
    public const STATUS_PELAKSANAAN  = 'pelaksanaan';
    public const STATUS_ANALISIS     = 'analisis';
    public const STATUS_EVALUASI     = 'evaluasi';
    public const STATUS_FINALISASI   = 'finalisasi';
    public const STATUS_SELESAI      = 'selesai';
    public const STATUS_DITOLAK      = 'ditolak';

    public const STATUS_LABELS = [
        self::STATUS_BARU        => 'Baru',
        self::STATUS_VERIFIKASI  => 'Verifikasi',
        self::STATUS_PENUGASAN   => 'Penugasan',
        self::STATUS_PEMBAYARAN  => 'Menunggu Pembayaran',
        self::STATUS_PELAKSANAAN => 'Pelaksanaan',
        self::STATUS_ANALISIS    => 'Analisis',
        self::STATUS_EVALUASI    => 'Evaluasi',
        self::STATUS_FINALISASI  => 'Finalisasi',
        self::STATUS_SELESAI     => 'Selesai',
        self::STATUS_DITOLAK     => 'Ditolak',
    ];

    public const STATUS_PROGRESS = [
        self::STATUS_BARU        => 0,
        self::STATUS_VERIFIKASI  => 10,
        self::STATUS_PENUGASAN   => 20,
        self::STATUS_PEMBAYARAN  => 30,
        self::STATUS_PELAKSANAAN => 50,
        self::STATUS_ANALISIS    => 65,
        self::STATUS_EVALUASI    => 80,
        self::STATUS_FINALISASI  => 90,
        self::STATUS_SELESAI     => 100,
        self::STATUS_DITOLAK     => 0,
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    // --- Workflow transitions ---
    public static function allowedTransitions(): array
    {
        return [
            self::STATUS_BARU        => [self::STATUS_VERIFIKASI, self::STATUS_DITOLAK],
            self::STATUS_VERIFIKASI  => [self::STATUS_PENUGASAN, self::STATUS_DITOLAK],
            self::STATUS_PENUGASAN   => [self::STATUS_PEMBAYARAN, self::STATUS_PELAKSANAAN],
            self::STATUS_PEMBAYARAN  => [self::STATUS_PELAKSANAAN],
            self::STATUS_PELAKSANAAN => [self::STATUS_ANALISIS, self::STATUS_FINALISASI],
            self::STATUS_ANALISIS    => [self::STATUS_EVALUASI],
            self::STATUS_EVALUASI    => [self::STATUS_FINALISASI, self::STATUS_PELAKSANAAN],
            self::STATUS_FINALISASI  => [self::STATUS_SELESAI],
            self::STATUS_SELESAI     => [],
            self::STATUS_DITOLAK     => [],
        ];
    }

    public function canTransitionTo(string $newStatus): bool
    {
        $allowed = self::allowedTransitions()[$this->status] ?? [];
        return in_array($newStatus, $allowed, true);
    }

    // --- Relationships ---
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class);
    }

    public function tim()
    {
        return $this->belongsTo(Tim::class);
    }

    public function katimUser()
    {
        return $this->belongsTo(User::class, 'katim_id');
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenPermohonan::class);
    }

    public function workflowLogs()
    {
        return $this->hasMany(WorkflowLog::class)->orderBy('created_at');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function surveiKepuasan()
    {
        return $this->hasOne(SurveiKepuasan::class);
    }

    public function dokumenFinal()
    {
        return $this->hasMany(DokumenFinal::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function sudahSurvei(): bool
    {
        return $this->surveiKepuasan()->exists();
    }
}
