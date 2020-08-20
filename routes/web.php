<?php

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

Route::get('/', 'Site\HomeController@index');
Route::post('homesearch', 'Admin\HomeController@index')->name('homesearch');

Route::prefix('admin')->group(function(){

	Route::get('/', 'Admin\HomeController@index')->name('admin');

	Route::get('login', 'Admin\Auth\LoginController@index')->name('login');
	Route::post('login', 'Admin\Auth\LoginController@autenticar');

	Route::get('register', 'Admin\Auth\RegisterController@index')->name('register');
	Route::post('register', 'Admin\Auth\RegisterController@registrar');

	Route::post('logout', 'Admin\Auth\LoginController@logout')->name('logout');

	Route::resource('users', 'Admin\UserController');

	Route::get('profile', 'Admin\ProfileController@index')->name('profile');
	Route::put('profilesave', 'Admin\ProfileController@save')->name('profile.save');


	Route::get('settings', 'Admin\SettingController@index')->name('settings');
	Route::put('settingssave', 'Admin\SettingController@save')->name('settings.save');

	Route::resource('pages', 'Admin\PageController');

});

Route::fallback('Site\PageController@index');