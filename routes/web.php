<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailtrapExample;

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

Route::get('/', 'PageController@index');
//Route::get('/', 'ProjectUrlController@status');
Route::get('/dashboard', 'PageController@dashboard');
Route::get('/projects', 'ProjectController@all');
Route::get('/projects/{slug}', 'ProjectController@show');
Route::get('/projects/{slug}/{url}/checks', 'CheckController@all');
Route::get('/projects/create/new', 'ProjectController@create')->name('create.project');
Route::post('/projects/new/submit', 'ProjectController@store')->name('store.project');
Route::get('/projects/{slug}/edit', 'ProjectController@edit')->name('edit.project');
Route::put('/projects/{slug}/update', 'ProjectController@update')->name('update.project');
Route::delete('/projects/{slug}/delete', 'ProjectController@delete')->name('delete.project');

Route::post('/projects/{slug}/url/submit', 'ProjectUrlController@store');
Route::get('/projects/{slug}/{id}/edit', 'ProjectUrlController@edit');
Route::put('/projects/url/{id}/update', 'ProjectUrlController@update');
Route::delete('/projects/{slug}/url/delete', 'ProjectUrlController@delete');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('send', 'UserController@email');

Route::get('/send-mails', function () {

    Mail::to('example@gmail.com')->send(new MailtrapExample());

    return 'A message has been sent to Mailtrap!';
});
