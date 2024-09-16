<p>Hi {{ $userName }},</p>

<p>Your account was successfully logged in on {{ $loginTime }}.</p>

<p>Details of the activity:</p>

<ul>
  <li><strong>IP Address:</strong> {{ $ipAddress }}</li>
  <li><strong>Device:</strong> {{ $device }} ({{ $platform }})</li>
  <li><strong>Browser:</strong> {{ $browser }}</li>
</ul>

{{-- <p>If this was you, no further action is required. If you did not perform this action, please <a href="{{ route('account.security') }}">secure your account</a> immediately.</p> --}}
<p>If this was you, no further action is required. If you did not perform this action, please <a href="#">secure your account</a> immediately.</p>
<p>Thank you,<br>{{ config('app.name') }}</p>
