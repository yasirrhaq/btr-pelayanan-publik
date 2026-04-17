@php
    $btrAlertMap = $btrAlertMap ?? [
        'success' => 'btr-alert-success',
        'error' => 'btr-alert-error',
        'deleteError' => 'btr-alert-error',
        'info' => 'btr-alert-info',
    ];
@endphp

@foreach ($btrAlertMap as $key => $className)
    @if (session()->has($key))
        <div class="btr-alert {{ $className }}">{{ session($key) }}</div>
    @endif
@endforeach

@if (!empty($btrShowFirstError) && $errors->any())
    <div class="btr-alert btr-alert-error">{{ $errors->first() }}</div>
@endif
