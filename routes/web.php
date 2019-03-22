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
// This Function Handle The Filter Of Courses
Route::post('/', 'StudentController@filtered_index')->name('account.index.filtered');
// To Show The Information Of A Course Before Reserved It
Route::get('{center}/{course}/CourseDetails', 'StudentController@show_course')->name('account.course_details');
// To Show The Contact Us Page
Route::get('/contact-us', 'StudentController@contact_us')->name('account.contact_us');
// The Data Of Contacting Us
Route::post('/contact-us', 'StudentController@contact_us_confirm')->name('account.contact_us.confirm');

// This Group For Guest Only
Route::group(['middleware' => 'guest'], function () {
    // To Register An Account For The Student
    Route::get('/sign-up', 'StudentController@create')->name('account.register');
    // To Login For Student Who Has An Account
    Route::get('/sign-in', 'StudentController@create_sign_in')->name('account.login');
    // The Data Of Registering Goes Here
    Route::post('/sign-up', 'StudentController@store')->name('account.store');
});
// This Group For Auth Only
Route::group(['middleware' => 'auth'], function () {
    // To Show Center Details And Information
    Route::get('{center}/Profile', 'StudentController@show')->name('student.center.profile.show');
    // To Reset The Password For The Student Who Has An Account
    Route::post('/Password/Reset', 'StudentController@create_reset_password')->name('account.password.reset.form');
    // The Data Of Resetting Password Goes Here
    Route::post('/Password/Reset/Confirm', 'StudentController@reset_password')->name('account.password');
    // To Show The Tickets Of The Student That Was Reserved
    Route::get('/Tickets', 'StudentController@tickets')->name('account.ticket');
    // To Show The Tickets Of The Student That Was Reserved Search By Filter
    Route::post('/Tickets', 'StudentController@filtered_tickets')->name('account.ticket.filtered');
    // To Show And Edit The Profile Information Of The Student
    Route::get('/Profile/Edit', 'StudentController@edit')->name('account.edit');
    // The New Information Goes Here
    Route::put('/Profile/Update', 'StudentController@update')->name('account.update');
    // To Reserve The Course
    Route::post('{course}/ReserveCourse', 'StudentController@reservation_course_form')->name('account.course.reservation.form');
    // The Data Of Reserving A Course Goes Here
    Route::post('{course}/ReserveCourse/Confirm', 'StudentController@course_reservation_confirm')->name('account.course.reservation.confirm');
    // To Confirm The Payment Of A Course
    Route::get('{course}/PaymentConfirmation', 'StudentController@payment_confirmation')->name('student.payment.confirmation');
    // The Data Of Confirmation Goes Here
    Route::post('{course}/PaymentConfirmation/Confirm', 'StudentController@confirm')->name('student.payment.confirmation.confirm');
    // To Edit Payment Confirmation Of The Course
    Route::get('{reservation}/PaymentConfirmation/Edit', 'StudentController@edit_payment_confirmation_form')->name('student.payment.confirmation.edit');
    // The Data Of Editing Payment Confirmation Goes Here
    Route::put('{reservation}/PaymentConfirmation/Update', 'StudentController@update_payment_confirmation')->name('student.payment.confirmation.update');
    // To Cancel A Reservation That Is Not Confirmed Yet
    Route::get('{reservation}/CancelReservation', 'StudentController@destroy_course_reservation')->name('student.reservation.destroy');
    // To Get All The Certificates Of A User
    Route::get('/Certificates', 'StudentController@certificates')->name('account.certificates');
    // To Show The Certificate
    Route::get('/{course}/Certificate', 'StudentController@show_certificate')->name('account.certificate.show');
    // To Show The Ticket Of The Course
    Route::get('/{course}/CourseTicket', 'StudentController@show_course_ticket')->name('account.course.ticket.show');
});
/* End Of Account || User || Student Routes Part  */


/* Center Routes Part */


Route::group(['middleware' => 'guest'], function () {

    // To Register As A Center
    Route::get('Center/sign-up', 'CenterController@register')->name('center.register');
    // The Data Of Registering Goes Here
    Route::post('Center/sign-up', 'CenterController@store')->name('center.store');
    // To Login As A Center
    Route::get('Center/sign-in', 'CenterController@login')->name('center.login');

});

