<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// This Route Will Be Used With All The Users No Matter What Is Their Rule.
Route::post('Login', 'StudentAPIController@login');

// Account API Section
Route::group([
    'prefix' => 'Account'
], function () {

    Route::get('/', 'StudentAPIController@index');
    Route::post('/Register', 'StudentAPIController@register');
    Route::get('/{center}/{course}/CourseDetails', 'StudentAPIController@show_course');
    Route::get('/{center}/CenterDetails', 'StudentAPIController@show_center');


    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::post('/{course}/ReserveCourse', 'StudentAPIController@reserve_course');
        Route::post('/{course}/CancelCourseReservation', 'StudentAPIController@cancel_course_reservation');
        Route::get('/ProfileEdit', 'StudentAPIController@edit');
        Route::get('/Tickets', 'StudentAPIController@tickets');
        Route::post('/Me', 'StudentAPIController@me');
        Route::post('/ProfileUpdate', 'StudentAPIController@update');
        Route::post('/password/ResetPassword', 'StudentAPIController@reset_password');
    });
});

// Center API Section
Route::group([
    'prefix' => 'Center'
], function () {

//    Route::get('/', 'CenterAPIController@index');
    Route::post('/Register', 'CenterAPIController@register');
//    Route::get('/{center}/{course}/CourseDetails', 'StudentAPIController@show_course');
//    Route::get('/{center}/CenterDetails', 'StudentAPIController@show_center');


    Route::group([
        'middleware' => 'auth:api'
    ], function() {
//        Route::post('/{course}/ReserveCourse', 'StudentAPIController@reserve_course');
//        Route::post('/{course}/CancelCourseReservation', 'StudentAPIController@cancel_course_reservation');
//        Route::get('/ProfileEdit', 'StudentAPIController@edit');
//        Route::get('/Tickets', 'StudentAPIController@tickets');
//        Route::post('/Me', 'StudentAPIController@me');
//        Route::post('/ProfileUpdate', 'StudentAPIController@update');
//        Route::post('/password/ResetPassword', 'StudentAPIController@reset_password');
    });
});


