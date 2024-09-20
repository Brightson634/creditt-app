<p>Hi {{ $userName }},</p>
@if($loginAtemptStatus === 3)
<p>There was an attempted login into your account for three times on {{ $loginTime }}.</p>

<p>Details of the activity:</p>

<ul>
  <li><strong>IP Address:</strong> {{ $ipAddress }}</li>
  <li><strong>Device:</strong> {{ $device }} ({{ $platform }})</li>
  <li><strong>Browser:</strong> {{ $browser }}</li>
</ul>

{{-- <p>If this was you, no further action is required. If you did not perform this action, please <a href="{{ route('account.security') }}">secure your account</a> immediately.</p> --}}
<p>The next wrong password entry will result in the locking of the account!</p>
<p>Thank you,<br>{{ config('app.name') }}</p>
@elseif($loginAtemptStatus >3)
<p>This account has been locked due to many failed attempts to login</p>
<p>Please use this link to reset your password <a href="{{$secureLink}}">reset password</a></p>
<p>Thank you,<br>{{ config('app.name') }}</p>
@else
<p>Your account was successfully logged in on {{ $loginTime }}.</p>

<p>Details of the activity:</p>

<ul>
  <li><strong>IP Address:</strong> {{ $ipAddress }}</li>
  <li><strong>Device:</strong> {{ $device }} ({{ $platform }})</li>
  <li><strong>Browser:</strong> {{ $browser }}</li>
</ul>

{{-- <p>If this was you, no further action is required. If you did not perform this action, please <a href="{{ route('account.security') }}">secure your account</a> immediately.</p> --}}
<p>If this was you, no further action is required. If you did not perform this action, please <a href="{{$secureLink}}">secure your account</a> immediately.</p>
<p>Thank you,<br>{{ config('app.name') }}</p>
@endif
