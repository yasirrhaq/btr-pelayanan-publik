@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Publikasi - Berita <small>Detail</small></h1>

    <div class="btr-card">
        <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap">
            <a href="{{ url('dashboard/posts') }}" class="btr-btn btr-btn-outline">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
            <a href="{{ url('dashboard/posts/' . $post->slug . '/edit') }}" class="btr-btn btr-btn-yellow">Edit</a>
            <form action="{{ url('dashboard/posts/' . $post->slug) }}" method="post" style="display:inline" onsubmit="return confirm('Yakin hapus data?')">
                @method('delete')
                @csrf
                <button type="submit" class="btr-btn" style="background:var(--danger-red)">Hapus</button>
            </form>
        </div>

        <h2 style="color:var(--text-primary);margin-bottom:8px">{{ $post->title }}</h2>
        <div style="color:var(--text-muted);margin-bottom:18px">Kategori: {{ $post->category->name ?? '-' }}</div>

        @if ($post->image)
            <img src="{{ asset($post->image) }}" alt="" style="max-width:100%;border-radius:12px;margin-bottom:18px">
        @endif

        <article style="line-height:1.7;color:var(--text-body)">
            {!! $post->body !!}
        </article>
    </div>
@endsection
