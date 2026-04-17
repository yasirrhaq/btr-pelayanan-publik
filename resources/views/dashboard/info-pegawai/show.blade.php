@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Profil - SDM <small>Detail Pegawai</small></h1>

    <div class="btr-card">
        <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap">
            <a href="{{ url('dashboard/info-pegawai') }}" class="btr-btn btr-btn-outline">Kembali</a>
            <a href="{{ url('dashboard/info-pegawai/' . $infoPegawai->id . '/edit') }}" class="btr-btn btr-btn-yellow">Edit</a>
            <form action="{{ url('dashboard/info-pegawai/' . $infoPegawai->id) }}" method="post" style="display:inline" onsubmit="return confirm('Yakin hapus data?')">
                @method('delete')
                @csrf
                <button type="submit" class="btr-btn" style="background:var(--danger-red)">Hapus</button>
            </form>
        </div>

        <div style="display:grid;gap:24px;grid-template-columns:minmax(0,280px) minmax(0,1fr);align-items:start;">
            <div>
                @if ($infoPegawai->path_image)
                    <img src="{{ asset($infoPegawai->path_image) }}" style="width:100%;max-width:280px;border-radius:18px;border:1px solid var(--border-soft);object-fit:cover;">
                @endif
            </div>
            <div>
                <h2 style="color:var(--text-primary);margin-bottom:18px">{{ $infoPegawai->title }}</h2>
                <div style="display:grid;gap:12px;">
                    <div><strong>NIP:</strong> {{ $infoPegawai->nip ?: '-' }}</div>
                    <div><strong>Jenis Kepegawaian:</strong> {{ $infoPegawai->jenis_kepegawaian ?: '-' }}</div>
                    <div><strong>Pangkat / Golongan:</strong> {{ $infoPegawai->pangkat_golongan ?: '-' }}</div>
                    <div><strong>Jabatan:</strong> {{ $infoPegawai->jabatan ?: '-' }}</div>
                    <div><strong>Instansi:</strong> {{ $infoPegawai->instansi ?: '-' }}</div>
                    <div><strong>Email:</strong> {{ $infoPegawai->email ?: '-' }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
