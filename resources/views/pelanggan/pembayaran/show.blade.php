@extends('pelanggan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Pembayaran</h1>

    {{-- Billing Info --}}
    <div class="btr-billing-card">
        <h3>Tagihan Anda.</h3>
        <div class="btr-billing-row">
            <span class="label">No. PL</span>
            <span class="value">{{ $permohonan->nomor_pl }}</span>
        </div>
        @if($pembayaran)
            <div class="btr-billing-row">
                <span class="label">Nomor Billing</span>
                <span class="value">{{ $pembayaran->kode_billing }}</span>
            </div>
            <div class="btr-billing-row">
                <span class="label">Total Tagihan</span>
                <span class="value">Rp. {{ number_format($pembayaran->nominal, 0, ',', '.') }}</span>
            </div>
            <div class="btr-billing-row">
                <span class="label">Status</span>
                <span class="value">
                    <span class="btr-status-badge {{ $pembayaran->status === 'sudah_bayar' ? 'selesai' : ($pembayaran->status === 'ditolak' ? 'ditolak' : 'pembayaran') }}">
                        {{ ucfirst(str_replace('_', ' ', $pembayaran->status)) }}
                    </span>
                </span>
            </div>
        @else
            <p style="color:var(--text-muted); font-size:13px;">Data pembayaran belum tersedia.</p>
        @endif
    </div>

    {{-- Upload bukti bayar --}}
    @if($pembayaran && in_array($pembayaran->status, ['belum_bayar', 'ditolak']))
        <div class="btr-card">
            <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Upload Bukti Pembayaran</h3>

            @if($pembayaran->status === 'ditolak' && $pembayaran->catatan)
                <div class="btr-catatan" style="margin-bottom:16px;">
                    <strong>Alasan penolakan:</strong> {{ $pembayaran->catatan }}
                </div>
            @endif

            <form action="{{ route('pelanggan.pembayaran.upload', $permohonan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label class="btr-upload-area" for="bukti-bayar" style="margin-bottom:16px;">
                    <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                    <p id="bukti-label">Pilih File</p>
                    <input type="file" name="bukti_bayar" id="bukti-bayar" accept=".jpg,.jpeg,.png,.pdf" required>
                </label>

                @error('bukti_bayar')
                    <p style="color:var(--danger-red); font-size:13px; margin-bottom:12px;">{{ $message }}</p>
                @enderror

                <button type="submit" class="btr-btn btr-btn-yellow">Kirim Bukti Pembayaran</button>
            </form>
        </div>
    @endif

    {{-- PNBP Info --}}
    <div class="btr-info-card">
        <strong>Informasi terkait PNBP :</strong><br>
        Berdasarkan UU No. 9 Tahun 2018 tentang PNBP, seluruh tarif layanan mengacu pada ketentuan resmi pemerintah.
    </div>

    <div style="margin-top:20px;">
        <a href="{{ route('pelanggan.pembayaran.index') }}" class="btr-btn btr-btn-outline btr-btn-sm">Kembali</a>
    </div>
@endsection

@push('js')
<script>
    document.getElementById('bukti-bayar')?.addEventListener('change', function() {
        var label = document.getElementById('bukti-label');
        if (this.files.length > 0) label.textContent = this.files[0].name;
    });
</script>
@endpush
