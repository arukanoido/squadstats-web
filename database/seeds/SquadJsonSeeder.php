<?php

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;
use App\Models\Weapon;
use App\Models\Team;
use App\Models\Map;
use App\Models\Role;
use App\Models\Vehicle;

class SquadJsonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new Client();
        $res = $client->get(
            "https://solstice-science.glitch.me/",
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type' => 'application/json'
                ]
            ]
        );
        $body = $res->getBody();
        $squad = json_decode($body);
        
        foreach ($squad->weapons as $weapon)
        {
            Weapon::updateOrCreate([
                'id' => crc32($weapon->class)
            ], [
                'name' => $weapon->name,
                'description' => $weapon->description
            ]);
        }

        foreach ($squad->teams as $team) 
        {
            Team::updateOrCreate([
                'id' => crc32($team->name)
            ], [
                'name' => $team->name,
                'abbreviation' => $team->abbreviation,
                'description' => $team->description
            ]);
        }

        foreach ($squad->roles as $role) 
        {
            Role::updateOrCreate([
                'id' => crc32($role->name)
            ], [
                'name' => $role->name,
                'description' => $role->description
            ]);
        }

        foreach ($squad->vehicles as $vehicle) {
            Vehicle::updateOrCreate([
                'id' => crc32($vehicle->class)
            ], [
                'name' => $vehicle->name
            ]);
        }

    }
}
