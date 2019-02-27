<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Category;
use App\City;
use App\Country;
use App\Trainer;
use App\User;
use App\Course;
use App\CourseAdmin;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // To Show The Main Page Of The Admin
    public function index($admin)
    {
        if ($admin == Auth::user()->username) {

            $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();

            $course_admin = array();
            $course_attender = array();

            $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

            for ($i = 0; $i < count($courses_data); $i++) {

                $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

                if ( count($course_admin_data) > 0 ){

                    if ($course_admin_data->role_id == 1) {
                        array_push($course_admin, $course_admin_data->course_id);
                    } else {
                        array_push($course_attender, $course_admin_data->course_id);
                    }

                }

            }

            $course_admin = count($course_admin);
            $course_attender = count($course_attender);
            return view('admin.index', compact('courseAdmin', 'course_admin', 'course_attender'));
        } else {
            return abort(404);
        }
//        return view('admin.index', compact('courses'));
    }
    // To Show The Form Of Confirming The Payment Of The Course
    public function payment_confirmation($identifier)
    {
        $course = Course::where('identifier', $identifier)->first();
        if (count($identifier) <= 0) {
            abort(404);
        }

        $course_admin = array();
        $course_attender = array();

        $courses = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses); $i++) {
            $course_admin_data = CourseAdmin::where('admin_id', $courses[$i]->id)->get();

            if ($course_admin_data[$i]->role_id == 1) {
                array_push($course_admin, $course_admin_data[$i]->course_id);
            } else {
                array_push($course_attender, $course_admin_data[$i]->course_id);
            }
        }

        $course_admin = count($course_admin);
        $course_attender = count($course_attender);
        return view('admin.confirm-payment', compact('course', 'course_admin', 'course_attender'));
    }
    // The Data Of Confirming The Payment Goes Here And The Process Happens Here
    public function payment_confirmation_confirm(Request $request, $identifier){

        $course = Course::where('identifier', $identifier)->first();

        if ( count($course) == 0 ){
            abort(404);
        }

        $reservations_data = Reservation::where('appointment_id', $course->appointment->id)->get();

        $students = array();
        $identifiers = array();

        foreach ($reservations_data as $reservation){
            array_push($students, $reservation->student_id);
            array_push($identifiers, $reservation->identifier);
        }

//        dd($students);

        $request->validate([
            'student' => 'required|array|max:'.count($students),
            'student.*' => 'required|integer|'.Rule::in($students),
            'payment' => 'required|array|size:'.count($students),
            'payment.*' => 'required|integer|max:1|min:0',
            'identifier' => 'required|array|max:'.count($students).'size:'.count($students),
            'identifier.*' => 'required|string|max:10|min:10|'.Rule::in($identifiers),
        ]);

        $counter = 0;

        for ($i = 0; $i < count($students); $i++){
            if ( $request->payment[$i] == 1 ){
                $reservation = Reservation::where('student_id', $students[$i])->where('identifier', $identifiers[$i])->first();
                $reservation->confirmation = 1;
                $reservation->save();
                $counter++;
            }
        }

        if( $counter == 0 ){
            return redirect()->route('admin.courses.payment', $identifier)->withErrors(['الزجاء قم بتحديث بعض البيانات لكي يتم حفظها']);
        }
        return redirect()->route('admin.courses.payment', $identifier)->with('success', 'تم تأكيد الدفع بنجاح');
    }
    // To Show All Course
    public function show_courses(){
        $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();

        $course_admin = array();
        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

            if ( count($course_admin_data) > 0 ){

                if ($course_admin_data->role_id == 1) {
                    array_push($course_admin, $course_admin_data->course_id);
                } else {
                    array_push($course_attender, $course_admin_data->course_id);
                }

            }

        }

        $course_admin = count($course_admin);
        $course_attender = count($course_attender);

        return view('admin.show-courses', compact('courseAdmin', 'course_admin', 'course_attender'));
    }
    // To Show The Table Of All Courses That Will Confirm Payments For
    public function courses_payment_show(){
        $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();

        $course_admin = array();
        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

            if ( count($course_admin_data) > 0 ){

                if ($course_admin_data->role_id == 1) {
                    array_push($course_admin, $course_admin_data->course_id);
                } else {
                    array_push($course_attender, $course_admin_data->course_id);
                }

            }

        }

        $course_admin = count($course_admin);
        $course_attender = count($course_attender);
        return view('admin.all-courses-payment', compact('courseAdmin' ,'course_admin', 'course_attender'));
    }
    // To Show The Table Of All Courses That Will Show Their Student Who Are Registered
    public function courses_student_show(){
        $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();

        $course_admin = array();
        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

            if ( count($course_admin_data) > 0 ){

                if ($course_admin_data->role_id == 1) {
                    array_push($course_admin, $course_admin_data->course_id);
                } else {
                    array_push($course_attender, $course_admin_data->course_id);
                }

            }

        }

        $course_admin = count($course_admin);
        $course_attender = count($course_attender);
        return view('admin.all-courses-students', compact('courseAdmin' ,'course_admin', 'course_attender'));
    }
    // To Show One Course Student
    public function course_student_show($identifier){
        $course_ = Course::where('identifier', $identifier)->first();

        if ( count($course_) == 0 ){
            abort(404);
        }

        $admin_courses = CourseAdmin::where('admin_id', Auth::user()->admin->id)->get();
        $courses_identifiers = array();

        foreach ($admin_courses as $course){
            array_push($courses_identifiers, $course->course->identifier);
        }

        if ( !in_array($identifier, $courses_identifiers) ){
            abort(404);
        }

        $students = Reservation::where('course_id', $course_->id)->get();

        $course_admin = array();
        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

            if ( count($course_admin_data) > 0 ){

                if ($course_admin_data->role_id == 1) {
                    array_push($course_admin, $course_admin_data->course_id);
                } else {
                    array_push($course_attender, $course_admin_data->course_id);
                }

            }

        }

        $course_admin = count($course_admin);
        $course_attender = count($course_attender);
        return view('admin.show-course-students', compact('course_', 'students' ,'course_admin', 'course_attender'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }
    // To Show The View Of Editing The Information Of The Admin
    public function edit()
    {
        $admin = User::find(Auth::user()->admin->user_id);

        $course_admin = array();
        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

            if ( count($course_admin_data) > 0 ){

                if ($course_admin_data->role_id == 1) {
                    array_push($course_admin, $course_admin_data->course_id);
                } else {
                    array_push($course_attender, $course_admin_data->course_id);
                }

            }

        }

        $course_admin = count($course_admin);
        $course_attender = count($course_attender);
        return view('admin.edit-admin', compact('admin', 'course_admin', 'course_attender'));
    }
    // The Editing Data Goes Here And The Process Happens Here
    public function update(Request $request)
    {
        $counter = 0;
        $admin =  User::find(Auth::user()->admin->user_id);
        if ( $admin->name != $request->name ){
            $request->validate([
                'name' => 'required|string|max:50|min:7',
            ]);
            $counter++;
        }

        if ( $admin->phone != $request->phone ){
            $request->validate([
                'phone' => 'required|string|max:20|min:10|starts_with:+',
            ]);
            $admin->phone = $request->phone;
            $counter++;
        }

        if ( $admin->email != $request->email ){
            $request->validate([
                'email' => 'required|string|max:50|min:7',
            ]);
            $admin->email = $request->email;
            $counter++;
        }

        if ( $admin->username != $request->username ){
            $request->validate([
                'username' => 'required|string|max:20|unique:users,username',
            ]);
            $admin->username = $request->username;
            $counter++;
        }

        // Checking If The Request Has An Image
        if ($request->hasFile('profile-image')) {
            if (File::exists('storage/admin-images/',  $admin->admin->image)) {
                if (Storage::delete('public/admin-images/' . $admin->admin->image)) {
                    $file = $request->file('profile-image')->store('public/admin-images');
                    $file_name = basename($file);
                    $admin->admin->image = $file_name;
                }
            }
            $counter++;
        }
        
        if ( $counter == 0 ){
            return redirect()->route('admin.edit')->withErrors(['min-error' => 'الرجاء قم بتحديث بعض الحقول لكي يتم حفظها', 'name' => ' ', 'email' => ' ', 'phone' => ' ', 'username' => ' ', 'profile-image' => ' ']);
        }
        $admin->save();
        $admin->admin->save();
        return redirect()->route('admin.edit')->with('success', 'تم تحديث البيانات الشخصية بنجاح');
    }
    //
    public function reset_password(){
        $admin = User::find(Auth::user()->admin->user_id);

        $course_admin = array();
        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

            if ( count($course_admin_data) > 0 ){

                if ($course_admin_data->role_id == 1) {
                    array_push($course_admin, $course_admin_data->course_id);
                } else {
                    array_push($course_attender, $course_admin_data->course_id);
                }

            }

        }

        $course_admin = count($course_admin);
        $course_attender = count($course_attender);
        return view('admin.reset-password', compact('admin', 'course_admin', 'course_attender'));
    }
    //
    public function reset_password_confirm(Request $request){
        $request->validate([
            'old_password' => 'required|string|max:32|min:8',
            'password' => 'required|string|max:32|min:8',
            'password_confirmation' => 'required|string|same:password',
        ]);

        $admin = User::find(Auth::user()->admin->user_id);

        if( !Hash::check($request->old_password, $admin->password) ){
            return redirect()->route('admin.reset.password')->withErrors(['old_password' => ['كلمة المرور القديمة غير صحيحة']]);
        }

        if( Hash::check($request->password, $admin->password) ){
            return redirect()->route('admin.reset.password')->withErrors(['password' =>  ['الرجاء اختيار كلمة مرور اخرى غير الحالية']]);
        }

        $admin-> password = Hash::make($request->password);
        $admin->save();
        return redirect()->route('admin.reset.password')->with('success', 'تم تغير كلمة النرور بنجاح');

    }
    // To Show The Form Of Editing Course
    public function edit_course($id){

        $admin_courses = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('role_id', 1)->get();
        $courses_id = array();
        foreach ($admin_courses as $course){
            array_push($courses_id, $course->course_id);
        }

        if( !in_array($id, $courses_id) ){
            abort(404);
        }

        $course = Course::find($id);

        $course_admin = array();
        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

            if ( count($course_admin_data) > 0 ){

                if ($course_admin_data->role_id == 1) {
                    array_push($course_admin, $course_admin_data->course_id);
                } else {
                    array_push($course_attender, $course_admin_data->course_id);
                }

            }

        }

        $course_admin = count($course_admin);
        $course_attender = count($course_attender);



        $categories = Category::all();
        $cities = City::all();
        $countries = Country::all();
        $trainers = Trainer::where('center_id', Auth::user()->admin->center->id)->get();
        return view('admin.edit-course', compact('course', 'categories', 'countries', 'cities', 'trainers', 'course_admin', 'course_attender'));
    }
    // The Data Of Editing Course Goes Here And The Process Happens Here
    public function edit_course_update($id){
        return "update course";
    }

    public function show_courses_attendance(){

        $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();


        $course_admin = array();
        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

            if ( count($course_admin_data) > 0 ){

                if ($course_admin_data->role_id == 1) {
                    array_push($course_admin, $course_admin_data->course_id);
                } else {
                    array_push($course_attender, $course_admin_data->course_id);
                }

            }

        }

        $course_admin = count($course_admin);
        $course_attender = count($course_attender);

        return view('admin.all-courses-attendance', compact('courseAdmin','course_admin', 'course_attender'));
    }
     public function course_attendance($identifier){

         $course = Course::where('identifier',$identifier)->first();
         if ( count($course) == 0 ){
             abort(404);
         }

         $identifiers = array();
         $admin_courses = Course::where('center_id', Auth::user()->admin->center->id)->get();
         foreach ($admin_courses as $admin_course){
             array_push($identifiers, $admin_course->identifier);
         }

         if ( !in_array($identifier, $identifiers) ){
             abort(404);
         }

         $course_admin = array();
         $course_attender = array();

         $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

         for ($i = 0; $i < count($courses_data); $i++) {

             $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

             if ( count($course_admin_data) > 0 ){

                 if ($course_admin_data->role_id == 1) {
                     array_push($course_admin, $course_admin_data->course_id);
                 } else {
                     array_push($course_attender, $course_admin_data->course_id);
                 }

             }

         }

         $course_admin = count($course_admin);
         $course_attender = count($course_attender);

        return view('admin.show-course-attendance', compact('course','course_admin', 'course_attender'));
     }

    public function destroy($id)
    {
        //
    }
}
