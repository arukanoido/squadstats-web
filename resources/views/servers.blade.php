@extends ('layouts.app')

@section ('title', 'Servers')

@section ('content')
<h1>Servers</h1>
<h3>Server List</h3>
@component('components._resultSet', ['resultSet' => $resultSet])
@endcomponent
@endsection