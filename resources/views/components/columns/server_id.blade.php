@if ($server)
@if (!array_key_exists('id', Route::current()->parameters))
<a href="{{ url('servers/' . $server['data']['id']) }}">
    @endif
    {{ $server['data']['attributes']['name'] }}
    @if (!array_key_exists('id', Route::current()->parameters))
</a>
@endif
<a href="{{ 'https://www.battlemetrics.com/servers/squad/' . $server['data']['id'] }}">
    <img src="https://cdn.battlemetrics.com/app/assets/logo.42129.svg" />
</a>
@else
{{ $id }}
@endif