@php
    $kaura_urls = \App\Models\UrlLayanan::all();
    $kaura_wa = $kaura_urls->filter(fn($u) => str_contains($u->url ?? '', 'wa.me'))->first() ?? $kaura_urls->find(8);
@endphp

@if ($kaura_wa)
    <a href="{{ $kaura_wa->url }}" target="_blank"
        class="fixed bottom-6 right-6 z-50 transition-transform hover:scale-110 cursor-pointer"
        title="Tanya Kami 24 Jam">
        <img src="{{ asset('assets/kaura-nobg.png') }}" alt="Tanya Kami" class="w-20 h-auto drop-shadow-xl">
    </a>
@endif
