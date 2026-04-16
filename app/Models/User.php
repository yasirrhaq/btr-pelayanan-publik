<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\StatusLayanan;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    //     'foto_profile',
    //     'alamat',
    //     'nik',
    //     'instansi'
    // ];

    protected $guarded = ['id'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'is_admin'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userStatusLayanan()
    {
        return $this->hasMany(StatusLayanan::class, 'user_id', 'id');
    }

    public function kategoriInstansi()
    {
        return $this->belongsTo(KategoriInstansi::class);
    }

    public function permohonan()
    {
        return $this->hasMany(Permohonan::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class)->orderByDesc('created_at');
    }

    public function unreadNotifikasi()
    {
        return $this->notifikasi()->whereNull('read_at');
    }

    public function timKeanggotaan()
    {
        return $this->belongsToMany(Tim::class, 'tim_anggota')
                    ->withPivot('jabatan')
                    ->withTimestamps();
    }
}
