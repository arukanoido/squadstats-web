@if ($role)
<span title="{{ $role->description }}">
    {{ $role->name }}
</span>
@else
{{ $id }}
@endif