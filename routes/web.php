<?php

use App\Http\Controllers\Auth\SteamLoginController;
use kanalumaddela\LaravelSteamLogin\Facades\SteamLogin;

SteamLogin::routes(['controller' => SteamLoginController::class]);

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'StatsController@home')->name('home');

Route::get('/settings', 'StatsController@settings')->name('settings')->middleware('auth');

Route::post('/search', 'StatsController@search');

Route::get('/players', 'StatsController@viewPlayers')->name('players');
Route::get('/players/{id}', 'StatsController@viewPlayer');

Route::get('/servers', 'StatsController@viewServers')->name('servers');
Route::get('/servers/{id}', 'StatsController@viewServer');

Route::get('/matches', 'StatsController@viewMatches')->name('matches');
Route::get('/matches/{id}', 'StatsController@viewMatch');