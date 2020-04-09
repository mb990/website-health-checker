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

Route::get('/admin/projects', 'AdminProjectController@all');
Route::put('/admin/projects/{slug}/deactivate', 'AdminProjectController@deactivate')->name('deactivate.project');
Route::put('/admin/projects/{slug}/activate', 'AdminProjectController@activate')->name('activate.project');
Route::delete('/admin/projects/{slug}/delete', 'AdminProjectController@destroy')->name('destroy.project');

Route::get('/', 'PageController@index');
Route::get('/dashboard', 'PageController@dashboard');
Route::get('/settings/{slug}', 'NotificationSettingController@editGlobal');
Route::put('/settings/{slug}/update', 'NotificationSettingController@updateGlobal')->name('update.global.notificationSettings');
Route::get('/projects/{slug}/settings', 'NotificationSettingController@editSingleProject');
Route::put('/projects/{slug}/settings/update', 'NotificationSettingController@updateSingleProject')->name('update.singleProject.notificationSettings');
Route::get('/projects', 'ProjectController@all');
Route::get('/projects/{slug}', 'ProjectController@show');
Route::get('/projects/{slug}/{url}/checks', 'CheckController@all');
Route::get('/projects/create/new', 'ProjectController@create')->name('create.project');
Route::post('/projects/new/submit', 'ProjectController@store')->name('store.project');
Route::get('/projects/{slug}/edit', 'ProjectController@edit')->name('edit.project');
Route::put('/projects/{slug}/update', 'ProjectController@update')->name('update.project');
Route::delete('/projects/{slug}/delete', 'ProjectController@delete')->name('delete.project');

Route::post('/projects/{slug}/url/submit', 'ProjectUrlController@store')->name('store.projectUrl');
Route::get('/projects/{slug}/{id}/edit', 'ProjectUrlController@edit');
Route::put('/projects/url/{id}/update', 'ProjectUrlController@update')->name('update.projectUrl');
Route::delete('/projects/{slug}/url/delete', 'ProjectUrlController@delete')->name('delete.projectUrl');

Route::get('/projects/{slug}/invite', 'InviteController@invite')->name('invite');
Route::post('/projects/{slug}/process', 'InviteController@process')->name('process');
Route::get('/invitation/{projectSlug}/{userSlug}/{token}', 'InviteController@view')->name('view.invitation');
Route::delete('/invitation/{projectSlug}/{userSlug}/{token}/accepted', 'InviteController@accept')->name('accept');
Route::delete('/invitation/{token}/rejected', 'InviteController@reject')->name('reject');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('send', 'UserController@email');

Route::get('/send-mails', function () {

    Mail::to('example@gmail.com')->send(new MailtrapExample());

    return 'A message has been sent to Mailtrap!';
});

Route::get('/test', 'PageController@test');
