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


/* Account || User || Student Routes Part */

// Show All Courses Are In The Database
Route::get('/', 'StudentController@index')->name('account.index');
// To Register An Account For The Student
Route::get('account/sign-up', 'StudentController@create')->name('account.register')->middleware('guest');
// The Data Of Registering Goes Here
Route::post('account/sign-up', 'StudentController@store')->name('account.store')->middleware('guest');
// To Login For Student Who Has An Account
Route::get('account/sign-in', 'StudentController@create_sign_in')->name('account.login')->middleware('guest');
// To Reset The Password For The Student Who Has An Account
Route::get('account/account-password', 'StudentController@create_reset_password')->name('account.password')->middleware('auth');
// the Data Of Resetting Password Goes Here
Route::post('account/account-password', 'StudentController@reset_password')->name('account.password')->middleware('auth');
// To Show The Tickets Of The Student That Was Reserved
Route::get('account/tickets', 'StudentController@tickets')->name('account.ticket')->middleware('auth');
// To Show And Edit The Profile Information Of The Student
Route::get('account/profile/edit', 'StudentController@edit')->name('account.edit')->middleware('auth');
// The New Information Goes Here
Route::put('account/profile/update', 'StudentController@update')->name('account.update')->middleware('auth');
// To Show The Information Of A Course Before Reserved It
Route::get('{center}/Course/{course}', 'StudentController@show_course')->name('account.course_details');
// The Data Of Reserving A Course Goes Here
Route::post('{course}/Booking', 'StudentController@book_course_form')->name('account.course.booking')->middleware('auth');
// To Reserve The Course
Route::post('{course}/Reserve', 'StudentController@book_course_reservation')->name('account.course.booking.reserve');
// To Confirm The Payment Of A Course
Route::get('{course}/PaymentConfirmation', 'StudentController@payment_confirmation')->name('student.payment.confirmation')->middleware('auth');
// To Edit Payment Confirmation Of The Course
Route::get('{reservation}/PaymentConfirmation/edit', 'StudentController@edit_payment_confirmation_form')->name('student.payment.confirmation.edit')->middleware('auth');
// The Data Of Editing Payment Confirmation Goes Here
Route::put('{reservation}/PaymentConfirmation/update', 'StudentController@update_payment_confirmation_form')->name('student.payment.confirmation.update')->middleware('auth');
// The Data Of Confirmation Goes Here
Route::post('{course}/Confirmed', 'StudentController@confirm')->name('student.payment.confirmation.confirm')->middleware('auth');

/* End Of Account || User || Student Routes Part  */


/* Center Routes Part */

// To Show The Main Or The Index Page Of The Center
Route::get('center/{center}', 'CenterController@index')->name('center.index')->middleware('auth-center');
// When The Student Wants To Show The Information Of The Center
Route::get('center/profile/{name}', 'CenterController@show')->name('center.profile');
// To Show And Edit The Profile Information Of The Center
Route::get('center/profile/edit', 'CenterController@edit')->name('center.edit')->middleware('auth-center');
// The New Information Goes Here
Route::put('center/profile/update', 'CenterController@update')->name('center.update')->middleware('auth-center');
// To Create A New Trainer Belongs To The Center
Route::get('center/trainer/crate', 'CenterController@create_trainer')->name('center.trainer.create')->middleware('auth-center');
// The Information Of The Trainer Goes Here
Route::post('center/trainer/store', 'CenterController@store_trainer')->name('center.trainer.store')->middleware('auth-center');
// To Show All Trainers Who Belong To The Center
Route::get('center/trainers/show', 'CenterController@show_trainers')->name('center.trainer.show')->middleware('auth-center');
// To Edit A Trainer Information
Route::get('center/trainer/edit/{id}', 'CenterController@edit_trainer')->name('center.trainer.edit')->middleware('auth-center');
// The New Information Goes Here
Route::put('center/trainer/update/{id}', 'CenterController@update_trainer')->name('center.trainer.update')->middleware('auth-center');
// To Create An Admin For The Courses
Route::get('center/admin/crate', 'CenterController@create_admin')->name('center.admin.create')->middleware('auth-center');
// The Data Of The Creation Goes Here
Route::post('center/admin/store', 'CenterController@store_admin')->name('center.admin.store')->middleware('auth-center');
// To Show All Admins Who Belong To The Center
Route::get('center/admins/show', 'CenterController@show_admins')->name('center.admin.show')->middleware('auth-center');
// To Edit Admin Information
Route::get('center/admin/edit/{id}', 'CenterController@edit_admin')->name('center.admin.edit')->middleware('auth-center');
// The New Information Goes Here
Route::put('center/admin/update/{id}', 'CenterController@update_admin')->name('center.admin.update')->middleware('auth-center');
// To Assign Admin To The Course
Route::get('center/admin/assign', 'CenterController@assign_course_admin')->name('center.course.admin.assign')->middleware('auth-center');
// The Data Of Assignation Goes Here
Route::post('center/admin/assign/confirm', 'CenterController@store_course_admin')->name('center.course.admin.store')->middleware('auth-center');
// To Create A New Course
Route::get('center/course/create', 'CenterController@create_course')->name('center.course.create')->middleware('auth-center');
// The Data Of Creation Goes Here
Route::post('center/course/store', 'CenterController@store_course')->name('center.course.store')->middleware('auth-center');
// To Show All Courses Who Belong To The Center
Route::get('center/courses/show', 'CenterController@show_courses')->name('center.course.show')->middleware('auth-center');
// To Register As A Center
Route::get('sign-up', 'CenterController@register')->name('center.register')->middleware('guest');
// The Data Of Registering Goes Here
Route::post('sign-up', 'CenterController@store')->name('center.store')->middleware('guest');
// To Login As A Center
Route::get('sign-in', 'CenterController@login')->name('center.login')->middleware('guest');
// To Show Contacts Information Of The Site
Route::get('contact/contact-us', 'CenterController@contact_us')->name('contact.us');
// To Show About Us Information Of The Site
Route::get('contact/about-us', 'CenterController@about_us')->name('about.us');
// To Show The Form Of Resetting Password
Route::get('center/password/reset', 'CenterController@reset_password')->name('center.password.reset')->middleware('auth-center');
// The Data Of Resetting Password Goes Here And The Process Happens Here
Route::post('center/password/reset/confirm', 'CenterController@reset_password_confirm')->name('center.password.reset.confirm')->middleware('auth-center');
// To Show The Form Of Editing Or Adding Bank Account
Route::get('center/bank-accounts/edit', 'CenterController@edit_bank_account')->name('center.bank.account.edit')->middleware('auth-center');
// The Data Of Editing Or Adding Bank Account Goes Here And The Process Happens Here
Route::post('center/bank-accounts/update', 'CenterController@update_bank_account')->name('center.bank.account.update')->middleware('auth-center');
/*  End Of Center Routes Part */


