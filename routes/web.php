<?php

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

/****************************************************
* ROUTES GUEST
****************************************************/

// Home Guest
Route::get('/', function () {
    return view('guest.welcome');
})->name('home');

// Post Index Guest
Route::get('/posts', 'PostController@index')->name('posts.index');

/****************************************************
* ROUTES AUTHENTICATION
****************************************************/
Auth::routes();


/****************************************************
* ROUTES ADMIN
****************************************************/
// Rotte con prefisso admin, con check su autenticazione avvenuta tramite middleware('auth') nella folder Admin (namespace)
Route::prefix('admin') // URI
    ->name('admin.') // PER EVITARE COLLISIONE CON POSTS.INDEX AGGIUNGI PREFISSO ANCHE SU NAME
    ->namespace('Admin') //ACTION
    ->middleware('auth')
    ->group(function(){

        // Admin Home
        //Con prefisso anche su name, il name diventa admin.home
        Route::get('/home', 'HomeController@index')->name('home'); 
        

        // Admin Posts
        Route::resource('/posts','PostController');
    });