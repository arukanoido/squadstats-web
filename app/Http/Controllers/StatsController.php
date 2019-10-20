<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Athena;
use App\Models\User;

use kanalumaddela\LaravelSteamLogin\SteamUser;

class StatsController extends Controller
{
    public function home()
    {
        $resultSet = Athena::query(
            'WITH match_result AS '
            . '(SELECT timestamp, date_diff(\'second\', lag(timestamp) OVER (PARTITION BY match_id ORDER BY timestamp), timestamp) AS duration, '
            . 'match_id, map_id, faction_one_id, faction_two_id, winner_faction_id '
            . 'FROM ' . config('squadstats.table') . ' '
            . 'WHERE match_started IS NOT NULL OR match_ended IS NOT NULL '
            . 'ORDER BY timestamp LIMIT 40) '
            . 'SELECT * '
            . 'FROM match_result '
            . 'WHERE duration IS NOT NULL '
        );
        return view('home', ['resultSet' => $resultSet]);
    }

    public function search(Request $request)
    {
        return view('default', ['string' => $request->input('searchString')]);
    }

    public function settings()
    {
        return view('settings');
    }


    public function viewPlayers()
    {
        $resultSet = Athena::query(
            'SELECT player_id '
            . 'FROM ' . config('squadstats.table') . ' '
            . 'WHERE player_id IS NOT NULL '
            . 'GROUP BY player_id '
            . 'limit 20 '
        );
        return view('players', ['resultSet' => $resultSet]);
    }

    public function viewPlayer($id)
    {
        $resultSet = Athena::query(
            '
            SELECT a.timestamp, a.match_id, k.kills, d.deaths, r.revives, tk.teamkills
            FROM matchdatadb.squadstats_compact AS a
            LEFT JOIN (
                SELECT match_id, count(kill) AS kills 
                FROM ' . config('squadstats.table') . ' 
                WHERE ' . $id . ' IN (causer_id) 
                AND kill IS NOT NULL
                GROUP BY match_id, causer_id
            ) AS k ON a.match_id=k.match_id
            LEFT JOIN (
                SELECT match_id, count(kill) AS deaths 
                FROM ' . config('squadstats.table') . ' 
                WHERE ' . $id . ' IN (victim_id) 
                AND kill IS NOT NULL
                GROUP BY match_id, victim_id
            ) AS d ON a.match_id=d.match_id
            LEFT JOIN (
                SELECT match_id, count(revive) AS revives 
                FROM ' . config('squadstats.table') . ' 
                WHERE ' . $id . ' IN (causer_id) 
                AND revive IS NOT NULL
                GROUP BY match_id, causer_id
            ) AS r ON a.match_id=r.match_id
            LEFT JOIN (
                SELECT match_id, count(teamkill) AS teamkills
                FROM ' . config('squadstats.table') . ' 
                WHERE ' . $id . ' IN (causer_id) 
                AND teamkill IS NOT NULL
                GROUP BY match_id, causer_id
            ) AS tk ON a.match_id=tk.match_id
            WHERE a.match_id IN (
                SELECT match_id
                FROM ' . config('squadstats.table') . ' 
                WHERE ' . $id . ' IN (player_id)
                GROUP BY match_id
            )
            AND match_started IS NOT NULL
            ORDER BY a.timestamp
            LIMIT 20
            '
        );
        $player = (new SteamUser($id))->getUserInfo();
        $user = User::where('id', $id)->first();
        if ($user) 
        {
            $player->verified = $user->verified;
        }
        return view('player', ['player' => $player, 'resultSet' => $resultSet]);
    }

    public function viewServers()
    {
        $resultSet = Athena::query(
            '
            SELECT server_id, count(DISTINCT match_id) matches
            FROM ' . config('squadstats.table') . '
            WHERE server_id=0
            GROUP BY server_id
            LIMIT 20
            '
        );
        return view('servers', ['resultSet' => $resultSet]);
    }

    public function viewServer($id)
    {
        $resultSet = Athena::query(
            'WITH match_result AS '
            . '(SELECT timestamp, date_diff(\'second\', lag(timestamp) OVER (PARTITION BY match_id ORDER BY timestamp), timestamp) AS duration, '
            . 'match_id, map_id, faction_one_id, faction_two_id, winner_faction_id '
            . 'FROM ' . config('squadstats.table') . ' '
            . 'WHERE match_started IS NOT NULL OR match_ended IS NOT NULL AND server_id=' . $id . ' '
            . 'ORDER BY timestamp LIMIT 40) '
            . 'SELECT * '
            . 'FROM match_result '
            . 'WHERE duration IS NOT NULL '
        );
        return view('server', ['id' => $id, 'resultSet' => $resultSet]);
    }

    public function viewMatches()
    {
        $resultSet = Athena::query(
            'WITH match_result AS '
            . '(SELECT timestamp, date_diff(\'second\', lag(timestamp) OVER (PARTITION BY match_id ORDER BY timestamp), timestamp) AS duration, '
            . 'match_id, map_id, faction_one_id, faction_two_id, winner_faction_id '
            . 'FROM ' . config('squadstats.table') . ' '
            . 'WHERE match_started IS NOT NULL OR match_ended IS NOT NULL '
            . 'ORDER BY timestamp LIMIT 40) '
            . 'SELECT * '
            . 'FROM match_result '
            . 'WHERE duration IS NOT NULL '
        );
        return view('matches', ['resultSet' => $resultSet]);
    }

    public function viewMatch($id)
    {
        $resultSet = Athena::query(
            '
            SELECT a.player_id, k.kills, d.deaths, r.revives, tk.teamkills
            FROM matchdatadb.squadstats_compact AS a
            LEFT JOIN (
                SELECT causer_id, count(kill) AS kills 
                FROM ' . config('squadstats.table') . ' 
                WHERE match_id= ' . $id . ' 
                AND kill IS NOT NULL
                GROUP BY match_id, causer_id
            ) AS k ON a.player_id=k.causer_id
            LEFT JOIN (
                SELECT victim_id, count(kill) AS deaths 
                FROM ' . config('squadstats.table') . ' 
                WHERE match_id= ' . $id . ' 
                AND kill IS NOT NULL
                GROUP BY match_id, victim_id
            ) AS d ON a.player_id=d.victim_id
            LEFT JOIN (
                SELECT causer_id, count(revive) AS revives 
                FROM ' . config('squadstats.table') . ' 
                WHERE match_id= ' . $id . ' 
                AND revive IS NOT NULL
                GROUP BY match_id, causer_id
            ) AS r ON a.player_id=r.causer_id
            LEFT JOIN (
                SELECT causer_id, count(teamkill) AS teamkills 
                FROM ' . config('squadstats.table') . ' 
                WHERE match_id= ' . $id . ' 
                AND teamkill IS NOT NULL
                GROUP BY match_id, causer_id
            ) AS tk ON a.player_id=tk.causer_id
            WHERE a.player_id IN (
                SELECT DISTINCT player_id
                FROM ' . config('squadstats.table') . ' 
                WHERE match_id= ' . $id . ' 
                AND (
                    player_id IN (SELECT causer_id FROM matchdatadb.squadstats_compact WHERE match_id= ' . $id . ')
                    OR
                    player_id IN (SELECT victim_id FROM matchdatadb.squadstats_compact WHERE match_id= ' . $id . ')
                )
            )
            AND match_id= ' . $id . ' 
            GROUP BY a.player_id, k.kills, d.deaths, r.revives, tk.teamkills
            LIMIT 20
            '
        );
        return view('match', ['id' => $id, 'resultSet' => $resultSet]);
    }

}
