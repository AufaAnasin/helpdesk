<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', function () {
    return view('dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
    // Custom page Route ('resources/views')
    Route::get('tickets', ['as' => 'tickets', 'uses' => 'App\Http\Controllers\PageController@tickets']);  // Admin only
    Route::get('userlist', ['as' => 'user.list', 'uses' => 'App\Http\Controllers\UserController@listUsers']); // Admin only
    Route::get('inputticket', ['as' => 'inputticket', 'uses' => 'App\Http\Controllers\PageController@inputticket']); // Admin and Client
    Route::get('/user-tickets', ['as' => 'user.tickets', 'uses' => 'App\Http\Controllers\TicketController@userTickets'])->middleware('auth'); // Admin and Client

    // Assets Management
    Route::get('/register-assets', ['as' => 'assetsmanagement.assetsregister', 'uses' => 'App\Http\Controllers\PageController@registerassets']); // Admin only
    Route::post('/register-assets', ['as' => 'assetsmanagement.store', 'uses' => 'App\Http\Controllers\AssetController@store']); // Admin only
    Route::get('/assets-list', ['as' => 'assetsmanagement.assetslist', 'uses' => 'App\Http\Controllers\PageController@assetslist']); // Admin only
    Route::get('/assets-list', ['as' => 'assetsmanagement.assetslist', 'uses' => 'App\Http\Controllers\AssetController@assetsLists']); // Admin only
    Route::get('/search-assets', ['as' => 'assetsmanagement.searchAssets', 'uses' => 'App\Http\Controllers\AssetController@searchAssets']); // Admin only
    Route::get('/asset-detail', ['as' => 'assetsmanagement.assetDetail', 'uses' => 'App\Http\Controllers\PageController@assetDetail']); // Admin only

    // User CRUD
    Route::post('/users', ['as' => 'users.store', 'uses' => 'App\Http\Controllers\UserController@store']); // Admin only
    Route::get('/userlist', ['as' => 'user.list', 'uses' => 'App\Http\Controllers\UserController@listUsers']); // Admin only
    Route::delete('/userlist/{id}', ['as' => 'user.destroy', 'uses' => 'App\Http\Controllers\UserController@destroy']); // Admin only

    // Ticket CRUD
    Route::post('/tickets', ['as' => 'tickets.store', 'uses' => 'App\Http\Controllers\TicketController@store']); // Admin and Client
    Route::get('/tickets', ['as' => 'tickets.list', 'uses' => 'App\Http\Controllers\TicketController@index']); // Admin only
    Route::get('/tickets/{id}', ['as' => 'tickets.show', 'uses' => 'App\Http\Controllers\TicketController@show']); // Admin and Client
    Route::get('/user-tickets', ['as' => 'user.tickets', 'uses' => 'App\Http\Controllers\TicketController@userTickets'])->middleware('auth');
    Route::delete('/tickets/{id}', ['as' => 'tickets.destroy', 'uses' => 'App\Http\Controllers\TicketController@destroy']); // Admin only
    Route::patch('/tickets/{id}/status', ['as' => 'tickets.updateStatus', 'uses' => 'App\Http\Controllers\TicketController@updateStatus']); // Admin only

    // Comment CRUD
    Route::post('/tickets/{id}/comments', ['as' => 'tickets.addComment','uses' => 'App\Http\Controllers\TicketController@addComment' ]); // Admin and Client
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});
