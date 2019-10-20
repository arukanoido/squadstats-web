@extends ('layouts.app')

@section ('title', 'Home')

@section ('content')
<h2>Homepage</h2>
<p>Last n matches</p>
@component('components._resultSet', ['resultSet' => $resultSet])
@endcomponent
@endsection