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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/courses/create', 'CourseController@create');
Route::post('/courses', 'CourseController@store');
Route::get('/courses/{course}', 'CourseController@show');

Route::get('/instructors/create', 'InstructorController@create');
Route::post('/instructors', 'InstructorController@store');
Route::get('/instructors/{instructor}', 'InstructorController@show');

Route::get('/certificates/{certificate}/download', 'CertificateDownloadController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
