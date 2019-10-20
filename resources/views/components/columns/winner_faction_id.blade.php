@if ($team)
<span title="{{ $team->description }}">
    {{ $team->abbreviation }}
</span>
@else
{{ $id }}
@endif