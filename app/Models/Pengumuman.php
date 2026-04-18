<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Pengumuman extends Model
{
    use SoftDeletes;

    protected $table = 'pengumuman';
    protected $guarded = ['id'];

    protected $casts = [
        'is_pinned'    => 'boolean',
        'is_published' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        if (Schema::hasColumn($this->getTable(), 'is_published')) {
            return $query->where('is_published', true);
        }

        if (Schema::hasColumn($this->getTable(), 'is_active')) {
            return $query->where('is_active', true);
        }

        return $query;
    }
}
