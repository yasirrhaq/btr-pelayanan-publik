<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Pengumuman extends Model
{
    use Sluggable, SoftDeletes;

    protected $table = 'pengumuman';
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'views' => 'integer',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if ($field !== null) {
            return parent::resolveRouteBinding($value, $field);
        }

        return $this->newQuery()
            ->where('slug', $value)
            ->when(is_numeric($value), fn ($query) => $query->orWhereKey($value))
            ->firstOrFail();
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'judul',
            ],
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function thumbnailUrl(): string
    {
        $fallback = asset('assets/fotoDumy.jpeg');

        if (empty($this->thumbnail_path)) {
            return $fallback;
        }

        $normalized = ltrim(str_replace('\\', '/', $this->thumbnail_path), '/');

        if (str_starts_with($normalized, 'assets/')) {
            $absolute = public_path($normalized);

            return file_exists($absolute) ? asset($normalized) : $fallback;
        }

        return asset('storage/' . $normalized);
    }

    public function usesUploadedThumbnail(): bool
    {
        return !empty($this->thumbnail_path) && !str_starts_with(ltrim($this->thumbnail_path, '/'), 'assets/');
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
