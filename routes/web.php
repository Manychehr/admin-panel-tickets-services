<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    dd( [
        /* $api = (new App\Services\ImportZendeskService)->getPage(2),
        (new App\Services\ImportZendeskService)->isNextPage($api), */
        /* App\Services\ImportZendeskService::getApi()->getToDayEvents(), */
        App\Services\ImportZendeskService::getApi()->getTicketComments(2),
        /* (new App\Services\ImportZendeskService)->getIncrementalEndTime($api2), */
    ] );
    return view('welcome');
});

Auth::routes();

Route::resource('/options', 'App\Http\Controllers\OptionsController');
Route::resource('/api_tickets', 'App\Http\Controllers\ApiTicketController');

Route::get('/test', 'App\Http\Controllers\TestController@index')->name('test.index');
Route::post('/test', 'App\Http\Controllers\TestController@test')->name('test.test');