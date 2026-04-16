@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Tambah Tim Baru</h1>

    <div class="btr-card" style="max-width:700px;">
        <form action="{{ route('admin.master-tim.store') }}" method="POST">
            @csrf

            <div class="btr-form-group">
                <label class="btr-label" for="nama">Nama Tim</label>
                <input type="text" name="nama" id="nama" class="btr-input" value="{{ old('nama') }}" required placeholder="Contoh: Tim Advis Teknik 1">
                @error('nama')
                    <p style="color:var(--danger-red); font-size:13px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="jenis_layanan_id">Jenis Layanan</label>
                <select name="jenis_layanan_id" id="jenis_layanan_id" class="btr-select" required>
                    <option value="">-- Pilih Jenis Layanan --</option>
                    @foreach($jenisLayanan as $jl)
                        <option value="{{ $jl->id }}" {{ old('jenis_layanan_id') == $jl->id ? 'selected' : '' }}>{{ $jl->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Status</label>
                <label style="display:flex; align-items:center; gap:8px; font-size:14px; cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="accent-color:var(--sidebar-bg);">
                    Aktif
                </label>
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Anggota Tim</label>
                <div id="anggota-container">
                    <div class="anggota-row" style="display:flex; gap:12px; margin-bottom:10px; align-items:center;">
                        <select name="anggota[0][user_id]" class="btr-select" style="flex:1;" required>
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                        <select name="anggota[0][jabatan]" class="btr-select" style="width:160px;" required>
                            <option value="katim">Katim</option>
                            <option value="anggota" selected>Anggota</option>
                            <option value="analis">Analis</option>
                            <option value="penyelia">Penyelia</option>
                            <option value="teknisi">Teknisi</option>
                        </select>
                        <button type="button" class="btr-action delete" onclick="this.closest('.anggota-row').remove();" title="Hapus">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                <button type="button" class="btr-btn btr-btn-outline btr-btn-sm" onclick="addAnggota()">+ Tambah Anggota</button>
            </div>

            <div class="btr-form-actions">
                <a href="{{ route('admin.master-tim.index') }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn btr-btn-yellow">Simpan</button>
            </div>
        </form>
    </div>
@endsection

@push('js')
<script>
    var anggotaIdx = 1;
    function addAnggota() {
        var container = document.getElementById('anggota-container');
        var row = document.createElement('div');
        row.className = 'anggota-row';
        row.style.cssText = 'display:flex; gap:12px; margin-bottom:10px; align-items:center;';
        row.innerHTML = '<select name="anggota[' + anggotaIdx + '][user_id]" class="btr-select" style="flex:1;" required>' +
            '<option value="">-- Pilih User --</option>' +
            @foreach($users as $u)
            '<option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>' +
            @endforeach
            '</select>' +
            '<select name="anggota[' + anggotaIdx + '][jabatan]" class="btr-select" style="width:160px;" required>' +
            '<option value="katim">Katim</option><option value="anggota" selected>Anggota</option><option value="analis">Analis</option><option value="penyelia">Penyelia</option><option value="teknisi">Teknisi</option>' +
            '</select>' +
            '<button type="button" class="btr-action delete" onclick="this.closest(\'.anggota-row\').remove();" title="Hapus"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>';
        container.appendChild(row);
        anggotaIdx++;
    }
</script>
@endpush
