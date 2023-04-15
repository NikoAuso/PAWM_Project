@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Mamateam/Celeste')
<img src="{{asset('assets/img/logo.png')}}" alt="logo" class="logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
