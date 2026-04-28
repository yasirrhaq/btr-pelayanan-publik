<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriFoto extends Model
{
    use HasFactory;

    public const TYPE_IMAGE = 'image';
    public const TYPE_VIDEO = 'video';
    public const TYPE_DOKUMEN = 'dokumen';

    public const SOURCE_TYPE_UPLOAD = 'upload';
    public const SOURCE_TYPE_YOUTUBE = 'youtube';

    public const VIDEO_CATEGORIES = [
        'Kegiatan',
        'Layanan',
        'Publikasi',
        'Dokumentasi',
    ];

    protected $table = 'galeri_foto';
    protected $guarded = ['id'];

    public function isVideo(): bool
    {
        return $this->type === self::TYPE_VIDEO;
    }

    public function isYoutubeVideo(): bool
    {
        return $this->isVideo() && $this->source_type === self::SOURCE_TYPE_YOUTUBE && !empty($this->source_url);
    }

    public function isUploadedVideo(): bool
    {
        return $this->isVideo() && $this->source_type !== self::SOURCE_TYPE_YOUTUBE && !empty($this->path_image);
    }

    public function embedRoute(): string
    {
        return url('/video/embed/' . $this->slug);
    }

    public function publicFileUrl(): ?string
    {
        if (!$this->path_image) {
            return null;
        }

        return asset(ltrim($this->path_image, '/'));
    }

    public function youtubeVideoId(): ?string
    {
        if (!$this->source_url) {
            return null;
        }

        $url = trim($this->source_url);

        if (preg_match('~(?:youtube\.com/watch\?v=|youtube\.com/embed/|youtu\.be/)([\w-]{11})~i', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function youtubeEmbedUrl(): ?string
    {
        $videoId = $this->youtubeVideoId();

        return $videoId ? 'https://www.youtube.com/embed/' . $videoId . '?rel=0' : null;
    }

    public function youtubeThumbnailUrl(): ?string
    {
        $videoId = $this->youtubeVideoId();

        return $videoId ? 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg' : null;
    }

    public function previewImageUrl(): ?string
    {
        if ($this->isYoutubeVideo()) {
            return $this->youtubeThumbnailUrl();
        }

        return null;
    }

    public function sourceLabel(): string
    {
        return $this->isYoutubeVideo() ? 'YouTube' : 'Upload';
    }

    public function copyEmbedCode(): string
    {
        $src = e($this->embedRoute());

        return '<iframe src="' . $src . '" title="' . e($this->title) . '" style="width:100%;max-width:720px;aspect-ratio:16/9;border:0;border-radius:18px;overflow:hidden;" loading="lazy" allowfullscreen></iframe>';
    }
}
