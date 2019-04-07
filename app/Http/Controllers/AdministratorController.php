<?php

namespace App\Http\Controllers;

use App\Admin;
use App\administrator;
use App\AdvertisingBanner;
use App\Center;
use App\ContactUs;
use App\Course;
use App\Student;
use App\Trainer;
use App\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdministratorController extends Controller
{
    // This Function Returns An Error Page With Title And Description
    private function error_page($title = 'خطأ', $message = '')
    {
        return view('administrator.error-page')->withErrors(['title' => $title, 'message' => $message]);
    }

    // This Function Returns The Number Of Total Centers
    private function get_total_centers()
    {
        return Center::all()->count();
    }

    // This Function Returns The Number Of Total Courses
    private function get_total_courses()
    {
        return Course::all()->count();
    }

    // This Function Returns The Number Of Total Students
    private function get_total_students()
    {
        return Student::all()->count();
    }

    // This Function Returns The Number Of Total Trainers
    private function get_total_trainers()
    {
        return Trainer::all()->count();
    }

    // This Function Checks If The User Role Is Administrator Or Not
    private function check_authenticated()
    {

        if (Auth::check() && Auth::user()->role_id == 1) {
            return true;
        } else {
            return false;
        }

    }

    // This Function Returns The Index Page Of The Administrator
    public function index()
    {

        $banners = AdvertisingBanner::all();
        $public_courses = Course::where('visible', 1)->take(6)->get();
        $private_courses = Course::where('visible', 2)->take(6)->get();
        $contact_us = ContactUs::all()->take(6);

        // ->sortByDesc('id')

        $all_centers = $this->get_total_centers();
        $all_courses = $this->get_total_courses();
        $all_students = $this->get_total_students();
        $all_trainers = $this->get_total_trainers();

        return view('administrator.index', compact('banners', 'public_courses', 'private_courses', 'contact_us', 'all_centers', 'all_courses', 'all_students', 'all_trainers'));
    }

    // --
    public function create()
    {
        //
    }

    // This Function Returns The Registration Page For Administrator
    public function register()
    {

        if (Auth::guest()) {
            return view('administrator.register');
        }

    }

    // This Function Handle The Process Of Registering New Administrator
    public function store(Request $request)
    {
        if (Auth::guest()) {

            $request->validate([
                'phone' => 'required|string|starts_with:5|max:9|min:9',
                'name' => 'required|string|max:50|min:7',
                'email' => 'required|email|max:50|unique:users,email',
                'username' => 'required|string|max:50|min:5|unique:users,username',
                'password' => 'required|string|max:32|min:6|confirmed',
            ]);

            try {

                DB::beginTransaction();

                $user = User::create([
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'username' => $request->username,
                    'role_id' => 1,
                    'status' => 1,
                    'password' => Hash::make($request->password),
                ]);

                administrator::create([
                    'user_id' => $user->id,
                    'name' => $request->name,
                    'image' => "default.jpg",
                ]);

                DB::commit();

                Auth::login($user);

                return redirect()->route('administrator.index', Auth::user()->username);

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('administrator.register')->withErrors(['هناك خطأ تقني الرجاء التواصل مع إدارة الموقع'])->withInput();
            }

        } else {
            return $this->error_page();
        }
    }

    // --
    public function show($id)
    {
        //
    }

    // --
    public function edit($id)
    {
        //
    }

    // --
    public function update(Request $request, $id)
    {
        //
    }

    // --
    public function destroy($id)
    {
        //
    }

    // This Function Handle The Process Of Confirming A Course
    public function confirm_courses(Request $request)
    {

        if ($this->check_authenticated()) {

            $request->validate([
                'courses' => 'required|array|size:' . $this->get_total_courses(),
                'courses.*' => 'required|string|distinct|exists:courses,identifier',
                'validations' => 'required|array|size:' . $this->get_total_courses(),
                'validations.*' => 'required|integer|max:1|min:0',
            ]);

            $counter = 0;
            for ($i = 0; $i < $this->get_total_courses(); $i++) {
                $course = Course::where('identifier', $request->courses[$i])->first();
                if (count($course) < 1) {

                } else {
                    if ($course->validation != $request->validations[$i]) {
                        $course->validation = $request->validations[$i];
                        $counter++;
                        $course->save();
                    }
                }
            }

            if ($counter == 0) {
                if ( $request->type == "public" ){
                    return redirect()->route('administrator.courses.public.show')->withErrors(['قم بتحديث حالة بعض الدورات لكي يتم حفظها']);
                }elseif( $request->type == "private" ){
                    return redirect()->route('administrator.courses.private.show')->withErrors(['قم بتحديث حالة بعض الدورات لكي يتم حفظها']);
                }else{
                    return redirect()->route('administrator.index', Auth::user()->username)->withErrors(['قم بتحديث حالة بعض الدورات لكي يتم حفظها']);
                }
            } else {
                if ( $request->type == "public" ){
                    return redirect()->route('administrator.courses.public.show')->with('success', 'تم تحديث البيانات بنجاح');
                }elseif( $request->type == "private" ){
                    return redirect()->route('administrator.courses.private.show')->with('success', 'تم تحديث البيانات بنجاح');
                }else{
                    return redirect()->route('administrator.index', Auth::user()->username)->with('success', 'تم تحديث البيانات بنجاح');
                }
            }

        } else {
            return $this->error_page();
        }

    }

    // This Function Returns The View With All Advertising Banners
    public function show_banners()
    {

        if ($this->check_authenticated()) {

            $banners = AdvertisingBanner::all();
            $all_centers = $this->get_total_centers();
            $all_courses = $this->get_total_courses();
            $all_students = $this->get_total_students();
            $all_trainers = $this->get_total_trainers();

            return view('administrator.show-advertising-banners', compact('banners', 'all_centers', 'all_courses', 'all_students', 'all_trainers'));

        } else {
            return $this->error_page();
        }

    }

    // This Function Returns The View Of Creating Advertising Banners
    public function create_banner()
    {
        if ($this->check_authenticated()) {
            $all_centers = $this->get_total_centers();
            $all_courses = $this->get_total_courses();
            $all_students = $this->get_total_students();
            $all_trainers = $this->get_total_trainers();
            return view('administrator.create-advertising-banner', compact('all_centers', 'all_courses', 'all_students', 'all_trainers'));
        } else {
            return $this->error_page();
        }
    }

    // This Function Handle The Process Of Creating Advertising Banner
    public function store_banner(Request $request)
    {

        if ($this->check_authenticated()) {

            $request->validate([
                'title' => 'required|string|max:30|min:10',
                'link' => 'required|string|max:100|min:10|starts_with:http',
                'description' => 'required|max:30|min:10',
                'banner-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                'status' => 'required|integer|max:1|min:0',
            ]);

            if ($request->hasFile('banner-image')) {
                $file = $request->file('banner-image')->store('public/banner-images');
                $file_name = basename($file);
            }

            AdvertisingBanner::create([
                'banner' => $file_name,
                'title' => $request->title,
                'link' => $request->link,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            return redirect()->route('administrator.advertising.banners.show')->with('success', 'تم حفظ البيانات بنجاح');

        } else {

            return $this->error_page();

        }

    }

    // This Function Returns The View With The Information Of Banner That Will Be Edited
    public function edit_banner($id)
    {

        if ($this->check_authenticated()) {

            $banner = AdvertisingBanner::where('id', $id)->first();

            if (count($banner) < 1) {

                return $this->error_page('خطأ', 'الرجاء التاأكد من معرف البانر');

            } else {
                $all_centers = $this->get_total_centers();
                $all_courses = $this->get_total_courses();
                $all_students = $this->get_total_students();
                $all_trainers = $this->get_total_trainers();

                return view('administrator.edit-advertising-banner', compact('banner', 'all_centers', 'all_courses', 'all_students', 'all_trainers'));
            }

        } else {
            return $this->error_page();
        }

    }

    // This Function Handle The Process Of Updaating The Advertising Banner Information
    public function update_banner(Request $request, $id)
    {

        if ($this->check_authenticated()) {

            $banner = AdvertisingBanner::where('id', $id)->first();

            if (count($banner) < 1) {

                return $this->error_page();

            } else {

                $counter = 0;

                if ($banner->title != $request->title) {
                    $request->validate([
                        'title' => 'required|string|max:20|min:10|',
                    ]);
                    $banner->title = $request->title;
                    $counter++;
                }

                if ($banner->link != $request->link) {
                    $request->validate([
                        'link' => 'required|string|starts_with:https://,http://|max:50|min:20',
                    ]);
                    $banner->link = $request->link;
                    $counter++;
                }

                if ($banner->description != $request->description) {
                    $request->validate([
                        'description' => 'required|string|max:30|min:10',
                    ]);
                    $banner->description = $request->description;
                    $counter++;
                }

                if ($banner->status != $request->status) {
                    $request->validate([
                        'status' => 'required|integer|max:1|min:0',
                    ]);
                    $banner->status = $request->status;
                    $counter++;
                }


                if ($request->hasFile('banner-image')) {

                    $request->validate([
                        'banner-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                    ]);

                    if (File::exists('storage/banner-images/', $banner->banner)) {
                        if (Storage::delete('public/banner-images/' . $banner->banner)) {
                            $file = $request->file('banner-image')->store('public/banner-images');
                            $file_name = basename($file);
                            $banner->banner = $file_name;
                            $counter++;

                        } else {
                            $file = $request->file('banner-image')->store('public/banner-images');
                            $file_name = basename($file);
                            $banner->banner = $file_name;
                            $counter++;
                        }
                    } else {
                        $file = $request->file('banner-image')->store('public/banner-images');
                        $file_name = basename($file);
                        $banner->banner = $file_name;
                        $counter++;
                    }
                }

                if ($counter == 0) {
                    return redirect()->route('administrator.advertising.banner.edit', $id)->withErrors(['قم بتحديث بعض الحقول لكي يتم حفظها']);
                } else {
                    $banner->save();
                }

                return redirect()->route('administrator.advertising.banners.show')->with('success', 'تم حفظ البيانات بنجلح');
            }

        } else {
            return $this->error_page();
        }

    }

    // This Function Handle The Process Of Deleting Advertising Banner
    public function delete_banner($id)
    {

        if ($this->check_authenticated()) {

            $banner = AdvertisingBanner::where('id', $id)->first();
            if (count($banner) < 1) {
                return $this->error_page('خطأ', 'الرجاا التأكد من معرف الإعلان');
            } else {
                $banner->delete();

                return redirect()->route('administrator.advertising.banners.show')->with('success', 'تم حذف الاعلان بنجاح');
            }

        } else {
            return $this->error_page();
        }

    }

    // This Function Returns The View Of Previewing A Course Before Confirm It By Administrator
    public function course_preview($identifier)
    {

        if ($this->check_authenticated()) {

            $course = Course::where('identifier', $identifier)->first();

            if (count($course) < 1) {
                return $this->error_page('خطأ', 'الرجاء التأكد من معرف الدورة');
            } else {
                return view('administrator.course-preview', compact('course'));
            }

        } else {
            return $this->error_page();
        }

    }

    // This Function Show All Contact Us Messages By Users And Visitors
    public function show_contact_us(){
        $contact_us = ContactUs::all();

        $all_centers = $this->get_total_centers();
        $all_courses = $this->get_total_courses();
        $all_students = $this->get_total_students();
        $all_trainers = $this->get_total_trainers();
        return view('administrator.show-contact-us', compact('contact_us', 'all_centers', 'all_courses', 'all_students', 'all_trainers'));
    }

    // This Function Returns All Students Registered In The Website
    public function show_students(){
        if ( $this->check_authenticated() ){

            $students = Student::paginate(10);
            $all_centers = $this->get_total_centers();
            $all_courses = $this->get_total_courses();
            $all_students = $this->get_total_students();
            $all_trainers = $this->get_total_trainers();

            return view('administrator.show-students', compact('students', 'all_centers', 'all_courses', 'all_students', 'all_trainers'));

        }else{
            return $this->error_page();
        }
    }

    // This Function Returns A View With Public Courses To Be Confirmed
    public function show_public_courses(){
        if ( $this->check_authenticated() ){

            $public_courses = Course::where('visible', 1)->get();
            $all_centers = $this->get_total_centers();
            $all_courses = $this->get_total_courses();
            $all_students = $this->get_total_students();
            $all_trainers = $this->get_total_trainers();

            return view('administrator.confirm-public-courses', compact('public_courses', 'all_centers', 'all_courses', 'all_students', 'all_trainers'));

        }else{
            return $this->error_page();
        }
    }

    // This Function Returns A View With Private Courses To Be Confirmed
    public function show_private_courses(){
        if ( $this->check_authenticated() ){

            $private_courses = Course::where('visible', 2)->get();
            $all_centers = $this->get_total_centers();
            $all_courses = $this->get_total_courses();
            $all_students = $this->get_total_students();
            $all_trainers = $this->get_total_trainers();

            return view('administrator.confirm-private-courses', compact('private_courses', 'all_centers', 'all_courses', 'all_students', 'all_trainers'));

        }else{
            return $this->error_page();
        }
    }

    // This Function Returns All Students To Activate Or Deactivate Them
    public function show_students_for_activation(){
        if ( $this->check_authenticated() ){

            $students = Student::all();
            $all_centers = $this->get_total_centers();
            $all_courses = $this->get_total_courses();
            $all_students = $this->get_total_students();
            $all_trainers = $this->get_total_trainers();

            return view('administrator.activate-students', compact('students', 'all_centers', 'all_courses', 'all_students', 'all_trainers'));

        }else{
            return $this->error_page();
        }
    }

    // This Function Handle The Activation And Deactivation Of Students
    public function confirm_activation_deactivation_students(Request $request){
        if ( $this->check_authenticated() ){
            $students = $this->get_total_students();

            $request->validate([
                'students' => 'required|array|size:'.$students,
                'students.*' => 'required|integer|distinct|exists:students,id',
                'activations' => 'required|array|size:'.$students,
                'activations.*' => 'required|integer|max:1|min:0',
            ]);

            $counter = 0;

            for ($i = 0; $i < $this->get_total_students(); $i ++){
                $student = Student::where('id', $request->students[$i])->first();

                if ( count($student) > 0 ){
                    if ( $student->user->status != $request->activations[$i] ){
                        $student->user->status = $request->activations[$i];
                        $student->user->save();
                        $counter++;
                    }
                }
            }

            if ( $counter == 0 ){
                return redirect()->route('administrator.students.activation.deactivation')->withErrors(['قم بتحدث بعض الحقول لكي يتم حفظها']);
            }else{
                return redirect()->route('administrator.students.activation.deactivation')->with('success', 'تم حفظ البيانات بنجاح');
            }

        }else{
            return $this->error_page();
        }
    }

    // This Function Returns View With All Trainers
    public function show_trainers(){
        if ( $this->check_authenticated() ){
            $trainers = Trainer::all();

            $all_centers = $this->get_total_centers();
            $all_courses = $this->get_total_courses();
            $all_students = $this->get_total_students();
            $all_trainers = $this->get_total_trainers();

            return view('administrator.show-trainers', compact('trainers', 'all_centers', 'all_courses', 'all_students', 'all_trainers'));

        }else{
            return $this->error_page();
        }
    }

    // This Function Returns View With All Centers
    public function show_centers(){

        if ( $this->check_authenticated() ){
            $centers = Center::all();

            $all_centers = $this->get_total_centers();
            $all_courses = $this->get_total_courses();
            $all_students = $this->get_total_students();
            $all_trainers = $this->get_total_trainers();

            return view('administrator.show-centers', compact('centers', 'all_centers', 'all_courses', 'all_students', 'all_trainers'));

        }else{
            return $this->error_page();
        }

    }

    // This Function Returns View With All Centers To Activate Or Deactivate Them
    public function show_centers_for_activation(){
        if ( $this->check_authenticated() ){

            $centers = Center::all();
            $all_centers = $this->get_total_centers();
            $all_courses = $this->get_total_courses();
            $all_students = $this->get_total_students();
            $all_trainers = $this->get_total_trainers();

            return view('administrator.activate-centers', compact('centers', 'all_centers', 'all_courses', 'all_students', 'all_trainers'));

        }else{
            return $this->error_page();
        }
    }

    // This Function Handle The Process Of Activation And Deactivation Of Centers
    public function confirm_activation_deactivation_centers(Request $request){

        $centers = $this->get_total_centers();
        $request->validate([
            'centers' => 'required|array|size:'.$centers,
            'centers.*' => 'required|integer|distinct|exists:students,id',
            'activations' => 'required|array|size:'.$centers,
            'activations.*' => 'required|integer|max:1|min:0',
        ]);

        $counter = 0;

        for ($i = 0; $i < $centers; $i++){
            $center = Center::where('id', $request->centers[$i])->first();

            if ( count($center) > 0 ){
                if ( $center->user->status != $request->activations[$i] ){
                    $center->user->status = $request->activations[$i];
                    $center->user->save();
                    $counter++;
                }
            }

        }

        if ( $counter == 0 ){
            return redirect()->route('administrator.centers.activation.deactivation')->withErrors(['قم بتحديث بعض البيانات لمي يتم حفظها']);
        }else{
            return redirect()->route('administrator.centers.activation.deactivation')->with('success', 'تم حفظ البيانات بنجاح');
        }

    }

    // This Function Returns View With All Admins
    public function show_admins(){

        if ( $this->check_authenticated() ){
            $admins = Admin::paginate(20);

            $all_centers = $this->get_total_centers();
            $all_courses = $this->get_total_courses();
            $all_students = $this->get_total_students();
            $all_trainers = $this->get_total_trainers();

            return view('administrator.show-admins', compact('admins', 'all_centers', 'all_courses', 'all_students', 'all_trainers'));

        }else{
            return $this->error_page();
        }

    }

}
