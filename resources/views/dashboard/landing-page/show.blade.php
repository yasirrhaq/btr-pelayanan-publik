@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">{{ $post->title }}</h1>

    <div class="btr-card">
        <div class="btr-form-actions" style="margin-bottom:16px">
            <a href="{{ url('dashboard/posts') }}" class="btr-btn btr-btn-outline">Kembali</a>
            <a href="{{ url('dashboard/posts/' . $post->slug . '/edit') }}" class="btr-btn">Edit</a>
            <form action="{{ url('dashboard/posts/' . $post->slug) }}" method="post" style="display:inline" onsubmit="return confirm('Yakin hapus data?')">
                @method('delete')
                @csrf
                <button class="btr-btn" style="background:var(--danger-red)">Hapus</button>
            </form>
        </div>

        @if ($post->image)
            <img src="{{ asset($post->image) }}" alt="{{ $post->category->name }}" style="max-width:100%;border-radius:12px;margin-bottom:16px">
        @else
            <img src="https://source.unsplash.com/1200x400?{{ $post->category->name }}" alt="{{ $post->category->name }}" style="max-width:100%;border-radius:12px;margin-bottom:16px">
        @endif

        <article>{!! $post->body !!}</article>
    </div>
@endsection
