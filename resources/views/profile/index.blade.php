@extends('profile.layouts.main')

@section('container')
    @php
        $user = auth()->user();
        $rows = [
            ['label' => 'Nama Pelanggan', 'value' => $user->name ?: '-'],
            ['label' => 'Kategori Instansi', 'value' => optional($user->kategoriInstansi)->name ?: '-'],
            ['label' => 'Nama Instansi', 'value' => $user->instansi ?: '-'],
            ['label' => 'Alamat', 'value' => $user->alamat ?: '-'],
            ['label' => 'No. Telp (wa)', 'value' => $user->no_hp ?: '-'],
            ['label' => 'Email', 'value' => $user->email ?: '-'],
        ];
    @endphp

    <h1 class="btr-page-title">Profil Pelanggan</h1>

    <div class="btr-profile-card">
        <div class="btr-profile-grid">
            @foreach ($rows as $row)
                <div class="btr-profile-label">{{ $row['label'] }}</div>
                <div class="btr-profile-sep">:</div>
                <div class="btr-profile-value">
                    @if (in_array($row['label'], ['No. Telp (wa)', 'Email']))
                        <span class="btr-profile-pill">{{ $row['value'] }}</span>
                    @else
                        {{ $row['value'] }}
                    @endif
                </div>
            @endforeach

            <div class="btr-profile-label">Password</div>
            <div class="btr-profile-sep">:</div>
            <div class="btr-profile-value">
                <span class="btr-profile-pill btr-profile-password-mask">******</span>
            </div>
        </div>

        <div class="btr-profile-actions">
            <a href="{{ url('/profile/password') }}" class="btr-btn">Edit</a>
        </div>
    </div>
@endsection
