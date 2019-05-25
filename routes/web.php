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

// NHSxk1fz8FYx


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


Route::group(['prefix' => 'Center', 'middleware' => 'guest'], function () {

    // To Register As A Center
    Route::get('sign-up', 'CenterController@register')->name('center.register');
    // The Data Of Registering Goes Here
    Route::post('sign-up', 'CenterController@store')->name('center.store');
    // To Login As A Center
    Route::get('sign-in', 'CenterController@login')->name('center.login');

});

Route::group(['prefix' => 'Center', 'middleware' => 'auth-center'], function () {

    // To Show The Main Or The Index Page Of The Center
    Route::get('{center}/Index', 'CenterController@index')->name('center.index');
    // To Show And Edit The Profile Information Of The Center
    Route::get('Profile/Edit', 'CenterController@edit')->name('center.edit');
    // The New Information Goes Here
    Route::put('Profile/Update', 'CenterController@update')->name('center.update');
    // To Create Social Media Account
    Route::get('SocialMedia/Create', 'CenterController@create_social_media_account')->name('center.social.media.account.create');
    // The Data Of Creating Social Media Account
    Route::post('SocialMedia/Store', 'CenterController@store_social_media_account')->name('center.social.media.account.store');
    // To Show All Social Media Accounts
    Route::get('SocialMedia/Show', 'CenterController@show_social_media_account')->name('center.social.media.account.show');
    // To Edit The Information Of Social Media Accounts
    Route::get('SocialMedia/Edit/{id}', 'CenterController@edit_social_media_account')->name('center.social.media.account.edit');
    // The Edit Data Goes Here And The Process Happens Here
    Route::put('SocialMedia/Update/{id}', 'CenterController@update_social_media_account')->name('center.social.media.account.update');
    // To Delete Social Media Account
    Route::get('SocialMedia/Delete/{id}', 'CenterController@delete_social_media_account')->name('center.social.media.account.delete');
    // To Show Halalah Account
    Route::get('Halalah/Show', 'CenterController@show_halalah_account')->name('center.halalah.account.show');
    // To Create Halalah Account
    Route::get('Halalah/Create', 'CenterController@create_halalah_account')->name('center.halalah.account.create');
    // To Data Of Creating Halalah Account
    Route::post('Halalah/Store', 'CenterController@store_halalah_account')->name('center.halalah.account.store');
    // To Edit The Information Of Halalah Account
    Route::get('Halalah/Edit', 'CenterController@edit_halalah_account')->name('center.halalah.account.edit');
    // The Edit Data Goes Here And The Process Happens Here
    Route::put('Halalah/Update', 'CenterController@update_halalah_account')->name('center.halalah.account.update');
    // To Delete Halalah Account
    Route::put('Halalah/Delete', 'CenterController@delete_halalah_account')->name('center.halalah.account.delete');
    // To Create A New Trainer Belongs To The Center
    Route::get('CreateTrainer', 'CenterController@create_trainer')->name('center.trainer.create');
    // The Information Of The Trainer Goes Here
    Route::post('CreateStore', 'CenterController@store_trainer')->name('center.trainer.store');
    // To Show All Trainers Who Belong To The Center
    Route::get('ShowTrainers', 'CenterController@show_trainers')->name('center.trainer.show');
    // To Edit A Trainer Information
    Route::get('Trainer/Edit/{id}', 'CenterController@edit_trainer')->name('center.trainer.edit');
    // The New Information Goes Here
    Route::put('Trainer/Update/{id}', 'CenterController@update_trainer')->name('center.trainer.update');
    // To Create An Admin For The Courses
    Route::get('CreateAdmin/', 'CenterController@create_admin')->name('center.admin.create');
    // The Data Of The Creation Goes Here
    Route::post('StoreAdmin', 'CenterController@store_admin')->name('center.admin.store');
    // To Show All Admins Who Belong To The Center
    Route::get('ShowAdmins/show', 'CenterController@show_admins')->name('center.admin.show');
    // To Edit Admin Information
    Route::get('Admin/Edit/{id}', 'CenterController@edit_admin')->name('center.admin.edit');
    // The New Information Goes Here
    Route::put('Admin/Update/{id}', 'CenterController@update_admin')->name('center.admin.update');
    // To Assign Admin To The Course
    Route::get('AssignAdmin', 'CenterController@assign_course_admin')->name('center.course.admin.assign');
    // The Data Of Assignation Goes Here
    Route::post('AssignAdmin/Confirm', 'CenterController@store_course_admin')->name('center.course.admin.store');
    // To Create A New Course
    Route::get('CreateCourse', 'CenterController@create_course')->name('center.course.create');
    // The Data Of Creation Goes Here
    Route::post('StoreCourse', 'CenterController@store_course')->name('center.course.store');
    // To Show All Courses Who Belong To The Center
    Route::get('Courses/{type}/Show', 'CenterController@show_courses')->name('center.courses.show');
    // To Show All Students Of Specific Course
    Route::get('{identifier}/Students', 'CenterController@show_students')->name('center.students.show');
    // To Show The Form Of Resetting Password
    Route::get('PasswordReset', 'CenterController@reset_password')->name('center.reset.password');
    // The Data Of Resetting Password Goes Here And The Process Happens Here
    Route::post('PasswordReset/Confirm', 'CenterController@reset_password_confirm')->name('center.reset.password.confirm');
    // To Show The Form Of Creating Bank Account
    Route::get('BankAccount/Create', 'CenterController@create_bank_account')->name('center.bank.account.create');
    //The Data Of Creating Bank Account
    Route::post('BankAccount/Store', 'CenterController@store_bank_account')->name('center.bank.account.store');
    // To Show All Bank Account Of The Center
    Route::get('BankAccounts/Show', 'CenterController@show_bank_account')->name('center.bank.account.show');
    // To Show The Form Of Editing Or Adding Bank Account
    Route::get('BankAccount/Edit/{id}', 'CenterController@edit_bank_account')->name('center.bank.account.edit');
    // The Data Of Editing Or Adding Bank Account Goes Here And The Process Happens Here
    Route::put('BankAccount/Update/{id}', 'CenterController@update_bank_account')->name('center.bank.account.update');
    // To Delete Bank Account
    Route::get('BankAccount/Delete/{id}', 'CenterController@delete_bank_account')->name('center.bank.account.delete');
    // To Confirm Course Payment
    Route::get('{course}/Payment', 'CenterController@course_payment')->name('center.courses.payment');
    // The Data Of Confirming Course Payment
    Route::post('{course}/Payment/Confirm', 'CenterController@confirm_course_payment')->name('center.courses.payment.confirm');
    // To Activate Courses
    Route::get('Courses/Activation', 'CenterController@activate_deactivate_courses')->name('center.courses.activation');
    // The Data Of Activate And Deactivate Courses
    Route::post('Courses/Activation/Confirm', 'CenterController@activate_deactivate_courses_confirm')->name('center.courses.activation.confirm');
    // To Show Course Attendance
    Route::get('{course}/Attendance', 'CenterController@course_attendance')->name('center.courses.attendance');
    // To Show All Generated Certificates Of The Course
    Route::get('{course}/Certificates', 'CenterController@course_certificates')->name('center.courses.certificates');
    // To Show The Students To Generate Certificates For Them
    Route::get('{course}/Certificates/Generate', 'CenterController@generate_certificates')->name('center.courses.certificates.generate');
    // To Generate Certificate Of Student For One Course
    Route::post('{course}/Certificate/confirm', 'CenterController@generate_certificates_confirm')->name('center.courses.certificate.generate.confirm');
    // To Show The Financial Report Of The Center
    Route::get('Financial/Report', 'CenterController@financial_report')->name('center.financial.report');
    // To Show More Details About One Month Courses
    Route::get('Financial/Report/{date}', 'CenterController@month_financial_report')->name('center.financial.report.month');
    // To Show Student Attendance Details
    Route::get('{course}/Attendance/{student}', 'CenterController@student_attendance_details')->name('center.student.attendance.details');
    // To Show Course Schedule
    Route::get('{course}/Schedule/', 'CenterController@course_schedule')->name('center.course.schedule');
    // To Take Student Attendance
    Route::get('{course}/TakeAttendance/{date}', 'CenterController@take_attendance')->name('center.student.attendance.take');
    // The Data Of The Attendance
    Route::post('{course}/TakeAttendance/{date}', 'CenterController@take_attendance_confirm')->name('center.student.take.attendance.confirm');



    // To Show The Form Of Editing A Course
    Route::get('Course/Edit/{course}', 'CenterController@course_edit')->name('center.course.edit');
    // The Data Of Editing Goes Here And The Process Happens Here
    Route::put('Course/Update/{course}', 'CenterController@course_update')->name('center.course.update');

    // To Review A Selected Course
    Route::get('{course}/Preview', 'CenterController@course_preview')->name('center.courses.preview');



});
/*  End Of Center Routes Part */

