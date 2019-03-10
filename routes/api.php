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


Route::group([
    'prefix' => 'account'
], function () {

    Route::get('/', 'StudentAPIController@index');
    Route::post('/register', 'StudentAPIController@register');
    Route::post('/login', 'StudentAPIController@login');
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



