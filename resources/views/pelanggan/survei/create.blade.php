@extends('pelanggan.layouts.main')

@section('container')
    <h1 class="btr-page-title">Survei Kepuasan Masyarakat</h1>

    <div class="btr-card">
        <p style="font-size:14px; color:var(--text-body); margin:0 0 8px; line-height:1.6;">
            Permohonan: <strong>{{ $permohonan->nomor_pl }}</strong> — {{ $permohonan->jenisLayanan->nama ?? '' }}
        </p>
        <p style="font-size:13px; color:var(--text-muted); margin:0 0 24px; line-height:1.6;">
            Silakan berikan penilaian Anda terhadap layanan yang telah diterima. Penilaian ini akan digunakan
            untuk meningkatkan kualitas pelayanan publik.
        </p>

        <form action="{{ route('pelanggan.survei.store', $permohonan) }}" method="POST">
            @csrf

            @foreach($pertanyaan as $idx => $q)
                <div class="btr-survey-question">
                    <div class="question-text">{{ ($idx + 1) }}. {{ $q->pertanyaan }}</div>
                    <div class="btr-radio-group">
                        <label class="btr-radio-label">
                            <input type="radio" name="jawaban[{{ $q->id }}]" value="1" {{ old("jawaban.{$q->id}") == 1 ? 'checked' : '' }} required>
                            1 - Tidak Baik
                        </label>
                        <label class="btr-radio-label">
                            <input type="radio" name="jawaban[{{ $q->id }}]" value="2" {{ old("jawaban.{$q->id}") == 2 ? 'checked' : '' }}>
                            2 - Kurang Baik
                        </label>
                        <label class="btr-radio-label">
                            <input type="radio" name="jawaban[{{ $q->id }}]" value="3" {{ old("jawaban.{$q->id}") == 3 ? 'checked' : '' }}>
                            3 - Baik
                        </label>
                        <label class="btr-radio-label">
                            <input type="radio" name="jawaban[{{ $q->id }}]" value="4" {{ old("jawaban.{$q->id}") == 4 ? 'checked' : '' }}>
                            4 - Sangat Baik
                        </label>
                    </div>
                    @error("jawaban.{$q->id}")
                        <p style="color:var(--danger-red); font-size:12px; margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            <div class="btr-form-group">
                <label class="btr-label" for="saran">Saran dan Masukan (opsional)</label>
                <textarea name="saran" id="saran" class="btr-textarea" style="min-height:100px;" placeholder="Tulis saran atau masukan Anda...">{{ old('saran') }}</textarea>
                @error('saran')
                    <p style="color:var(--danger-red); font-size:12px; margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="btr-form-actions">
                <a href="{{ route('pelanggan.permohonan.show', $permohonan) }}" class="btr-btn btr-btn-outline">Batal</a>
                <button type="submit" class="btr-btn btr-btn-yellow">Kirim Survei</button>
            </div>
        </form>
    </div>
@endsection
