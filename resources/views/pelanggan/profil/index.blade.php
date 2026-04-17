@extends('pelanggan.layouts.main')

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

    <style>
        .btr-profile-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: var(--shadow-card);
            padding: 32px 28px 34px;
        }
        .btr-profile-grid {
            display: grid;
            grid-template-columns: 150px 20px minmax(0, 1fr);
            gap: 18px 18px;
            align-items: center;
        }
        .btr-profile-label {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-body);
        }
        .btr-profile-sep {
            text-align: center;
            font-weight: 600;
            color: #94A3B8;
        }
        .btr-profile-value {
            font-size: 14px;
            color: #111827;
            min-width: 0;
        }
        .btr-profile-pill {
            display: inline-flex;
            align-items: center;
            min-height: 40px;
            padding: 8px 14px;
            border-radius: 14px;
            background: #F8FAFC;
            border: 1px solid #EEF2F7;
            width: min(100%, 540px);
            line-height: 1.5;
            word-break: break-word;
        }
        .btr-profile-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 34px;
        }
        .btr-profile-actions .btr-btn {
            min-width: 132px;
            justify-content: center;
        }
        .btr-profile-password-mask {
            letter-spacing: 0.18em;
            font-weight: 600;
        }
        @media (max-width: 900px) {
            .btr-profile-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            .btr-profile-sep {
                display: none;
            }
            .btr-profile-label {
                font-size: 13px;
                color: var(--text-muted);
            }
            .btr-profile-value {
                margin-bottom: 8px;
            }
            .btr-profile-pill {
                width: 100%;
            }
            .btr-profile-card {
                padding: 22px 18px;
            }
        }
    </style>

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
            <a href="{{ route('pelanggan.profil.edit') }}" class="btr-btn">Edit</a>
        </div>
    </div>
@endsection
