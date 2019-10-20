@if (Route::current()->uri() !== "players/{id}")
<a href="{{ url('players/' . $player->steamId) }}">
    @endif
    <img src="{{ $player->avatarSmall }}" />
    {{ $player->name }}
    @if ($player->verified)
    <span title="Verified User">
        &#9989
    </span>
    @endif
    <a title="Steam Profile" href="{{ $player->accountUrl }}">
        <img src="https://steamstore-a.akamaihd.net/public/shared/images/responsive/share_steam_logo.png" style="height: 32px;" />
    </a>
    @if (!Route::current()->uri() !== "players/{id}")
</a>
@endif