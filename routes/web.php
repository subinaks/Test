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


Route::get('/','UserManagement@register');

Route::post('verification/otp','UserManagement@verification');

Route::get('login','UserManagement@login');

Route::post('login/create','UserManagement@loginCreate');

Route::get('logout','UserManagement@logout');

Route::post('register/create','UserManagement@create');

Route::get('/profile','UserManagement@profile');

Route::post('profile/update/{id}','UserManagement@updateProfile');
