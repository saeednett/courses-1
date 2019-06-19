<?php

namespace App\Http\Controllers;

use App\AdvertisingBanner;
use App\Center;
use App\Certificate;
use App\Student;
use App\User;
use App\City;
use App\Country;
use App\Coupon;
use App\Course;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\Rule;

class StudentAPIController extends Controller
{
    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $response = array(
        'status' => '',
        'errors' => array(),
        'response' => array(),
    );
    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $data = array();

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'index', 'centers']]);
    }

    // This Function Retrieve All Courses Are Available In The Database
    public function index()
    {

        $courses = Course::all();

        if ($courses->count() == 0) {

            $this->response['status'] = "Failed";
            array_push($this->response['errors'], "لاتوجد دورات مسجلة في النظام");
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {


            $this->data['banners'] = array();
            $banners = AdvertisingBanner::where('status', 1)->get();

            if ( $banners->count() > 0 )
            {
                foreach ($banners as $banner) {
                    $subData = array(
                        'banner' => $banner->banner,
                        'title' => $banner->title,
                        'link' => $banner->link,
                        'description' => $banner->description,
                    );

                    array_push($this->data['banners'], $subData);
                }
            }else {
                array_push($this->data['banners'], null);
            }


            $this->data['courses'] = array();

            foreach ($courses as $course) {

                if ($course->type == "free") {
                    $price = 0;
                } else {
                    $price = $course->price;
                }

                $subData = array(
                    'title' => $course->title,
                    'identifier' => $course->identifier,
                    'address' => $course->address,
                    'location' => $course->location,
                    'price' => $price,
                    'type' => $course->type,
                    'start_date' => $course->start_date,
                    'end_date' => $course->end_date,
                    'start_time' => $course->start_time,
                    'hours' => $course->hours,
                    'end_reservation' => $course->end_reservation,
                    'gender' => $course->gender,
                    'category_id' => $course->category_id,
                    'category' => $course->category->name,
                    'center_id' => $course->center_id,
                    'center' => $course->center->name,
                    'city' => $course->city->name,
                    'city_id' => $course->city_id,
                    'description' => $course->description,
                    'total_trainers' => count($course->trainer),
                    'poster-1' => "/storage/course-images/" . $course->image->image,
                    'poster-2' => "/storage/course-images/" . $course->image->image_2,
                );

                $subData['trainers'] = array();

                foreach ($course->trainer as $trainer) {
                    $trainersData = array(
                        'trainer-name' => $trainer->trainer->name,
                        'trainer-title' => $trainer->trainer->title->name,
                        'trainer-image' => "/storage/trainer-images/" . $trainer->trainer->image,
                    );

                    array_push($subData['trainers'], $trainersData);
                }

                array_push($this->data['courses'], $subData);
            }

            $this->response['status'] = "Success";
            array_push($this->response['errors'], null);
            array_push($this->response['response'], $this->data);

            return response()->json($this->response);
        }

    }

    // This Function Retrieve All The Tickets Of The User | Student
    public function tickets()
    {

        $this->data['confirmed'] = array();
        $this->data['unconfirmed'] = array();
        $this->data['finished'] = array();


        $tickets_count = Reservation::where('student_id', auth('api')->user()->student->id)->count();

        if ($tickets_count < 1) {
            $this->response['status'] = "Failed";
            array_push($this->response['errors'], 'لاتوجد تذاكر محجوزة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {

            // Getting The Confirmed Ticket For The Student
            $confirmed_tickets = Reservation::where('student_id', auth('api')->user()->student->id)->where('confirmation', 1)->get();

            if (count($confirmed_tickets) > 0) {
                foreach ($confirmed_tickets as $ticket) {

                    if ($ticket->course->start_date >= date('Y-m-d')) {
                        $subData = array(
                            'title' => $ticket->course->title,
                            'identifier' => $ticket->identifier,
                            'course_start_date' => $ticket->course->start_date,
                            'course_end_date' => $ticket->course->end_date,
                            'total_hours' => $ticket->course->hours,
                            'poster-1' => $ticket->course->image->image,
                            'poster-2' => $ticket->course->image->image_2,
                        );

                        array_push($this->data['confirmed'], $subData);
                    }

                }
            }


            // Getting The Unconfirmed Ticket For The Student
            $unconfirmed_tickets = Reservation::where('student_id', auth('api')->user()->student->id)->where('confirmation', 0)->get();

            foreach ($unconfirmed_tickets as $ticket) {

                if ($ticket->course->start_date >= date('Y-m-d')) {
                    $subData = array(
                        'title' => $ticket->course->title,
                        'identifier' => $ticket->identifier,
                        'course_start_date' => $ticket->course->start_date,
                        'course_end_date' => $ticket->course->end_date,
                        'total_hours' => $ticket->course->hours,
                        'poster-1' => $ticket->course->image->image,
                        'poster-2' => $ticket->course->image->image_2,
                    );
                    array_push($this->data['unconfirmed'], $subData);
                }

            }

            // Getting The Finished Ticket For The Student
            $finished_tickets = Reservation::where('student_id', auth('api')->user()->student->id)->get();

            foreach ($finished_tickets as $ticket) {

                if ($ticket->course->start_date < date('Y-m-d')) {
                    $subData = array(
                        'title' => $ticket->course->title,
                        'identifier' => $ticket->identifier,
                        'course_start_date' => $ticket->course->start_date,
                        'course_end_date' => $ticket->course->end_date,
                        'total_hours' => $ticket->course->hours,
                        'poster-1' => $ticket->course->image->image,
                        'poster-2' => $ticket->course->image->image_2,
                    );
                    array_push($this->data['finished'], $subData);
                }

            }

            $this->response['status'] = "Success";
            array_push($this->response['errors'], null);
            array_push($this->response['response'], $this->data);

            return response()->json($this->response);
        }
    }

    // This Function Show All The Certificate That That The User | Student Got
    public function certificates()
    {
        $certificates = Certificate::where('student_id', auth('api')->user()->student->id)->get();

        if ( count($certificates) < 1 ){
            $this->response['status'] = "Failed";
            array_push($this->response['errors'], 'لم يتم إصداراي شهادة لهذا المستخدم');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }else {

            foreach ($certificates as $certificate){
                $subData = array(
                    'center' => $certificate->course->center->name,
                    'course' => $certificate->course->name,
                    'issue_date' => $certificate->date,
                    'student_name' => $certificate->student->first_name.$certificate->student->second_name.$certificate->student->third_name,
                    'student_id' => $certificate->student->id,
                    'certificate_url' => 'https://www.google.com',
                );
                array_push($this->response['response'], $subData);
            }

            array_push($this->response['status'], 'Success');
            array_push($this->response['error'], null);

            return response()->json($this->response);
        }

    }

    // This Function Show More Details About The Selected Course
    public function show_course($center_username, $course_identifier)
    {

        $center = User::where('username', $center_username)->where('role_id', 2)->first();

        if (empty($center)) {
            $this->response['status'] = "Failed";
            array_push($this->response['errors'], "الرجاء التأكد من معرف الجهة");
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {

            $course = Course::where('identifier', $course_identifier)->where('center_id', $center->center->id)->first();
            if (empty($course)) {
                $this->response['status'] = "Failed";
                array_push($this->response['errors'], "الرجاء التأكد من معرف الدورة");
                array_push($this->response['response'], null);

                return response()->json($this->response);
            } else {

                if ($course->type == "free") {
                    $price = 0;
                } else {
                    $price = $course->price;
                }

                $this->data['course'] = array();
                $this->data['trainers'] = array();

                $subData = array(
                    'title' => $course->title,
                    'identifier' => $course->identifier,
                    'address' => $course->address,
                    'location' => $course->location,
                    'price' => $price,
                    'type' => $course->type,
                    'start_date' => $course->start_date,
                    'end_date' => $course->end_date,
                    'start_time' => $course->start_time,
                    'hours' => $course->hours,
                    'end_reservation' => $course->end_reservation,
                    'gender' => $course->gender,
                    'category_id' => $course->category->name,
                    'category' => $course->category_id,
                    'center_id' => $course->center_id,
                    'center' => $course->center->name,
                    'city' => $course->city->name,
                    'city_id' => $course->city_id,
                    'description' => $course->description,
                    'total_trainers' => count($course->trainer),
                    'poster-1' => $course->image->image,
                    'poster-2' => $course->image->image_2,
                );

                array_push($this->data['course'], $subData);

                foreach ($course->trainer as $trainer){
                    $trainersSubData = array(
                        'id' => $trainer->trainer->id,
                        'name' => $trainer->trainer->name,
                        'title' => $trainer->trainer->title->name,
                        'image' => $trainer->trainer->image,
                    );

                    array_push($this->data['trainers'], $trainersSubData);
                }

                $this->response['status'] = "Success";
                array_push($this->response['errors'], null);
                array_push($this->response['response'], $this->data);

                return response()->json($this->response);
            }
        }
    }

    // This Function Retrieve The User Personal Data To Be Edited
    public function edit()
    {

        $user = User::find(auth('api')->user()->student->user_id);

        $this->data['user'] = array(
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'first_name' => $user->student->first_name,
            'second_name' => $user->student->second_name,
            'third_name' => $user->student->third_name,
            'last_name' => $user->student->last_name,
            'year' => $user->student->year,
            'month' => $user->student->month,
            'day' => $user->student->day,
            'profile-image' => "/storage/account-images/" . $user->student->image,
            'city_id' => $user->student->city_id,
            'city' => $user->student->city->name,
            'country_id' => $user->student->city->country->id,
            'country' => $user->student->city->country->name,
        );
        
        array_push($this->response['response'], $this->data);

        $this->data['countries'] = array();
        $countries = Country::all();
        
        for ($i = 0; $i < count($countries); $i++) {
            $subData = array(
                'id' => $countries[$i]->id,
                'name' => $countries[$i]->name,
            );
            array_push($this->data['countries'], $subData);
        }

        $this->response['status'] = "Success";
        array_push($this->response['errors'], null);

        return response()->json($this->response);

    }

    // This Function Edit The Data Of The User | Student
    public function update(Request $request)
    {

        $counter = 0;
        $user = User::find(auth('api')->user()->student->user_id);

        if ($user->username != $request->username) {
            $counter++;
        }

        if ($user->email != $request->email) {
            $request->validate([
                'email' => 'email|unique:users,email' . Rule::unique('users')->ignore(auth('api')->user()->student->user_id),
            ]);
            $counter++;
        }

        if ($user->phone != $request->phone) {
            $request->validate([
                'phone' => 'email|unique:users,email|starts_with:5' . Rule::unique('users')->ignore(auth('api')->user()->student->user_id),
            ]);
            $counter++;
        }

        if ($user->student->first_name != $request->first_name) {
            $request->validate([
                'first_name' => 'string|max:10|min:3',
            ]);
            $counter++;
        }

        if ($user->student->second_name != $request->second_name) {
            $request->validate([
                'second_name' => 'string|max:10|min:3',
            ]);
            $counter++;
        }

        if ($user->student->third_name != $request->third_name) {
            $request->validate([
                'third_name' => 'string|max:10|min:3',
            ]);
            $counter++;
        }

        if ($user->student->last_name != $request->last_name) {
            $request->validate([
                'last_name' => 'string|max:10|min:3',
            ]);
            $counter++;
        }

        if ($user->student->year != $request->year) {
            $request->validate([
                'year' => 'integer|max:4|min:4',
            ]);
            $counter++;
        }

        if ($user->student->month != $request->month) {
            $request->validate([
                'month' => 'integer|max:2|min:2',
            ]);
            $counter++;
        }

        if ($request->hasFile('profile-image')) {
            if (file_exists('storage/account-images/', $user->student->image)) {
                if (Storage::delete('public/account-images/' . $user->student->image)) {
                    $file = $request->file('profile-image')->store('public/account-images');
                    $file_name = basename($file);
                    $user->student->image = $file_name;
                }
            }
            $counter++;
        }

        if ($user->student->day != $request->day) {
            $request->validate([
                'day' => 'integer|max:2|min:2',
            ]);
            $counter++;
        }

        if ($user->student->city->country->id != $request->country_id) {
            $request->validate([
                'country_id' => 'integer|exists:countries,id',
            ]);
            $counter++;
        }

        $cities_data = City::where('country_id', $request->country_id);
        $cities = array();
        foreach ($cities_data as $data) {
            array_push($cities, $data->id);
        }

        if ($user->student->city_id != $request->city_id) {
            $request->validate([
                'city_id' => 'integer|' . Rule::in($cities),
            ]);
            $counter++;
        }

        if ($counter > 0) {
            $user->save();
            $user->student->save();

            $this->response['status'] = "Success";
            array_push($this->response['errors'], null);
            array_push($this->response['response'], "تم تعديل البيانات بنجاح");

            return response()->json($this->response);

        }else {
            $this->response['status'] = "Failed";
            array_push($this->response['errors'], "قم بتعديل بعض البيانات لكي يتم حفظها");
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }
    }

    // This Function Register A New User | Student
    public function register(Request $request)
    {
        // An Empty Array That Will Hold The Id Of The Cities
        $cities = array();
        // Getting The Id Of The Cities
        $cities_data = City::where('country_id', $request->country)->get();
        // Fetching The Id Into The Array
        foreach ($cities_data as $city) {
            array_push($cities, $city->id);
        }
        // Validating The Request Data
        $request->validate([
            'first_name' => 'required|string|max:20|min:3',
            'second_name' => 'required|string|max:20|min:3',
            'email' => 'required|email|max:100|unique:users,email',
            'username' => 'required|string|max:20|min:5|unique:users,username',
            'phone' => 'required|max:9|min:9|unique:users,phone|starts_with:5',
            'gender' => 'required|exists:genders,id',
            'country' => 'required|integer|exists:countries,id',
            'city' => 'required|integer|' . Rule::in($cities),
            'password' => 'required|string|max:32|min:6|confirmed'
        ]);

        DB::beginTransaction();
        try {

            // Creating The User
            $student = User::create([
                'email' => $request->email,
                'username' => $request->username,
                'phone' => "+966" . $request->phone,
                'role_id' => 5,
                'password' => Hash::make($request->password),
            ]);

            //Creating The Student
            Student::create([
                'user_id' => $student->id,
                'first_name' => $request->first_name,
                'second_name' => $request->second_name,
                'gender_id' => $request->gender,
                'city_id' => $request->city,
                'year' => 0,
                'month' => 0,
                'day' => 0,
                'status' => 1
            ]);


            $token = JWTAuth::fromUser($student);
            DB::commit();

            $this->data = array(
                'token' => $token,
            );

            $this->response['status'] = "Success";
            array_push($this->response['errors'], null);
            array_push($this->response['response'], $this->data);
            return response()->json($this->response);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->response['status'] = "Failed";
            array_push($this->response['errors'], "هناك خطأ تقني أثناء التسجيل");
            array_push($this->response['response'], null);
            return response()->json($this->response);
        }

    }

    // This Function For Reserving A Course By The User | Student
    public function reserve_course(Request $request)
    {

        $request->validate([
            'identifier' => 'string|max:10|min:10|exists:courses,identifier',
            'coupon' => 'nullable|string|max:20|min:3'
        ]);


        $course = Course::where('identifier', $request->identifier)->first();

        if (empty($course)) {
            $this->response['status'] = "Failed";
            array_push($this->response['errors'], 'الرجاء التأكد من معرف الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {

            $reservation = Reservation::where('course_id', $course->id)->where('student_id', auth('api')->user()->student->id)->first();
            if (!empty($reservation)) {
                $this->response['status'] = "Failed";
                array_push($this->response['errors'], 'تم حجز الدورة مسبقا قم بإلغاء الحجز لكي تتمكن من حجزها مجددا');
                array_push($this->response['response'], null);

                return response()->json($this->response);
            } else {

                if (!is_null($request->coupon)) {
                    $coupon_data = Coupon::where('code', $request->coupon)->where('course_id', $course->id)->first();
                    if (!empty($coupon_data)) {
                        $coupon = $coupon_data->id;
                    } else {
                        $coupon = 0;
                    }
                }else{
                    $coupon = 0;
                }

                try {

                    Reservation::create([
                        'student_id' => auth('api')->user()->student->id,
                        'course_id' => $course->id,
                        'coupon_id' => $coupon,
                        'identifier' => Str::random(10),
                        'confirmation' => 0,

                    ]);

                    array_push($this->response['status'], 'Success');
                    array_push($this->response['errors'], null);

                    if ($course->type == 'free') {
                        array_push($this->response['response'], 'تم حجز الدور بنجاح بإنتظار التأكيد من المركز');
                    } else {
                        array_push($this->response['response'], 'تم حجز الدور بنجاح قم بدفع قيمة الدورة لكي يتم إصدار الشهادة');
                    }

                    return response()->json($this->response);

                } catch (\Exception $e) {
                    array_push($this->response['status'], 'Error');
                    array_push($this->response['errors'], 'خطأ تقني أثناء حجز الدورة');
                    array_push($this->response['errors'], $e->getMessage());
                    array_push($this->response['response'], null);

                    return response()->json($this->response);
                }

            }
        }
    }

    // This Function Show More Details About The Center
    public function show_center($center_username)
    {

        $user = User::where('username', $center_username)->where('role_id', 2)->first();
        if (empty($user)) {
            $this->response['status'] = "Failed";
            array_push($this->response['errors'], 'الرجاء التأكد من معرف الجهة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {

            if ($user->center->type == 1){
                $type = 'profit';
            }else{
                $type = 'nonprofit';
            }


            $this->data['center'] = array(
                'name' => $user->center->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'website' => $user->center->website,
                'city' => $user->center->city->name,
                'about' => $user->center->about,
                'verification_number' => $user->center->verification_code,
                'verification_authority' => $user->center->verification_authority,
                'type' => $type,
                'courses' => $user->center->course->count(),
                'trainers' => $user->center->trainer->count(),
            );

            $this->data['socialMedia'] = array();

            for ($i = 0; $i < 4; $i++) {
                $social_media = ['Twitter', 'Facebook', 'Snapchat', 'Instagram'];

                $subData = array(
                    'name' => $social_media[$i],
                    'account' => $social_media[$i] . ' Account',
                );
                array_push($this->data['socialMedia'], $subData);
            }

            $this->data['courses'] = array();

            foreach ($user->center->course->take(5) as $course) {

                if ($course->type == "free") {
                    $price = 0;
                } else {
                    $price = $course->price;
                }

                $subData = array(
                    'title' => $course->title,
                    'identifier' => $course->identifier,
                    'price' => $price,
                    'type' => $course->type,
                    'start_date' => $course->start_date,
                    'end_date' => $course->end_date,
                    'category' => $course->category->name,
                    'center' => $course->center->name,
                    'city' => $course->city->name,
                    'poster-1' => $course->image->image,
                    'poster-2' => $course->image->image_2,
                );

                array_push($this->data['courses'], $subData);
            }

            $this->response['status'] = "Success";
            array_push($this->response['errors'], null);
            array_push($this->response['response'], $this->data);

            return response()->json($this->response);
        }


    }

    // This Function For Resetting User | Student Password
    public function reset_password(Request $request)
    {

        $request->validate([
            'old_password' => 'string|max:32|min:6',
            'new_password' => 'string|max:32|min:6',
            'new_password_confirmation' => 'string|max:32|min:6|same:new_password',

        ]);

        $user = User::find(auth('api')->user()->student->user_id);

        if (!Hash::check($request->old_password, $user->password)) {
            $this->response['status'] = "Failed";
            array_push($this->response['errors'], 'كلمة المرور القديمة غير صحيحة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {
            if (Hash::check($request->new_password, $user->password)) {
                $this->response['status'] = "Failed";
                array_push($this->response['errors'], 'كلمة المرور الجديدة يجب أن تكون مختلفة عن القديمة');
                array_push($this->response['response'], null);

                return response()->json($this->response);
            } else {
                $user->password = Hash::make($request->new_password);
                $user->save();

                array_push($this->response['status'], 'Success');
                array_push($this->response['errors'], 'تم تغير كلمة المرور بنجاح');
                array_push($this->response['response'], null);

                return response()->json($this->response);
            }
        }

    }

    // This Function For Canceling A Course Reservation
    public function cancel_course_reservation(Request $request)
    {

        $request->validate([
            'identifier' => 'required|string|exists:reservations,identifier',
        ]);

        $reservation = Reservation::where('identifier', $request->identifier)->first();

        if (empty($reservation)) {
            $this->response['status'] = "Failed";
            array_push($this->response['errors'], 'الرجاء التأكد من معرف الحجز');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }else {

            if ($reservation->confirmation == 1) {
                $this->response['status'] = "Failed";
                array_push($this->response['errors'], 'تم تأكيد حجزك الرجاء التواصل مع الاإدارة');
                array_push($this->response['response'], null);

                return response()->json($this->response);
            } else {

                try {

                    $reservation->delete();

                    array_push($this->response['status'], 'Success');
                    array_push($this->response['errors'], null);
                    array_push($this->response['response'], 'تم إلغاء حجزك بنجاح');

                    return response()->json($this->response);

                } catch (\Exception $e) {
                    array_push($this->response['status'], 'Error');
                    array_push($this->response['errors'], 'خطأ تقني أثناء حذف الحجز');
                    array_push($this->response['response'], null);

                    return response()->json($this->response);
                }

            }

        }
    }

    // This Function For Login Going To Be Used With All Request Of Login
    public function login()
    {

        $credentials = request(['username', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            $this->response['status'] = "Failed";
            array_push($this->response['errors'], 'الرجاء التأكد من اسم المستخدم | كلمة المرور');
            array_push($this->response['response'], null);

            return response()->json($this->response, 401);
        }

        array_push($this->response['status'], 'Success');
        array_push($this->response['errors'], null);

        $subData = array(
            'token' => $token,
            'message' => 'تم تسجيل الدخول بنجاح',
        );
        array_push($this->response['response'], $subData);

        return response()->json($this->response);
    }

    // This Function To Show The Personal Data
    public function me()
    {
        $user = User::find(auth('api')->user()->student->user_id);
        $this->data['user'] = [
            'first_name' => $user->student->first_name,
            'second_name' => $user->student->second_name,
            'third_name' => $user->student->third_name,
            'last_name' => $user->student->last_name,
            'year' => $user->student->year,
            'month' => $user->student->month,
            'day' => $user->student->day,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'country' => $user->student->city->country->name,
            'city' => $user->student->city->name,
            'gender' => $user->student->gender->name,
            'profile-image' => "/storage/account-images/" . $user->student->image,
            'reservations' => count($user->student->reservation),
            'certificate' => count($user->student->certificate),
        ];
        array_push($this->response['status'], 'Success');
        array_push($this->response['errors'], null);
        array_push($this->response['response'], $this->data);
        return response()->json($this->response);
    }

    // This Function For Logout
    public function logout()
    {
        auth('api')->logout();

        array_push($this->response['status'], 'Success');
        array_push($this->response['errors'], null);
        array_push($this->response['response'], 'تم تسجيل الخروج بنجاح');

        return response()->json($this->response);
    }

    // This Function Returns All Centers
    public function centers()
    {

        $centers = Center::all();

        if ( $centers->count() < 1 )
        {
            $this->response['status'] = "Failed";
            array_push($this->response['errors'], 'لايوجد جهات مسجلة في النظام');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }else {

            foreach ($centers as $center){

                if ($center->type == 1){
                    $type = 'profit';
                }else{
                    $type = 'nonprofit';
                }

                $socialMedia = array();

                for ($i = 0; $i < 4; $i++) {
                    $social_media = ['Twitter', 'Facebook', 'Snapchat', 'Instagram'];

                    $subData = array(
                        'name' => $social_media[$i],
                        'account' => $social_media[$i] . ' Account',
                    );
                    array_push($socialMedia, $subData);
                }

                $this->data['centers'] = array();

                $subData = array(
                    'name' => $center->name,
                    'phone' => $center->phone,
                    'email' => $center->email,
                    'website' => $center->website,
                    'city' => $center->city->name,
                    'about' => $center->about,
                    'verification_number' => $center->verification_code,
                    'verification_authority' => $center->verification_authority,
                    'type' => $type,
                    'courses' => $center->course->count(),
                    'trainers' => $center->trainer->count(),
                    'socialMedia' => $socialMedia,
                );

                array_push($this->data['centers'], $subData);
            }

            $this->response['status'] = "Success";
            array_push($this->response['errors'], null);
            array_push($this->response['response'], $this->data);

            return response()->json($this->response);


        }
    }

    // This Function For Refreshing The Old Token And Replace It With A New One
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    // This Function Generate The Token
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
