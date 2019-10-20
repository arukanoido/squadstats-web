@extends ('layouts.app')

@section ('title', 'Match ' . $id)

@section ('content')
<h1>Match {{ $id }}</h1>
<h3>Players in match</h3>
@component('components._resultSet', ['resultSet' => $resultSet])
@endcomponent
@endsection