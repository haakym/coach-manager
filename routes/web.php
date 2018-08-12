<?php

Route::get('/', 'CalendarController@index');

Route::get('/calendar', 'CalendarController@index')->name('calendar.index');
Route::get('/calendar/data', 'CalendarController@data');

Route::get('/courses/create', 'CourseController@create')->name('courses.create');
Route::post('/courses', 'CourseController@store');
Route::get('/courses/{course}/edit', 'CourseController@edit');
Route::post('/courses/{course}/instructors', 'CourseInstructorController@store')->name('courses.assign.instructor');
Route::get('/courses/{course}', 'CourseController@show')->name('courses.show');
Route::put('/courses/{course}', 'CourseController@update');

Route::get('/instructors/create', 'InstructorController@create')->name('instructors.create');
Route::post('/instructors', 'InstructorController@store');
Route::post('/instructors/{instructor}/certificates', 'InstructorCertificateController@store');
Route::get('/instructors/{instructor}/edit', 'InstructorController@edit');
Route::get('/instructors/{instructor}', 'InstructorController@show')->name('instructors.show');
Route::put('/instructors/{instructor}', 'InstructorController@update');

Route::get('/certificates/{certificate}/download', 'CertificateDownloadController')->name('certificates.download');

Route::get('resources/courses', 'DataTable\CourseController@index')->name('datatables.courses.index');
Route::get('resources/courses/data', 'DataTable\CourseController@data')->name('datatables.courses.data');

Route::get('resources/instructors', 'DataTable\InstructorController@index')->name('datatables.instructors.index');
Route::get('resources/instructors/data', 'DataTable\InstructorController@data')->name('datatables.instructors.data');
