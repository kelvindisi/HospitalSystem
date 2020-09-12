<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admin'], function () {
        // Admin Routes
        Route::get('', 'AdminController@index')->name('admin_index');
        Route::get('/create', 'AdminController@create')->name('create_staff');
        Route::post('/create', 'AdminController@store')->name('store_staff');
        Route::get('/{user}', 'AdminController@details')->name('details_staff');
        Route::post('/role/add', 'AdminController@addRole')->name('add_role');
        Route::get('/staff/manage', 'AdminController@staffList')->name('staff_list');
        Route::put('/{user}', 'AdminController@statusChanger')->name('staff_status');
        Route::get('/edit/{user}', 'AdminController@edit')->name('edit_staff');
        Route::PATCH('/edit/{user}', 'AdminController@update')->name('update_staff');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
