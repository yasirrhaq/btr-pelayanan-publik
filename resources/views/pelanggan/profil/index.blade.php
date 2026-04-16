@extends('pelanggan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Profil Pelanggan</h1>

    @php $user = auth()->user(); @endphp

    <div class="btr-card">
        <div style="display:flex; align-items:center; gap:20px; margin-bottom:24px;">
            <div class="btr-topbar-avatar" style="width:72px; height:72px; font-size:28px;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 style="font-size:18px; font-weight:600; color:var(--text-primary); margin:0 0 4px;">{{ $user->name }}</h2>
                <p style="font-size:13px; color:var(--text-muted); margin:0;">{{ $user->email }}</p>
            </div>
        </div>

        <div class="btr-table-wrap">
            <table class="btr-table">
                <tbody>
                    <tr>
                        <td style="text-align:left; font-weight:500; color:var(--text-muted); width:200px;">Nama Lengkap</td>
                        <td style="text-align:left;">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:left; font-weight:500; color:var(--text-muted);">Email</td>
                        <td style="text-align:left;">{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:left; font-weight:500; color:var(--text-muted);">No. HP / WA</td>
                        <td style="text-align:left;">{{ $user->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:left; font-weight:500; color:var(--text-muted);">Kategori Instansi</td>
                        <td style="text-align:left;">{{ $user->kategoriInstansi->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:left; font-weight:500; color:var(--text-muted);">Nama Instansi</td>
                        <td style="text-align:left;">{{ $user->instansi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:left; font-weight:500; color:var(--text-muted);">Alamat</td>
                        <td style="text-align:left;">{{ $user->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="text-align:left; font-weight:500; color:var(--text-muted);">Status Akun</td>
                        <td style="text-align:left;">
                            @if($user->is_verified)
                                <span class="btr-status-badge selesai">Terverifikasi</span>
                            @else
                                <span class="btr-status-badge pembayaran">Belum Terverifikasi</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="btr-form-actions" style="margin-top:20px;">
            <a href="{{ url('profile/password') }}" class="btr-btn btr-btn-outline btr-btn-sm">Ubah Password</a>
        </div>
    </div>
@endsection
