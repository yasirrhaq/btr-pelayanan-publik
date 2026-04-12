@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Struktur Organisasi <small>Detail</small></h1>

    <div class="btr-card">
        <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap">
            <a href="{{ url('dashboard/struktur-organisasi') }}" class="btr-btn btr-btn-outline">Kembali</a>
            <a href="{{ url('dashboard/struktur-organisasi/' . $strukturOrganisasi->id . '/edit') }}" class="btr-btn btr-btn-yellow">Edit</a>
            <form action="{{ url('dashboard/struktur-organisasi/' . $strukturOrganisasi->id) }}" method="post" style="display:inline" onsubmit="return confirm('Yakin hapus data?')">
                @method('delete')
                @csrf
                <button type="submit" class="btr-btn" style="background:var(--danger-red)">Hapus</button>
            </form>
        </div>

        <h2 style="color:var(--text-primary);margin-bottom:18px">{{ $strukturOrganisasi->title }}</h2>

        @if ($strukturOrganisasi->path_image)
            <img src="{{ asset($strukturOrganisasi->path_image) }}" style="max-width:100%;border-radius:12px">
        @endif
    </div>
@endsection
