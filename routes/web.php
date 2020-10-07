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
Route::get('/tickets/{ticket}/full-show', 'App\Http\Controllers\TicketsController@full_show')->name('tickets.full-show');
Route::post('/tickets/{ticket}/hide-ticket', 'App\Http\Controllers\TicketsController@hide_ticket')->name('tickets.hide-ticket');
Route::post('/tickets/{ticket}/hide-user-tickets', 'App\Http\Controllers\TicketsController@hide_user_tickets')->name('tickets.hide-user-tickets');

Route::get('/hidden-tickets', 'App\Http\Controllers\HiddenTicketsController@index')->name('hidden_tickets.index');
Route::get('/hidden-tickets/{ticket}', 'App\Http\Controllers\HiddenTicketsController@show')->name('hidden_tickets.show');
Route::get('/hidden-tickets/{ticket}/full-show', 'App\Http\Controllers\HiddenTicketsController@full_show')->name('hidden_tickets.full-show');
Route::post('/hidden-tickets/{ticket}/show-ticket', 'App\Http\Controllers\HiddenTicketsController@hide_ticket')->name('hidden_tickets.show-ticket');


Route::resource('/options', 'App\Http\Controllers\OptionsController');

Route::resource('/authors', 'App\Http\Controllers\AuthorController');
Route::post('/authors/{author}/hide-ticket', 'App\Http\Controllers\AuthorController@hide_ticket')->name('authors.hide-ticket');
Route::post('/authors/{author}/show-ticket', 'App\Http\Controllers\AuthorController@show_ticket')->name('authors.show-ticket');

Route::resource('/api_tickets', 'App\Http\Controllers\ApiTicketController');
Route::post('/api_tickets/{api_ticket}/send-import', 'App\Http\Controllers\ApiTicketController@send_import');

Route::get('/test', 'App\Http\Controllers\TestController@index')->name('test.index');
Route::post('/test', 'App\Http\Controllers\TestController@test')->name('test.test');

Route::get('/test-api/{api_id}', 'App\Http\Controllers\TestController@zendesk')->name('test.zendesk.api');
Route::get('/zendesk-api/{api_id}/tickets', 'App\Http\Controllers\TestController@zendesk_tickets')->name('test.zendesk.api.tickets');
Route::get('/zendesk-api/{api_id}/tickets/{tickets_id}/comments', 'App\Http\Controllers\TestController@zendesk_tickets_comments')->name('test.zendesk.api.tickets.comments');
