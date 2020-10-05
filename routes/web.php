<?php

use App\Models\Ticket;
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

Auth::routes();

Route::get('/', 'App\Http\Controllers\TicketsController@index')->name('home');

Route::resource('/tickets', 'App\Http\Controllers\TicketsController');
Route::post('/tickets/{ticket}/hide-ticket', 'App\Http\Controllers\TicketsController@hide_ticket')->name('tickets.hide-ticket');
Route::post('/tickets/{ticket}/hide_user_tickets', 'App\Http\Controllers\TicketsController@hide-user-tickets')->name('tickets.hide-user-tickets');

Route::resource('/options', 'App\Http\Controllers\OptionsController');

Route::resource('/api_tickets', 'App\Http\Controllers\ApiTicketController');
Route::post('/api_tickets/{api_ticket}/send-import', 'App\Http\Controllers\ApiTicketController@send_import');

Route::get('/test', 'App\Http\Controllers\TestController@index')->name('test.index');
Route::post('/test', 'App\Http\Controllers\TestController@test')->name('test.test');

Route::get('/test-api', function () {
    dd( [
        /* Ticket::where('id', 2)->first()->data */
       /* App\Services\ImportZendeskService::getApi()->allTickets(1, 1), */
        /* (new App\Services\ImportZendeskService)->isNextPage($api), */
        /* App\Services\ImportZendeskService::getApi()->getToDayEvents(), */
        // App\Services\ImportZendeskService::getApi()->getTicketComments(2, 1, 1),
        /* (new App\Services\ImportZendeskService)->getIncrementalEndTime($api2), */
    ] );
    return view('welcome');
});