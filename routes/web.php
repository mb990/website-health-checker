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
Route::get('/dashboard', 'PageController@dashboard');
Route::get('/settings/{slug}', 'NotificationSettingController@editAll');
Route::get('/projects/{slug}/settings', 'NotificationSettingController@editSingleProject');
Route::put('/projects/{slug}/settings/update', 'NotificationSettingController@updateSingleProject')->name('updateSingleProjectNotificationSettings');
Route::get('/projects', 'ProjectController@all');
Route::get('/projects/{slug}', 'ProjectController@show');
Route::get('/projects/{slug}/{url}/checks', 'CheckController@all');
Route::get('/projects/create/new', 'ProjectController@create')->name('create.project');
Route::post('/projects/new/submit', 'ProjectController@store')->name('store.project')->name('storeProject');
Route::get('/projects/{slug}/edit', 'ProjectController@edit')->name('edit.project');
Route::put('/projects/{slug}/update', 'ProjectController@update')->name('update.project')->name('updateProject');
Route::delete('/projects/{slug}/delete', 'ProjectController@delete')->name('delete.project')->name('deleteProject');

Route::post('/projects/{slug}/url/submit', 'ProjectUrlController@store')->name('storeProjectUrl');
Route::get('/projects/{slug}/{id}/edit', 'ProjectUrlController@edit');
Route::put('/projects/url/{id}/update', 'ProjectUrlController@update')->name('updateProjectUrl');
Route::delete('/projects/{slug}/url/delete', 'ProjectUrlController@delete')->name('deleteProjectUrl');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('send', 'UserController@email');

Route::get('/send-mails', function () {

    Mail::to('example@gmail.com')->send(new MailtrapExample());

    return 'A message has been sent to Mailtrap!';
});

Route::get('/test', 'PageController@test');
