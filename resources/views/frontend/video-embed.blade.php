<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            background: #0f172a;
        }

        .video-shell {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
            background: #0f172a;
        }

        .video-shell > * {
            width: 100%;
            height: 100%;
            border: 0;
            display: block;
        }
    </style>
</head>
<body>
    <div class="video-shell">
        @if ($video->isYoutubeVideo())
            <iframe
                src="{{ $video->youtubeEmbedUrl() }}"
                title="{{ $video->title }}"
                loading="lazy"
                allowfullscreen
            ></iframe>
        @elseif ($video->isUploadedVideo())
            <video controls preload="metadata">
                <source src="{{ $video->publicFileUrl() }}">
            </video>
        @else
            <div style="display:flex;align-items:center;justify-content:center;color:#fff;font:600 14px/1.4 sans-serif;">
                Video tidak tersedia.
            </div>
        @endif
    </div>
</body>
</html>
