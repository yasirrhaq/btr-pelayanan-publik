@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Master Survei Kepuasan (9 Unsur)</h1>

    {{-- Add new --}}
    <div class="btr-card">
        <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Tambah Pertanyaan Baru</h3>
        <form action="{{ route('admin.master-survei.store') }}" method="POST" style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
            @csrf
            <div class="btr-form-group" style="flex:1; margin-bottom:0;">
                <label class="btr-label">Unsur</label>
                <input type="text" name="unsur" class="btr-input" required placeholder="Contoh: Persyaratan">
            </div>
            <div class="btr-form-group" style="flex:2; margin-bottom:0;">
                <label class="btr-label">Pertanyaan</label>
                <input type="text" name="pertanyaan" class="btr-input" required placeholder="Contoh: Bagaimana pendapat Anda tentang kesesuaian persyaratan pelayanan?">
            </div>
            <div class="btr-form-group" style="width:100px; margin-bottom:0;">
                <label class="btr-label">Urutan</label>
                <input type="number" name="urutan" class="btr-input" required value="{{ $pertanyaan->count() + 1 }}" min="1">
            </div>
            <button type="submit" class="btr-btn btr-btn-yellow" style="margin-bottom:0;">Tambah</button>
        </form>
    </div>

    {{-- List --}}
    <div class="btr-card">
        <div class="btr-table-wrap">
            <table class="btr-table">
                <thead>
                    <tr>
                        <th style="width:60px;">Urutan</th>
                        <th style="text-align:left;">Unsur</th>
                        <th style="text-align:left;">Pertanyaan</th>
                        <th style="width:80px;">Status</th>
                        <th style="width:120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pertanyaan as $p)
                        <tr>
                            <td>
                                <form action="{{ route('admin.master-survei.update', $p) }}" method="POST" class="inline-edit" style="display:inline;">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="unsur" value="{{ $p->unsur }}">
                                    <input type="hidden" name="pertanyaan" value="{{ $p->pertanyaan }}">
                                    <input type="number" name="urutan" value="{{ $p->urutan }}" min="1" class="btr-input" style="width:60px; padding:6px 8px; text-align:center;" onchange="this.form.submit();">
                                    <input type="hidden" name="is_active" value="{{ $p->is_active ? 1 : 0 }}">
                                </form>
                            </td>
                            <td style="text-align:left;">{{ $p->unsur }}</td>
                            <td style="text-align:left;">{{ $p->pertanyaan }}</td>
                            <td>
                                <form action="{{ route('admin.master-survei.update', $p) }}" method="POST" style="display:inline;">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="unsur" value="{{ $p->unsur }}">
                                    <input type="hidden" name="pertanyaan" value="{{ $p->pertanyaan }}">
                                    <input type="hidden" name="urutan" value="{{ $p->urutan }}">
                                    <input type="hidden" name="is_active" value="{{ $p->is_active ? 0 : 1 }}">
                                    @php($statusButtonStyle = 'background:none; border:none; cursor:pointer; font-weight:600; font-size:12px; color:' . ($p->is_active ? 'var(--success-green)' : 'var(--text-muted)') . ';')
                                    <button type="submit" style="{{ $statusButtonStyle }}">
                                        {{ $p->is_active ? 'Aktif' : 'Non-aktif' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.master-survei.destroy', $p) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin hapus pertanyaan ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btr-action delete" title="Hapus">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="color:var(--text-muted);">Belum ada pertanyaan survei.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
