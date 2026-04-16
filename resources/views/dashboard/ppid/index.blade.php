@extends('dashboard.layouts.main')

@section('container')
    <h1 class="btr-page-title">PPID — Pejabat Pengelola Informasi & Dokumentasi</h1>

    <div class="btr-card">
        <p style="font-size:14px; color:var(--text-body); margin:0 0 20px; line-height:1.6;">
            Kelola informasi publik sesuai UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.
            Informasi dikelompokkan ke dalam 4 kategori di bawah ini.
        </p>

        <div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:16px;">
            <div style="border:1px solid var(--border-soft); border-radius:12px; padding:20px;">
                <h3 style="font-size:14px; font-weight:700; color:var(--text-primary); margin:0 0 8px;">Informasi Berkala</h3>
                <p style="font-size:13px; color:var(--text-muted); margin:0 0 12px;">Informasi yang wajib disediakan dan diumumkan secara berkala.</p>
                <a href="{{ url('dashboard/landing-page') }}?tipe=ppid-berkala" class="btr-btn btr-btn-sm btr-btn-outline">Kelola</a>
            </div>
            <div style="border:1px solid var(--border-soft); border-radius:12px; padding:20px;">
                <h3 style="font-size:14px; font-weight:700; color:var(--text-primary); margin:0 0 8px;">Informasi Serta Merta</h3>
                <p style="font-size:13px; color:var(--text-muted); margin:0 0 12px;">Informasi yang harus diumumkan secara serta merta.</p>
                <a href="{{ url('dashboard/landing-page') }}?tipe=ppid-serta-merta" class="btr-btn btr-btn-sm btr-btn-outline">Kelola</a>
            </div>
            <div style="border:1px solid var(--border-soft); border-radius:12px; padding:20px;">
                <h3 style="font-size:14px; font-weight:700; color:var(--text-primary); margin:0 0 8px;">Informasi Setiap Saat</h3>
                <p style="font-size:13px; color:var(--text-muted); margin:0 0 12px;">Informasi yang wajib tersedia setiap saat.</p>
                <a href="{{ url('dashboard/landing-page') }}?tipe=ppid-setiap-saat" class="btr-btn btr-btn-sm btr-btn-outline">Kelola</a>
            </div>
            <div style="border:1px solid var(--border-soft); border-radius:12px; padding:20px;">
                <h3 style="font-size:14px; font-weight:700; color:var(--text-primary); margin:0 0 8px;">Informasi Dikecualikan</h3>
                <p style="font-size:13px; color:var(--text-muted); margin:0 0 12px;">Informasi yang dikecualikan sesuai ketentuan.</p>
                <a href="{{ url('dashboard/landing-page') }}?tipe=ppid-dikecualikan" class="btr-btn btr-btn-sm btr-btn-outline">Kelola</a>
            </div>
        </div>
    </div>
@endsection
