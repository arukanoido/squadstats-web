@extends ('layouts.app')

@section ('title', 'Server ' . $id)

@section ('content')
<h1>
    @component('components.columns.server_id', ['value' => $id])
    @endcomponent
</h1>
<h3>Recent matches on server</h3>
@component('components._resultSet', ['resultSet' => $resultSet])
@endcomponent
@endsection