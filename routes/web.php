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


/* Account || User Routes Part */
Route::get('/', 'StudentController@index')->name('account.index');
Route::get('account/sign-up', 'StudentController@create')->name('account.register')->middleware('guest');
Route::post('account/sign-up', 'StudentController@store')->name('account.store')->middleware('guest');
Route::get('account/sign-in', 'StudentController@create_sign_in')->name('account.login')->middleware('guest');
Route::get('account/account-password', 'StudentController@create_reset_password')->name('account.password')->middleware('auth');
Route::post('account/account-password', 'StudentController@reset_password')->name('account.password')->middleware('auth');
Route::get('account/booking-tickets', 'StudentController@tickets')->name('account.ticket')->middleware('auth');
Route::get('account/account-profile', 'StudentController@edit')->name('account.edit')->middleware('auth');
Route::put('account/update', 'StudentController@update')->name('account.update')->middleware('auth');
Route::get('{center}/{course}', 'StudentController@show_course')->name('account.course_details');
Route::post('{course}/Booking', 'StudentController@book_course_form')->name('account.course.booking');

/* Center Routes Part */
Route::get('profile/{name}', 'CenterController@show')->name('center.profile');
Route::get('/{center}', 'CenterController@index')->name('center.index')->middleware('auth-center');
Route::put('center/update', 'CenterController@update')->name('center.update')->middleware('auth-center');
Route::get('center/center-profile', 'CenterController@edit')->name('center.edit')->middleware('auth-center');
Route::get('center/crate-trainer', 'CenterController@create_trainer')->name('center.trainer.create')->middleware('auth-center');
Route::post('center/crate-trainer', 'CenterController@store_trainer')->name('center.trainer.store')->middleware('auth-center');
Route::get('center/center-trainers', 'CenterController@show_trainers')->name('center.trainer.show')->middleware('auth-center');
Route::get('center/trainer-edit/{id}', 'CenterController@edit_trainer')->name('center.trainer.edit')->middleware('auth-center');
Route::put('center/trainer-edit/{id}', 'CenterController@update_trainer')->name('center.trainer.update')->middleware('auth-center');

Route::get('center/assign-admin', 'CenterController@assign_course_admin')->name('center.course.admin.assign')->middleware('auth-center');
Route::post('center/assign-admin', 'CenterController@store_course_admin')->name('center.course.admin.store')->middleware('auth-center');


Route::get('center/create-course', 'CenterController@create_course')->name('center.course.create')->middleware('auth-center');
Route::post('center/create-course', 'CenterController@store_course')->name('center.course.store')->middleware('auth-center');
Route::get('center/create-courses', 'CenterController@show_courses')->name('center.course.show')->middleware('auth-center');


Route::get('center/crate-admin', 'CenterController@create_admin')->name('center.admin.create')->middleware('auth-center');
Route::post('center/crate-admin', 'CenterController@store_admin')->name('center.admin.store')->middleware('auth-center');
Route::get('center/center-admins', 'CenterController@show_admins')->name('center.admin.show')->middleware('auth-center');
Route::get('center/admin-edit/{id}', 'CenterController@edit_admin')->name('center.admin.edit')->middleware('auth-center');
Route::put('center/admin-edit/{id}', 'CenterController@update_admin')->name('center.admin.update')->middleware('auth-center');


Route::get('center/center-sign-up', 'CenterController@create')->name('center.register')->middleware('guest');
Route::get('center/sign-in', 'CenterController@create_sign_in')->name('center.login')->middleware('guest');
Route::post('center/', 'CenterController@store')->name('center.store')->middleware('guest');


Route::get('api/v-1/cities/country={id}', 'CenterController@cities')->name('api.cities');

/* Test Routes Part */
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/master',
    function (){ return view('layouts.app');
});
Route::get('/master/v/1.2',
    function (){ return view('student.master-v-1-1');
    });

/* Authentication Routes Part */
Auth::routes();
