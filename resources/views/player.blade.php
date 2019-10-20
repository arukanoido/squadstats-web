@extends ('layouts.app')

@section ('title', $player->name)

@section ('content')
<h1>
    @component('components.columns.player_id', ['player' => $player])
    @endcomponent
</h1>
<h3>Recent Matches</h3>
@component('components._resultSet', ['resultSet' => $resultSet])
@endcomponent
@endsection