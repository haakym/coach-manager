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

Route::get('/calendar', 'CalendarController@index')->name('calendar.index');
Route::get('/calendar/data', 'CalendarController@data');

Route::get('/courses/create', 'CourseController@create');
Route::post('/courses', 'CourseController@store');
Route::get('/courses/{course}/edit', 'CourseController@edit');
Route::post('/courses/{course}/instructors', 'CourseInstructorController@store')->name('courses.assign.instructor');
Route::get('/courses/{course}', 'CourseController@show');
Route::put('/courses/{course}', 'CourseController@update');

Route::get('/instructors/create', 'InstructorController@create');
Route::post('/instructors', 'InstructorController@store');
Route::post('/instructors/{instructor}/certificates', 'InstructorCertificateController@store');
Route::get('/instructors/{instructor}/edit', 'InstructorController@edit');
Route::get('/instructors/{instructor}', 'InstructorController@show');
Route::put('/instructors/{instructor}', 'InstructorController@update');

Route::get('/certificates/{certificate}/download', 'CertificateDownloadController')->name('certificates.download');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
