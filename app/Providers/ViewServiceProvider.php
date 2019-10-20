<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use kanalumaddela\LaravelSteamLogin\SteamUser;
use GuzzleHttp\Client;

use App\Models\User;
use App\Models\Team;
use App\Models\Weapon;
use App\Models\Role;
use App\Models\Vehicle;
use App\Models\Map;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('components.columns.player_id', function ($view) {
            if (!isset($view->player)) 
            {
                $player = (new SteamUser($view['value']))->getUserInfo();
                $user = User::where('id', $view['value'])->first();
                if ($user)
                {
                    $player->verified = $user->verified;
                }
                $view->with('player', $player);
            }
            else
            {
                $view->with('player', $view['player']);
            }
        });

        View::composer('components.columns.server_id', function ($view) {
            $client = new Client(['http_errors' => false]);
            $server = null;
            $res = $client->get(
                "https://api.battlemetrics.com/servers/" . $view['value'], 
                [
                    'headers' => [
                        'Accept' => 'application/json', 
                        'Content-type' => 'application/json'
                    ]
                ]
            );
            if ($res->getStatusCode() === 200) 
            {
                $body = $res->getBody();
                $server = json_decode($body, true);
            }
            $view->with(['id' => $view['value'], 'server' => $server]);
        });

        View::composer('components.columns.faction_id', function ($view) {
            $team = Team::where('id', $view['value'])->first();
            $view->with(['id' => $view['value'], 'team' => $team]);
        });

        View::composer('components.columns.faction_one_id', function ($view) {
            $team = Team::where('id', $view['value'])->first();
            $view->with(['id' => $view['value'], 'team' => $team]);
        });

        View::composer('components.columns.faction_two_id', function ($view) {
            $team = Team::where('id', $view['value'])->first();
            $view->with(['id' => $view['value'], 'team' => $team]);
        });

        View::composer('components.columns.winner_faction_id', function ($view) {
            $team = Team::where('id', $view['value'])->first();
            $view->with(['id' => $view['value'], 'team' => $team]);
        });

        View::composer('components.columns.weapon_id', function ($view) {
            $weapon = Weapon::where('id', $view['value'])->first();
            $view->with(['id' => $view['value'], 'weapon' => $weapon]);
        });

        View::composer('components.columns.role_id', function ($view) {
            $role = Role::where('id', $view['value'])->first();
            $view->with(['id' => $view['value'], 'role' => $role]);
        });

        View::composer('components.columns.vehicle_id', function ($view) {
            $vehicle = Vehicle::where('id', $view['value'])->first();
            $view->with(['id' => $view['value'], 'vehicle' => $vehicle]);
        });

        /*View::composer('components.columns.map_id', function ($view) {
            $map = map::where('id', $view['value'])->first();
            $view->with(['id' => $view['value'], 'map' => $map]);
        });*/
    }
}