/*  Admin Routes Part */

Route::group(['prefix' => 'Admin', 'middleware' => 'auth-center', 'namespace' => 'API'], function () {

    // The Index Page Of The Admin
    Route::get('/{admin}', 'AdminController@index')->name('admin.index');
    // To Show All Courses Of The Admin
    Route::get('Courses/Show', 'AdminController@show_courses')->name('admin.courses.show');
    // To Show The Course That Will Confirm Payment For One Course
    Route::get('Courses/Payments', 'AdminController@courses_payment_show')->name('admin.courses.payment.show');
    // To Show The Course Information And The Student To Confirm The Payment For Them
    Route::get('{course}/Payments/Students', 'AdminController@course_payment_show_students')->name('admin.courses.payment');
    // The Data Of Confirming Payment Goes Here And The Process Happens Here
    Route::post('{course}/Payment/Confirm', 'AdminController@course_payment_confirm')->name('admin.courses.payment.confirm');
    // To Show The List Of Courses To Activate Or Deactivate The Course
    Route::get('Courses/Activation', 'AdminController@courses_activation')->name('admin.courses.activation');
    // To Show The List Of Courses To Activate Or Deactivate The Course
    Route::post('CoursesActivation/Confirm', 'AdminController@courses_activation_confirm')->name('admin.courses.activation.confirm');
    // To Review A Selected Course
    Route::get('{course}/Preview', 'AdminController@course_preview')->name('admin.courses.preview');
    // To Show All Courses That Are Available To Select One And Move To Another Page
    Route::get('Courses/Students', 'AdminController@show_courses_for_show_student')->name('admin.courses.student.show');
    // To Show The Student Of The Selected Course
    Route::get('{course}/Students/Show', 'AdminController@show_course_students')->name('admin.course.students.show');
    // To Show The Form Of Editing A Course
    Route::get('Course/Edit/{course}', 'AdminController@course_edit')->name('admin.course.edit');
    // The Data Of Editing Goes Here And The Process Happens Here
    Route::put('Course/Update/{course}', 'AdminController@course_update')->name('admin.course.update');
    // To Show The Form Of Editing The Admin Information
    Route::get('Profile/Edit', 'AdminController@edit')->name('admin.edit');
    // The Editing Data Goes Here And The Process Happens Here
    Route::put('Profile/Update', 'AdminController@update')->name('admin.update');
    // To Show The Form Of Resetting Password Of Admin
    Route::get('Password/Reset', 'AdminController@reset_password')->name('admin.reset.password');
    // The Data Of Resetting Password Goes Here And The Process Happens Here
    Route::post('Password/Reset/Confirm', 'AdminController@reset_password_confirm')->name('admin.reset.password.confirm');
    // Show All Courses That Are Available To Select One And Move To Another Page Of Show More Information
    Route::get('Courses/Attendance', 'AdminController@show_courses_for_students_attendance')->name('admin.courses.attendance');
    // Show The Attendance Of The Selected Course
    Route::get('{course}/Attendance', 'AdminController@show_student_attendance')->name('admin.course.attendance');
    // Show All Courses That Are Available To Select One And Move To Another Page Of Show More Information
    Route::get('Courses/TakeAttendance', 'AdminController@show_courses_for_take_students_attendance')->name('admin.courses.take.attendance');
    // To Show The Schedule Of The Selected Course
    Route::get('{course}/Schedule', 'AdminController@show_course_schedule_for_take_attendance')->name('admin.course.schedule');
    // Show The Attendance Of The Selected Course
    Route::get('{course}/TakeAttendance/{date}', 'AdminController@take_students_attendance')->name('admin.course.take.attendance');
    // The Data Of Taking Attendance Goes Here And The Process Happens Here
    Route::post('{course}/TakeAttendance/{date}/Confirm', 'AdminController@take_students_attendance_confirm')->name('admin.course.take.attendance.confirm');
    // To Show All Course To Select One The Create Certificates For It
    Route::get('Courses/Certificates', 'AdminController@show_courses_for_creating_certificates')->name('admin.courses.certificate.create');
    // The Data Of Creating Certificates Goes Here And The Process Happens Here
    Route::get('{course}/Certificates/Students', 'AdminController@show_course_students_for_certificate')->name('admin.courses.certificate.students');
    // To Show All Students Who Get The Certificates
    Route::get('{course}/Certificates/Show', 'AdminController@show_students_certificate')->name('admin.courses.certificate.show');
    // To Generate Certificate For Student
    Route::post('{course}/Certificates/Students/Confirm', 'AdminController@generate_certificate')->name('admin.courses.certificate.confirm');

});

