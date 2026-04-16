@extends('pelanggan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Notifikasi</h1>

    @if($notifikasi->where('read_at', null)->count() > 0)
        <div style="display:flex; justify-content:flex-end; margin-bottom:16px;">
            <form action="{{ route('pelanggan.notifikasi.markAllRead') }}" method="POST">
                @csrf
                <button type="submit" class="btr-btn btr-btn-outline btr-btn-sm">Tandai Semua Dibaca</button>
            </form>
        </div>
    @endif

    <div class="btr-notif-list">
        @forelse($notifikasi as $notif)
            <form action="{{ route('pelanggan.notifikasi.read', $notif) }}" method="POST" style="display:contents;">
                @csrf
                <button type="submit" class="btr-notif {{ $notif->read_at ? '' : 'unread' }}" style="border:none; text-align:left; font-family:inherit; font-size:inherit;">
                    <div class="btr-notif-icon">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2z"/></svg>
                    </div>
                    <div class="btr-notif-body">
                        <div class="text">{{ $notif->judul }}</div>
                        @if($notif->pesan)
                            <div class="text" style="font-size:13px; color:var(--text-muted);">{{ \Illuminate\Support\Str::limit($notif->pesan, 80) }}</div>
                        @endif
                        <div class="time">{{ $notif->created_at->diffForHumans() }}</div>
                    </div>
                </button>
            </form>
        @empty
            <div class="btr-card" style="text-align:center;">
                <p style="color:var(--text-muted);">Belum ada notifikasi.</p>
            </div>
        @endforelse
    </div>

    @if($notifikasi->hasPages())
        <div style="margin-top:20px; display:flex; justify-content:center;">
            {{ $notifikasi->links() }}
        </div>
    @endif
@endsection
