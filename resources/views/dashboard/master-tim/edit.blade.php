@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">Edit Tim — {{ $tim->nama }}</h1>

    <div class="btr-card" style="max-width:700px;">
        <form action="{{ route('admin.master-tim.update', $tim) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="btr-form-group">
                <label class="btr-label" for="nama">Nama Tim</label>
                <input type="text" name="nama" id="nama" class="btr-input" value="{{ old('nama', $tim->nama) }}" required>
            </div>

            <div class="btr-form-group">
                <label class="btr-label" for="jenis_layanan_id">Jenis Layanan</label>
                <select name="jenis_layanan_id" id="jenis_layanan_id" class="btr-select" required>
                    @foreach($jenisLayanan as $jl)
                        <option value="{{ $jl->id }}" {{ $tim->jenis_layanan_id == $jl->id ? 'selected' : '' }}>{{ $jl->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Status</label>
                <label style="display:flex; align-items:center; gap:8px; font-size:14px; cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1" {{ $tim->is_active ? 'checked' : '' }} style="accent-color:var(--sidebar-bg);">
                    Aktif
                </label>
            </div>

            <div class="btr-form-group">
                <label class="btr-label">Anggota Tim</label>
                <div id="anggota-container">
                    @foreach($tim->anggota as $idx => $a)
                        <div class="anggota-row" style="display:flex; gap:12px; margin-bottom:10px; align-items:center;">
                            <select name="anggota[{{ $idx }}][user_id]" class="btr-select" style="flex:1;" required>
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" {{ $a->user_id == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                                @endforeach
                            </select>
                            <select name="anggota[{{ $idx }}][jabatan]" class="btr-select" style="width:160px;" required>
                                <option value="katim" {{ $a->jabatan === 'katim' ? 'selected' : '' }}>Katim</option>
                                <option value="anggota" {{ $a->jabatan === 'anggota' ? 'selected' : '' }}>Anggota</option>
                                <option value="analis" {{ $a->jabatan === 'analis' ? 'selected' : '' }}>Analis</option>
                                <option value="penyelia" {{ $a->jabatan === 'penyelia' ? 'selected' : '' }}>Penyelia</option>
                                <option value="teknisi" {{ $a->jabatan === 'teknisi' ? 'selected' : '' }}>Teknisi</option>
                            </select>
                            <button type="button" class="btr-action delete" onclick="this.closest('.anggota-row').remove();" title="Hapus">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    @endforeach
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
    var anggotaIdx = {{ $tim->anggota->count() }};
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