/*  End Of Admin Routes Part */


/* Administrator Part */
// 96b4b28dc1@mailboxy.fun
Route::group(['prefix' => 'Administrator', 'middleware' => 'guest'], function () {
    // To Register An Account For The Student
    Route::get('sign-up', 'AdministratorController@register')->name('administrator.register');
    // The Data Of Registering Goes Here
    Route::post('sign-up', 'AdministratorController@store')->name('administrator.store');
});

Route::group(['prefix' => 'Administrator', 'middleware' => 'auth-center'], function () {

    // The Index Page Of The Admin
    Route::get('{admin}', 'AdministratorController@index')->name('administrator.index');
    // To Show All Advertising Banners
    Route::get('AdvertisingBanner/Show', 'AdministratorController@show_banners')->name('administrator.advertising.banners.show');
    // To Show All Advertising Banners
    Route::get('AdvertisingBanner/Create', 'AdministratorController@create_banner')->name('administrator.advertising.banner.create');
    // To Show All Advertising Banners
    Route::post('AdvertisingBanner/Store', 'AdministratorController@store_banner')->name('administrator.advertising.banner.store');
    // To Show All Advertising Banners
    Route::get('AdvertisingBanner/Edit/{id}', 'AdministratorController@edit_banner')->name('administrator.advertising.banner.edit');
    // To Show All Advertising Banners
    Route::put('AdvertisingBanner/Update/{id}', 'AdministratorController@update_banner')->name('administrator.advertising.banner.update');
    // To Delete One Advertising Banner
    Route::get('AdvertisingBanner/Delete/{id}', 'AdministratorController@delete_banner')->name('administrator.advertising.banner.delete');
    // To Confirm Course
    Route::post('Courses/Confirmation/', 'AdministratorController@confirm_courses')->name('administrator.courses.confirmation');
    // To Preview Course Before Confirm It
    Route::get('{course}/Preview', 'AdministratorController@course_preview')->name('administrator.course.preview');
    // To Show All Contact Us Messages
    Route::get('Contact-Us/Show', 'AdministratorController@show_contact_us')->name('administrator.contact_us.show');
    // To Show All Students
    Route::get('Students/Show', 'AdministratorController@show_students')->name('administrator.students.show');
    // To Show All Public Courses For Confirmation
    Route::get('PublicCourses/Show', 'AdministratorController@show_public_courses')->name('administrator.courses.public.show');
    // To Show All Private Courses For Confirmation
    Route::get('PrivateCourses/Show', 'AdministratorController@show_private_courses')->name('administrator.courses.private.show');
    // To Show All Students For Activation And Deactivation
    Route::get('StudentActivation/Show', 'AdministratorController@show_students_for_activation')->name('administrator.students.activation.deactivation');
    // The Data Of Activation And Deactivation Students Goes here
    Route::post('StudentActivation/Confirm', 'AdministratorController@confirm_activation_deactivation_students')->name('administrator.students.activation.deactivation.confirm');
    // To Show All Trainers
    Route::get('Trainers/Show', 'AdministratorController@show_trainers')->name('administrator.trainers.show');
    // To Show All Centers
    Route::get('Centers/Show', 'AdministratorController@show_centers')->name('administrator.centers.show');
    // To Activate And Deactivate Centers
    Route::get('CentersActivation/Show', 'AdministratorController@show_centers_for_activation')->name('administrator.centers.activation.deactivation');
    // The Data Of Activation And Deactivation Centers Goes here
    Route::post('CentersActivation/Confirm', 'AdministratorController@confirm_activation_deactivation_centers')->name('administrator.centers.activation.deactivation.confirm');
    // To Show All Admins
    Route::get('Admins/Show', 'AdministratorController@show_admins')->name('administrator.admins.show');
    // To Activate And Deactivate Admins
    Route::get('AdminsActivation/Show', 'AdministratorController@show_admins_for_activation')->name('administrator.admins.activation.deactivation');
    // The Data Of Activation And Deactivation Centers Goes here
    Route::post('AdminsActivation/Confirm', 'AdministratorController@confirm_activation_deactivation_admins')->name('administrator.admins.activation.deactivation.confirm');
    // To Show All Centers Then To Show Courses Then Certificates
    Route::get('CentersCertificates/Show', 'AdministratorController@show_centers_for_certificates')->name('administrator.centers.certificates.show');
    // To Show All Courses Then Certificates
    Route::get('{center}/CoursesCertificates/Show', 'AdministratorController@show_courses_for_certificates')->name('administrator.courses.certificates.show');
    // To Show All Certificates Of Courses
    Route::get('{course}/Certificates/Show', 'AdministratorController@show_certificates')->name('administrator.certificates.show');
    // To Show The Form Of Resetting Student Email
    Route::get('StudentsEmailRest/Show', 'AdministratorController@show_students_for_reset_email')->name('administrators.students.reset.email.show');
    // To Show The Form Of Resetting Password Email For The Student | User
    Route::get('{student}/StudentEmailReset/Edit', 'AdministratorController@edit_student_email')->name('administrator.student.reset.email.edit');
    // The Data Of Resetting Password Email For The Student | User
    Route::put('{student}/EmailRest/Update', 'AdministratorController@update_student_email')->name('administrator.student.reset.email.update');
    // To Show The Form Of Resetting Center Email
    Route::get('CentersEmailReset/Show', 'AdministratorController@show_centers_for_reset_email')->name('administrator.centers.reset.email.show');
    // To Show The Form Of Resetting Password Email For The Student | User
    Route::get('{centers}/CenterEmailReset/Edit', 'AdministratorController@edit_center_email')->name('administrator.center.reset.email.edit');
    // The Data Of Resetting Password Email For The Student | User
    Route::put('{centers}/CenterEmailReset/Update', 'AdministratorController@update_center_email')->name('administrator.center.reset.email.update');
    // To Show The Form Of Resetting Admin Email
    Route::get('AdminsEmailReset/Show', 'AdministratorController@show_admins_for_reset_email')->name('administrator.admins.reset.email.show');
    // To Show The Form Of Resetting Password Email For The Student | User
    Route::get('{centers}/AdminEmailReset/Edit', 'AdministratorController@edit_admin_email')->name('administrator.admin.reset.email.edit');
    // The Data Of Resetting Password Email For The Student | User
    Route::put('{centers}/AdminEmailReset/Update', 'AdministratorController@update_admin_email')->name('administrator.admin.reset.email.update');
    // To Show The Form Of Resetting Administrator
    Route::get('Password/Reset/Edit', 'AdministratorController@reset_password')->name('administrator.reset.password');
    // The Data Of Resetting Administrator Password
    Route::post('Password/Reset/Update', 'AdministratorController@update_password')->name('administrator.reset.password.confirm');
    // To Show The Form Of Editing Administrator Information
    Route::get('Profile/Edit', 'AdministratorController@edit')->name('administrator.edit');
    // The Data Of Editing Administrator Information
    Route::put('Profile/Update', 'AdministratorController@update')->name('administrator.update');


});

/* End Of Administrator Part */

Route::group(['prefix' => 'Ajax'], function (){
    // To Get The Cities Of A Counter
    Route::get('Cities/{id}', 'AjaxController@cities')->name('cities');
    // To Get The All Banks Information
    Route::get('Banks/', 'AjaxController@banks')->name('banks');
    // To Check If Course Coupon Is Valid
    Route::get('Coupon/{course}/{coupon}', 'AjaxController@check_coupon')->name('check_coupon');
    // To Get Bank Account Information Of Center
    Route::get('Account/{center}/{bank_id}', 'AjaxController@center_bank_account')->name('center.bank.account');
    // To Get All Banks Accounts Information Of Center
    Route::get('Accounts/{center}', 'AjaxController@center_banks_accounts')->name('center.banks.accounts');
});

/* Authentication Routes Part */
Auth::routes();