/*  Admin Routes Part */
// The Index Page Of The Admin
Route::get('admin/{admin}', 'AdminController@index')->name('admin.index')->middleware('auth-center');
// To Show All Courses Of The Admin
Route::get('admin/courses/show', 'AdminController@show_courses')->name('admin.courses.show')->middleware('auth-center');

// To Show The Course That Will Confirm Payment For One Course
Route::get('admin/courses/payments', 'AdminController@courses_payment_show')->name('admin.courses.payment.show')->middleware('auth-center');
// T o Show The Course Information And The Student To Confirm The Payment For Them
Route::get('admin/{course}/payments', 'AdminController@show_courses_for_payment_confirmation')->name('admin.courses.payment')->middleware('auth-center');
// The Data Of Confirming Payment Goes Here And The Process Happens Here
Route::post('admin/{course}/payments', 'AdminController@payment_confirmation_confirm')->name('admin.courses.payment.confirm')->middleware('auth-center');
// To Show The List Of Courses To Activate Or Deactivate The Course
Route::get('admin/courses/activation', 'AdminController@courses_activation')->name('admin.courses.activation')->middleware('auth-center');
// To Show The List Of Courses To Activate Or Deactivate The Course
Route::post('admin/courses/activation/confirm', 'AdminController@courses_activation_confirm')->name('admin.courses.activation.confirm')->middleware('auth-center');


// To Show All Courses That Are Available To Select One And Move To Another Page
Route::get('admin/courses/students', 'AdminController@show_courses_for_show_student')->name('admin.courses.student.show')->middleware('auth-center');
// To Show The Student Of The Selected Course
Route::get('admin/{course}/students', 'AdminController@show_course_students')->name('admin.course.students.show')->middleware('auth-center');

// To Show The Form Of Editing A Course
Route::get('admin/course/edit/{course}', 'AdminController@course_edit')->name('admin.course.edit')->middleware('auth-center');
// The Data Of Editing Goes Here And The Process Happens Here
Route::put('admin/course/update/{course}', 'AdminController@course_update')->name('admin.course.update')->middleware('auth-center');

// To Show The Form Of Editing The Admin Information
Route::get('admin/profile/edit', 'AdminController@edit')->name('admin.edit')->middleware('auth-center');
// The Editing Data Goes Here And The Process Happens Here
Route::put('admin/profile/update', 'AdminController@update')->name('admin.update')->middleware('auth-center');

// To Show The Form Of Resetting Password Of Admin
Route::get('admin/password/reset', 'AdminController@reset_password')->name('admin.reset.password')->middleware('auth-center');
// The Data Of Resetting Password Goes Here And The Process Happens Here
Route::post('admin/password/reset/confirm', 'AdminController@reset_password_confirm')->name('admin.reset.password.confirm')->middleware('auth-center');

// Show All Courses That Are Available To Select One And Move To Another Page Of Show More Information
Route::get('admin/courses/attendance', 'AdminController@show_courses_for_students_attendance')->name('admin.courses.attendance')->middleware('auth-center');
// Show The Attendance Of The Selected Course
Route::get('admin/{course}/attendance', 'AdminController@show_student_attendance')->name('admin.course.attendance')->middleware('auth-center');

// Show All Courses That Are Available To Select One And Move To Another Page Of Show More Information
Route::get('admin/courses/take/attendance', 'AdminController@show_courses_for_take_students_attendance')->name('admin.courses.take.attendance')->middleware('auth-center');
// To Show The Schedule Of The Selected Course
Route::get('admin/{course}/schedule/', 'AdminController@show_course_schedule_for_take_attendance')->name('admin.course.schedule')->middleware('auth-center');
// Show The Attendance Of The Selected Course
Route::get('admin/{course}/take/attendance/{date}', 'AdminController@take_students_attendance')->name('admin.course.take.attendance')->middleware('auth-center');
Route::post('admin/{course}/take/attendance/{date}/confirm', 'AdminController@take_students_attendance_confirm')->name('admin.course.take.attendance.confirm')->middleware('auth-center');


/*  End Of Admin Routes Part */



/*  API Part */
// To Get The Cities Of A Counter
Route::get('api/v-1/cities/country={id}', 'CenterController@cities')->name('api.cities');
// To Get Account Information Of Center
Route::get('api/v-1/account/center={center_id}&bank={bank_id}', 'CenterController@bank_account')->name('api.center.bank.account');
// To Check The Coupon Result
Route::get('api/v-1/coupon/course={course}&coupon={coupon}', 'CenterController@check_coupon')->name('api.coupon.check');




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
