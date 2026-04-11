<h1>Hello {{ $email_data['name'] }}</h1>

Silahkan klik link di bawah ini untuk melakukan verifikasi email.<br><br>
<a href="{{ config('app.url') }}/verify?verification_token={{ $email_data['verification_token'] }}">Verifikasi Email</a>
<br><br>
Terimakasih,<br>
{{ config('app.name') }}
