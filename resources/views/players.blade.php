@extends ('layouts.app')

@section ('title', 'Players')

@section ('content')
<h1>Players</h1>
<h3>Player List</h3>
@component('components._resultSet', ['resultSet' => $resultSet])
@endcomponent
@endsection