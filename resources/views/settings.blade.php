@extends ('layouts.app')

@section ('title', 'Settings')

@section ('content')
<h1>Settings</h1>
<form method="POST" action="{{ route('logout') }}" name="signout">
    @csrf
    <button type="submit">Logout</button>
</form>
@endsection