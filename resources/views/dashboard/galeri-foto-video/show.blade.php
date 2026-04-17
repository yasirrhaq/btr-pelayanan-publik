@extends('dashboard.layouts.main')

@php
    $type = $galeri_foto->type ?? 'image';
    $tab = $type === 'image' ? 'foto' : $type;
    $ext = strtolower(pathinfo($galeri_foto->path_image ?? '', PATHINFO_EXTENSION));
    $isPlayableVideo = in_array($ext, ['mp4', 'webm', 'mov', 'avi']);
@endphp

@section('container')
    <h1 class="btr-page-title">Publikasi - Galeri <small>Detail {{ $type === 'image' ? 'Foto' : ($type === 'video' ? 'Video' : 'Dokumen') }}</small></h1>

    <div class="btr-card">
        <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap">
            <a href="{{ url('dashboard/galeri/foto-video?tab=' . $tab) }}" class="btr-btn btr-btn-outline">Kembali</a>
            <a href="{{ url('dashboard/galeri/foto-video/' . $galeri_foto->id . '/edit') }}" class="btr-btn btr-btn-yellow">Edit</a>
            <form action="{{ url('dashboard/galeri/foto-video/' . $galeri_foto->id) }}" method="post" style="display:inline" onsubmit="return confirm('Yakin hapus data?')">
                @method('delete')
                @csrf
                <button type="submit" class="btr-btn" style="background:var(--danger-red)">Hapus</button>
            </form>
        </div>

        <h2 style="color:var(--text-primary);margin-bottom:18px">{{ $galeri_foto->title }}</h2>

        @if ($type === 'image' && $galeri_foto->path_image)
            <img src="{{ asset($galeri_foto->path_image) }}" style="max-width:100%;border-radius:12px">
        @elseif ($type === 'video')
            <div style="max-width:720px;border:1px solid var(--border-soft);border-radius:16px;padding:20px;background:#fff;">
                @if ($galeri_foto->path_image && $isPlayableVideo)
                    <video controls style="width:100%;border-radius:12px;background:#0f172a;">
                        <source src="{{ asset($galeri_foto->path_image) }}">
                    </video>
                @else
                    <div style="display:flex;align-items:center;gap:16px;">
                        <div style="width:72px;height:72px;border-radius:16px;background:#0f172a;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">VIDEO</div>
                        <div style="min-width:0;flex:1;">
                            <div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ basename($galeri_foto->path_image ?? 'video') }}</div>
                            <div style="font-size:13px;color:var(--text-muted);margin-top:4px;">File video tersimpan</div>
                            @if ($galeri_foto->path_image)
                                <a href="{{ asset($galeri_foto->path_image) }}" target="_blank" style="font-size:13px;color:var(--info-blue);text-decoration:none;">Buka file</a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @elseif ($type === 'dokumen')
            <div style="max-width:720px;border:1px solid var(--border-soft);border-radius:16px;padding:20px;background:#fff;display:flex;align-items:center;gap:16px;">
                <div style="width:72px;height:72px;border-radius:16px;background:#EFF6FF;color:#2563EB;display:flex;align-items:center;justify-content:center;font-weight:700;flex-shrink:0;">DOC</div>
                <div style="min-width:0;flex:1;">
                    <div style="font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ basename($galeri_foto->path_image ?? 'dokumen') }}</div>
                    <div style="font-size:13px;color:var(--text-muted);margin-top:4px;">Dokumen galeri</div>
                    @if ($galeri_foto->path_image)
                        <a href="{{ asset($galeri_foto->path_image) }}" target="_blank" style="font-size:13px;color:var(--info-blue);text-decoration:none;">Buka file</a>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