Route::group(['middleware' => 'auth-center'], function () {

    // To Show The Main Or The Index Page Of The Center
    Route::get('Center/{center}/Index', 'CenterController@index')->name('center.index');
    // To Show And Edit The Profile Information Of The Center
    Route::get('Center/Profile/Edit', 'CenterController@edit')->name('center.edit');
    // The New Information Goes Here
    Route::put('Center/Profile/Update', 'CenterController@update')->name('center.update');
    // To Edit The Information Of Social Media Accounts
    Route::get('Center/SocialMedia/Edit', 'CenterController@edit_social_media_account')->name('center.social.media.account.edit');
    // The Edit Data Goes Here And The Process Happens Here
    Route::put('Center/SocialMedia/Update', 'CenterController@update_social_media_account')->name('center.social.media.account.update');



    // To Edit The Information Of Social Media Accounts
    Route::get('Center/Halalah/Edit', 'CenterController@edit_halalah_account')->name('center.halalah.account.edit');
    // The Edit Data Goes Here And The Process Happens Here
    Route::put('Center/Halalah/Update', 'CenterController@update_halalah_account')->name('center.halalah.account.update');




    // To Create A New Trainer Belongs To The Center
    Route::get('Center/CreateTrainer', 'CenterController@create_trainer')->name('center.trainer.create');
    // The Information Of The Trainer Goes Here
    Route::post('Center/CreateStore', 'CenterController@store_trainer')->name('center.trainer.store');
    // To Show All Trainers Who Belong To The Center
    Route::get('Center/ShowTrainers', 'CenterController@show_trainers')->name('center.trainer.show');
    // To Edit A Trainer Information
    Route::get('Center/Trainer/Edit/{id}', 'CenterController@edit_trainer')->name('center.trainer.edit');
    // The New Information Goes Here
    Route::put('Center/Trainer/Update/{id}', 'CenterController@update_trainer')->name('center.trainer.update');
    // To Create An Admin For The Courses
    Route::get('Center/CreateAdmin/', 'CenterController@create_admin')->name('center.admin.create');
    // The Data Of The Creation Goes Here
    Route::post('Center/StoreAdmin', 'CenterController@store_admin')->name('center.admin.store');
    // To Show All Admins Who Belong To The Center
    Route::get('Center/ShowAdmins/show', 'CenterController@show_admins')->name('center.admin.show');
    // To Edit Admin Information
    Route::get('Center/Admin/Edit/{id}', 'CenterController@edit_admin')->name('center.admin.edit');
    // The New Information Goes Here
    Route::put('Center/Admin/Update/{id}', 'CenterController@update_admin')->name('center.admin.update');
    // To Assign Admin To The Course
    Route::get('Center/AssignAdmin', 'CenterController@assign_course_admin')->name('center.course.admin.assign');
    // The Data Of Assignation Goes Here
    Route::post('Center/AssignAdmin/Confirm', 'CenterController@store_course_admin')->name('center.course.admin.store');
    // To Create A New Course
    Route::get('Center/CreateCourse', 'CenterController@create_course')->name('center.course.create');
    // The Data Of Creation Goes Here
    Route::post('Center/StoreCourse', 'CenterController@store_course')->name('center.course.store');
    // To Show All Courses Who Belong To The Center
    Route::get('Center/ShowCourses', 'CenterController@show_courses')->name('center.course.show');
    // To Show The Form Of Resetting Password
    Route::get('Center/PasswordReset', 'CenterController@reset_password')->name('center.password.reset');
    // The Data Of Resetting Password Goes Here And The Process Happens Here
    Route::post('center/PasswordReset/Confirm', 'CenterController@reset_password_confirm')->name('center.password.reset.confirm');
    // To Show The Form Of Editing Or Adding Bank Account
    Route::get('Center/BankAccounts/Edit', 'CenterController@edit_bank_account')->name('center.bank.account.edit');
    // The Data Of Editing Or Adding Bank Account Goes Here And The Process Happens Here
    Route::put('Center/BankAccounts/Update', 'CenterController@update_bank_account')->name('center.bank.account.update');


});
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
// To Review A Selected Course
Route::get('admin/{course}/preview', 'AdminController@course_preview')->name('admin.courses.preview')->middleware('auth-center');
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
