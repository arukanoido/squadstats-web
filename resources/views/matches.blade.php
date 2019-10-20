@extends ('layouts.app')

@section ('title', 'Recent Matches')

@section ('content')
<h1>Recent Matches</h1>
<h3>Last 20 matches</h3>
@component('components._resultSet', ['resultSet' => $resultSet])
@endcomponent
@endsection