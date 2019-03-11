<?php

namespace App\Http\Controllers;

use App\AdvertisingBanner;
use App\User;
use App\City;
use App\Country;
use App\Coupon;
use App\Course;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentAPIController extends Controller
{
    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $response = array(
        'status' => array(),
        'errors' => array(),
        'response' => array(),
    );
    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $data = array();

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'index']]);
    }

    // This Index Function Retrieve All Courses Are Available In The Database
    public function index()
    {
        $this->data['banners'] = array();
        $this->response['response'] = array(
            'banners' => array(),
            'data' => array(),
        );
        $courses = Course::all();

        if (count($courses) < 1) {
            array_push($this->response['status'], "success");
            array_push($this->response['errors'], null);
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {


            $banners = AdvertisingBanner::all();

            foreach ($banners as $banner) {
                $subData = array(
                    'banner' => $banner->banner,
                    'title' => $banner->title,
                    'link' => $banner->link,
                    'description' => $banner->description,
                );

                array_push($this->response['response']['banners'], $subData);
            }

            foreach ($courses as $course) {
                if ($course->type == "free") {
                    $price = 0;
                } else {
                    $price = $course->price;
                }
                $this->data = [
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
                ];

                $this->data['trainers'] = array();


                foreach ($course->trainer as $trainer) {
                    $trainersData = array(
                        'trainer-name' => $trainer->trainer->name,
                        'trainer-title' => $trainer->trainer->title->name,
                        'trainer-image' => "/storage/trainer-images/" . $trainer->trainer->image,
                    );
                    array_push($this->data['trainers'], array($trainersData));
                }

                array_push($this->response['response']['data'], $this->data);
            }

            array_push($this->response['status'], "success");
            array_push($this->response['errors'], null);

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
            array_push($this->response['status'], "failed");
            array_push($this->response['errors'], 'لاتوجد تذاكر تم محجوزة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        $confirmed_tickets = Reservation::where('student_id', auth('api')->user()->student->id)->where('confirmation', 1)->get();

        if (count($confirmed_tickets) > 0) {
            foreach ($confirmed_tickets as $ticket) {
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

        $unconfirmed_tickets = Course::select('id')->where('start_date', '>=', date('Y-m-d'))->get();

        for ($i = 0; $i < count($unconfirmed_tickets); $i++) {
            $tickets = Reservation::where('course_id', $unconfirmed_tickets[$i]->id)->where('student_id', auth('api')->user()->student->id)->where('confirmation', 0)->get();
            if (count($tickets) > 0) {
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

        $finished_tickets = Course::select('id')->where('start_date', '<', date('Y-m-d'))->get();

        for ($i = 0; $i < count($finished_tickets); $i++) {
            $tickets = Reservation::where('course_id', $finished_tickets[$i]->id)->where('student_id', auth('api')->user()->student->id)->where('confirmation', 0)->where()->get();
            if (count($tickets) > 0) {
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

        array_push($this->response['status'], "success");
        array_push($this->response['errors'], null);
        array_push($this->response['response'], $this->data);

        return response()->json($this->response);
    }

    // This Function Show All The Certificate That That The User | Student Got
    public function certificate()
    {
        return response()->json($this->response);
    }

    // This Function Show More Details About The Selected Course
    public function show_course($center_username, $course_identifier)
    {

        $center = User::where('username', $center_username)->first();

        if (count($center) < 1) {
            array_push($this->response['status'], "failed");
            array_push($this->response['errors'], "الرجاء التأكد من معرف الجهة");
            array_push($this->response['response'], null);
            return response()->json($this->response);
        } else {

            $course = Course::where('identifier', $course_identifier)->first();

            if (count($course) < 1) {
                array_push($this->response['status'], "failed");
                array_push($this->response['errors'], "الرجاء التأكد من معرف الدورة");
                array_push($this->response['response'], null);
                return response()->json($this->response);
            } else {
                if ($course->type == "free") {
                    $price = 0;
                } else {
                    $price = $course->price;
                }
                $data = array(
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
                array_push($this->response['status'], "success");
                array_push($this->response['errors'], null);
                array_push($this->response['response'], $data);
                return response()->json($this->response);
            }
        }
    }

    // This Function Retrieve The User Personal Data To Be Edited
    public function edit()
    {

        $user = User::find(auth('api')->user()->student->user_id);

        $data = array(
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

        array_push($this->response['response'], $data);

        $this->data['countries'] = array();
        $countries = Country::all();
        for ($i = 0; $i < count($countries); $i++) {
            $subData = array(
                'id' => $countries[$i]->id,
                'name' => $countries[$i]->name,
            );
            array_push($this->data['countries'], $subData);
        }

        array_push($this->response['status'], "success");
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
                'phone' => 'email|unique:users,email' . Rule::unique('users')->ignore(auth('api')->user()->student->user_id),
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
            if (File::exists('storage/account-images/', $user->student->image)) {
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
                'second_name' => 'integer|exists:countries,id',
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
                'second_name' => 'integer|' . Rule::in($cities),
            ]);
            $counter++;
        }

        if ($counter > 0) {
            $user->save();
            $user->student->save();

            array_push($this->response['errors'], null);
            array_push($this->response['response'], "تم تعديل البيانات بنجاح");

        }

        array_push($this->response['status'], "failed");
        array_push($this->response['errors'], "قم بتعديل بعض البيانات لكي يتم حفظها");
        array_push($this->response['response'], null);


        return response()->json($this->response);
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
            'phone' => 'required|max:9|min:9|unique:users,phone',
            'gender' => 'required|max:99|min:1|exists:genders,id',
            'country' => 'required|integer|max:99|min:1|exists:countries,id',
            'city' => 'required|integer|max:99|min:1|' . Rule::in($cities),
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

            array_push($this->response['status'], "success");
            array_push($this->response['errors'], null);
            array_push($this->response['response'], $this->data);
            return response()->json($this->response);
        } catch (\Exception $e) {
            DB::rollBack();
            array_push($this->response['status'], "failed");
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
            'coupon' => 'nullable|string|max:10|min:3'
        ]);


        $course = Course::where('identifier', $request->identifier)->first();
        if (count($course) < 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'Invalid Course Identifier');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {
            $reservation = Reservation::where('course_id', $course->id)->where('student_id', auth('api')->user()->student->id)->first();
            if (count($reservation) > 0) {
                array_push($this->response['status'], 'failed');
                array_push($this->response['errors'], 'تم حجز الدورة مسبقا قم بإلغاء الحجز لكي تتمكن من حجزها مجددا');
                array_push($this->response['response'], null);

                return response()->json($this->response);
            } else {

                if (!is_null($request->coupon)) {
                    $coupon_data = Coupon::where('code', $request->coupon)->where('course_id', $course->id)->first();
                    if (count($coupon_data) > 0) {
                        $coupon = $coupon_data->id;
                    } else {
                        $coupon = 0;
                    }

                }

                try {

                    Reservation::create([
                        'student_id' => auth('api')->user()->student->id,
                        'course_id' => $course->id,
                        'coupon' => $coupon,
                        'identifier' => Str::random(10),
                        'confirmation' => 0,

                    ]);

                    array_push($this->response['status'], 'success');
                    array_push($this->response['errors'], null);

                    if ($course->type == 'free') {
                        array_push($this->response['response'], 'تم حجز الدور بنجاح قم بإنتظار التأكيد من المدير');
                    } else {
                        array_push($this->response['response'], 'تم حجز الدور بنجاح قم بدفع قيمة الدورة لكي يتم إصدار الشهادة');
                    }

                    return response()->json($this->response);

                } catch (\Exception $e) {
                    array_push($this->response['status'], 'Error');
                    array_push($this->response['errors'], 'خطأ تقني أثناء حجز الدورة');
                    array_push($this->response['response'], null);

                    return response()->json($this->response);
                }

            }
        }
    }

    // This Function Show More Details About The Center
    public function show_center($center_username)
    {

        $user = User::where('username', $center_username)->first();
        if (count($user) < 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'الرجاء التأكد من معرف الجهة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {
            $this->data = array(
                'name' => $user->center->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'website' => $user->center->website,
                'city' => $user->center->city->name,
                'about' => $user->center->about,
            );

            $this->data['socialMedia'] = array();

            for ($i = 0; $i < 4; $i++) {
                $social_media = ['Twitter', 'Snapchat', 'Youtube', 'Facebook'];

                $subData = array(
                    'name' => $social_media[$i],
                    'account' => $social_media[$i] . ' Account',
                );
                array_push($this->data['socialMedia'], $subData);
            }

            $this->data['courses'] = array();

            foreach ($user->center->course as $course) {

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

            array_push($this->response['status'], "success");
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

        $user = User::find(auth('api')->user()->student->user_id)->first();

        if (!Hash::check($request->old_password, $user->password)) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'كلمة المرور القديمة غير صحيحة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {
            if (Hash::check($request->new_password, $user->password)) {
                array_push($this->response['status'], 'failed');
                array_push($this->response['errors'], 'كلمة المرور الجديدة يجب أن تكون مختلفة عن القديمة');
                array_push($this->response['response'], null);

                return response()->json($this->response);
            } else {
                $user->password = Hash::make($request->new_password);
                $user->save();

                array_push($this->response['status'], 'success');
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
            'identifier' => 'required|string|exists:reservation,identifier',
        ]);

        $reservation = Reservation::where('identifier', $request->identifier)->first();

        if ( count($reservation) < 1 ){
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'الرجاء التأكد من معرف الحجز');
            array_push($this->response['response'], null);
            return response()->json($this->response);
        }

        if ($reservation->confirmation == 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'تم تأكيد حجزك الرجاء التواصل مع الاإدارة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {

            try {

                $reservation->delete();

                array_push($this->response['status'], 'success');
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

    // This Function For Login Going To Be Used With All Request Of Login
    public function login()
    {
        $credentials = request(['username', 'password']);

        if (!$token = auth('api')->logout($credentials)) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'الرجاء التأكد من اسم المستخدم | كلمة المرور');
            array_push($this->response['response'], null);
            return response()->json($this->response, 401);
        }


        array_push($this->response['status'], 'success');
        array_push($this->response['errors'], null);
        $this->data = array(
            'token' => $token,
            'message' => 'تم تسجيل الدخول بنجاح',
            'type' => auth('api')->user()->role->name،
        );
        array_push($this->response['response'], $this->data);

        return response()->json($this->response);
    }

    // This Function To Show The Personal Data
    public function me()
    {
        $user = User::find(auth('api')->user()->student->user_id);
        $this->response['response'] = [
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
        ];
        array_push($this->response['status'], 'success');
        array_push($this->response['errors'], null);
        return response()->json($this->response);
    }

    // This Function For Logout
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'successfully logged out']);
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
