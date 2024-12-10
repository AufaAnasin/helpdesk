<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', function () {
    return view('dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
    Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
    Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
    Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
    Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
    Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
    Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);

    // Custom page Route ('resources/views')
    Route::get('tickets', ['as' => 'tickets', 'uses' => 'App\Http\Controllers\PageController@tickets']);
    Route::get('userlist', ['as' => 'user.list', 'uses' => 'App\Http\Controllers\UserController@listUsers']);
    Route::get('inputticket', ['as' => 'inputticket', 'uses' => 'App\Http\Controllers\PageController@inputticket']);

    // User CRUD
    Route::post('/users', ['as' => 'users.store', 'uses' => 'App\Http\Controllers\UserController@store']);
    Route::get('/userlist', ['as' => 'user.list', 'uses' => 'App\Http\Controllers\UserController@listUsers']);
    Route::delete('/userlist/{id}', ['as' => 'user.destroy', 'uses' => 'App\Http\Controllers\UserController@destroy']);

    // Ticket CRUD
    Route::post('/tickets', ['as' => 'tickets.store', 'uses' => 'App\Http\Controllers\TicketController@store']); // create tickets
    Route::get('/tickets', ['as' => 'tickets.list', 'uses' => 'App\Http\Controllers\TicketController@index']);
    Route::get('/tickets/{$id}', ['as' => 'tickets.show', 'uses' => 'App\Http\Controllers\TicketController@show']);
    Route::delete('/tickets/{id}', ['as' => 'tickets.destroy', 'uses' => 'App\Http\Controllers\TicketController@destroy']);
    Route::patch('/tickets/{id}/status', ['as' => 'tickets.updateStatus', 'uses' => 'App\Http\Controllers\TicketController@updateStatus']);

    // Comment CRUD
    Route::post('/tickets/{id}/comments', ['as' => 'tickets.addComment', 'uses' => 'App\Http\Controllers\TicketController@addComment']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});
