<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'ProjectController@index');
Route::get('/projects/new', 'ProjectController@create')->name('create.project');
Route::post('/projects/new/submit', 'ProjectController@store')->name('store.project');
Route::get('/projects/{slug}/edit', 'ProjectController@read')->name('edit.project');
Route::put('/projects/{slug}/update', 'ProjectController@update')->name('update.project');
Route::delete('/projects/{slug}/delete', 'ProjectController@delete')->name('delete.project');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
