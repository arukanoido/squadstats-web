@if ($weapon)
<span title="{{ $weapon->description }}">
    {{ $weapon->name }}
</span>
@else
{{ $id }}
@endif