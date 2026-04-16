@extends('pelanggan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Bantuan</h1>

    <div class="btr-card">
        <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 16px;">Pertanyaan yang Sering Diajukan (FAQ)</h3>

        <div style="display:flex; flex-direction:column; gap:12px;">
            <details style="border:1px solid var(--border-soft); border-radius:10px; padding:16px; cursor:pointer;">
                <summary style="font-weight:600; color:var(--text-primary); font-size:14px;">Bagaimana cara mengajukan permohonan layanan?</summary>
                <p style="color:var(--text-body); font-size:13px; margin:12px 0 0; line-height:1.6;">
                    Klik menu <strong>Ajukan Permohonan</strong> pada sidebar, kemudian ikuti langkah-langkah wizard:
                    pilih jenis layanan, konfirmasi data, isi detail permohonan, dan submit.
                </p>
            </details>

            <details style="border:1px solid var(--border-soft); border-radius:10px; padding:16px; cursor:pointer;">
                <summary style="font-weight:600; color:var(--text-primary); font-size:14px;">Bagaimana cara melakukan pembayaran?</summary>
                <p style="color:var(--text-body); font-size:13px; margin:12px 0 0; line-height:1.6;">
                    Setelah billing diterbitkan, Anda dapat melihat kode billing pada menu <strong>Pembayaran</strong>.
                    Lakukan pembayaran melalui bank yang ditunjuk, kemudian upload bukti pembayaran pada halaman detail pembayaran.
                </p>
            </details>

            <details style="border:1px solid var(--border-soft); border-radius:10px; padding:16px; cursor:pointer;">
                <summary style="font-weight:600; color:var(--text-primary); font-size:14px;">Bagaimana cara mengunduh dokumen hasil?</summary>
                <p style="color:var(--text-body); font-size:13px; margin:12px 0 0; line-height:1.6;">
                    Dokumen hasil dapat diunduh setelah Anda mengisi <strong>Survei Kepuasan Masyarakat</strong>.
                    Kunjungi menu <strong>Dokumen</strong> untuk melihat dan mengunduh dokumen yang tersedia.
                </p>
            </details>

            <details style="border:1px solid var(--border-soft); border-radius:10px; padding:16px; cursor:pointer;">
                <summary style="font-weight:600; color:var(--text-primary); font-size:14px;">Bagaimana cara melacak status permohonan?</summary>
                <p style="color:var(--text-body); font-size:13px; margin:12px 0 0; line-height:1.6;">
                    Gunakan menu <strong>Tracking Layanan</strong> dan masukkan nomor PL Anda untuk melihat progress terkini.
                </p>
            </details>

            <details style="border:1px solid var(--border-soft); border-radius:10px; padding:16px; cursor:pointer;">
                <summary style="font-weight:600; color:var(--text-primary); font-size:14px;">Siapa yang bisa saya hubungi jika ada masalah?</summary>
                <p style="color:var(--text-body); font-size:13px; margin:12px 0 0; line-height:1.6;">
                    Silakan hubungi tim layanan Balai Teknik Rawa melalui email atau telepon yang tertera di halaman utama website.
                </p>
            </details>
        </div>
    </div>

    <div class="btr-card" style="text-align:center; border-top:3px solid var(--accent-yellow);">
        <h3 style="font-size:15px; font-weight:700; color:var(--text-primary); margin:0 0 8px;">Butuh Bantuan Lebih?</h3>
        <p style="font-size:13px; color:var(--text-muted); line-height:1.6; margin:0;">
            Hubungi kami melalui email atau kunjungi kantor Balai Teknik Rawa pada jam kerja.
        </p>
    </div>
@endsection
