@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Master Tim</h1>

    <div class="btr-toolbar">
        <a href="{{ route('admin.master-tim.create') }}" class="btr-btn btr-btn-yellow">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Tambah Tim
        </a>
    </div>

    <div class="btr-card">
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th>Nama Tim</th>
                        <th>Jenis Layanan</th>
                        <th>Anggota</th>
                        <th>Katim</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tim as $t)
                        @php $katim = $t->anggota->where('jabatan', 'katim')->first(); @endphp
                        <tr>
                            <td style="text-align:left; font-weight:500;">{{ $t->nama }}</td>
                            <td>{{ $t->jenisLayanan->nama ?? '-' }}</td>
                            <td>{{ $t->anggota->count() }}</td>
                            <td>{{ $katim ? $katim->user->name : '-' }}</td>
                            <td>
                                @if($t->is_active)
                                    <span class="btr-status aktif">Aktif</span>
                                @else
                                    <span class="btr-status tidak-aktif">Non-aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btr-actions">
                                    <a href="{{ route('admin.master-tim.edit', $t) }}" class="btr-action edit" title="Edit">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2v-5m-1.414-9.414a2 2 0 1 1 2.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.master-tim.destroy', $t) }}" method="POST" class="btr-action-form" onsubmit="return confirm('Yakin hapus tim ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btr-action delete" title="Hapus">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="color:var(--text-muted);">Belum ada tim. Klik tombol di atas untuk menambahkan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tim->hasPages())
            <div style="margin-top:20px; display:flex; justify-content:center;">
                {{ $tim->links() }}
            </div>
        @endif
    </div>
@endsection
