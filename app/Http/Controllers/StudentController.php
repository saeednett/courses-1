<?php

namespace App\Http\Controllers;

use App\AdvertisingBanner;
use App\CenterAccount;
use App\CenterSocialMedia;
use App\Certificate;
use App\City;
use App\ContactUs;
use App\Country;
use App\Coupon;
use App\Course;
use App\PaymentConfirmation;
use App\Reservation;
use App\User;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class StudentController extends Controller
{

    // Check If Student | User Is Authenticate And His Role Id Is 5
    private function check_authenticate()
    {
        if (Auth::check() && Auth::user()->role_id == 5) {
            return true;
        } else {
            return false;
        }
    }

    // This Function Return An Error Page
    private function error_page($error)
    {
        if ($this->check_authenticate()) {

            $tickets = $this->get_auth_tickets();
            $certificates = $this->get_auth_new_certificates();
            return view('student.error-page', compact('error', 'tickets', 'certificates'));

        } else {
            return view('student.error-page', compact('error'));
        }
    }

    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $response = array(
        'status' => array(),
        'errors' => array(),
        'response' => array(),
    );

    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $data = array();

    // This Function Return Number Of Tickets That Are Reserved By The User
    private function get_auth_tickets()
    {
        if ($this->check_authenticate()) {
            // Get All Reservations To Filter It
            $reservations = Reservation::where('student_id', Auth::user()->student->id)->get();
            // To Filter The Reservation That Is Not Confirmed
            $tickets = array();
            foreach ($reservations as $reservation) {
                if ($reservation->course->start_date > date('Y-m-d') && $reservation->confirmation == 0 && is_null($reservation->payment)) {
                    array_push($tickets, $reservation->id);
                }
            }
            // Save The Total Count
            $tickets = count($tickets);
        } else {
            $tickets = 0;
        }

        return $tickets;
    }

    // This Function Return Number Of New Certificate That Owned By The User
    private function get_auth_new_certificates()
    {

        if ($this->check_authenticate()) {
            $certificates = Certificate::where('student_id', Auth::user()->student->id)->where('viewed', 0)->get();
            return count($certificates);
        } else {
            return 0;
        }
    }

    // This Function Return All Courses
    private function all_curses()
    {
        // Getting The Visible Courses
        $courses = Course::where('visible', 1)->where('activation', 1)->where('validation', 1)->get();

        foreach ($courses as $course) {
            $subData = array(
                'title' => $course->title,
                'type' => $course->type,
                'price' => $course->price,
                'city' => $course->city->name,
                'identifier' => $course->identifier,
                'poster_1' => $course->image->image,
                'poster_2' => $course->image->image_2,
                'center' => $course->center->user->username,
            );

            array_push($this->response['response'], $subData);
        }

        array_push($this->response['status'], 'success');
        array_push($this->response['errors'], null);
        return response()->json($this->response);
    }

    // This Function Return All Payed Courses
    private function payed_curses()
    {
        // Getting The Visible Courses
        $courses = Course::where('visible', 1)->where('type', 'payed')->where('activation', 1)->where('validation', 1)->get();

        foreach ($courses as $course) {
            $subData = array(
                'title' => $course->title,
                'type' => $course->type,
                'price' => $course->price,
                'city' => $course->city->name,
                'identifier' => $course->identifier,
                'poster_1' => $course->image->image,
                'poster_2' => $course->image->image_2,
                'center' => $course->center->user->username,
            );

            array_push($this->response['response'], $subData);
        }

        array_push($this->response['status'], 'success');
        array_push($this->response['errors'], null);
        return response()->json($this->response);
    }

    // This Function Return All Free Courses
    private function free_curses()
    {
        // Getting The Visible Courses
        $courses = Course::where('visible', 1)->where('type', 'free')->where('activation', 1)->where('validation', 1)->get();

        foreach ($courses as $course) {
            $subData = array(
                'title' => $course->title,
                'type' => $course->type,
                'price' => $course->price,
                'city' => $course->city->name,
                'identifier' => $course->identifier,
                'poster_1' => $course->image->image,
                'poster_2' => $course->image->image_2,
                'center' => $course->center->user->username,
            );

            array_push($this->response['response'], $subData);
        }

        array_push($this->response['status'], 'success');
        array_push($this->response['errors'], null);
        return response()->json($this->response);
    }

    // This Function Return All Available Courses
    private function available_curses()
    {

        // Getting The Visible Courses
        $courses = Course::where('visible', 1)->where('activation', 1)->where('validation', 1)->get();
        // Getting The Reservation Of The Course To Count The Remain Places
        $courses_data = array();
        foreach ($courses as $course) {
            if (count($course->reservation) < $course->attendance) {
                $date1  = date_create(date("Y-m-d"));
                $date2 = date_create($course->end_reservation);
                $diff = date_diff($date1, $date2);
                $date_state = $diff->format("%R%a");

                // If Date Of The End Reservation And Total Attendance Has Not Complete
                if( $date_state >= 0 ){
                    array_push($courses_data, $course->id);
                }

            }
        }

        $allCourses = Course::find($courses_data);

        foreach ($allCourses as $course) {
            $subData = array(
                'title' => $course->title,
                'type' => $course->type,
                'price' => $course->price,
                'city' => $course->city->name,
                'identifier' => $course->identifier,
                'poster_1' => $course->image->image,
                'poster_2' => $course->image->image_2,
                'center' => $course->center->user->username,
            );

            array_push($this->response['response'], $subData);
        }

        array_push($this->response['status'], 'success');
        array_push($this->response['errors'], null);
        return response()->json($this->response);
    }

    // This Function Handle The Filter Of Showing The Courses
    public function filtered_index(Request $request)
    {
        $filter = $request->type;
        switch ($filter) {
            case "all":
                return $this->all_curses();
                break;

            case "payed":
                return $this->payed_curses();
                break;

            case "free":
                return $this->free_curses();
                break;

            case "available":
                return $this->available_curses();
                break;

            default:
                return $this->all_curses();
                break;
        }
    }

    // To Show All Courses That Are Visible To Public
    public function index()
    {

        $banners_state = 0;
        $banners_state_array = array();
        // Getting All Advertising Banners To Show Them In The Index Page
        $banners = AdvertisingBanner::all();
        // Getting Banners State To Determine weather Show Banners Or Not
        foreach ($banners as $banner){
            if ( $banner->status == 0 ){
                array_push($banners_state_array, $banner->status);
            }
        }

        if (count($banners_state_array) == count($banners)){
            $banners_state = 0;
        }else{
            $banners_state = 1;
        }

        if ($this->check_authenticate()) {

            // Save The Total Count
            $tickets = $this->get_auth_tickets();
            $certificates = $this->get_auth_new_certificates();;
            // Getting The Visible Courses
            $courses = Course::where('visible', 1)->where('activation', 1)->where('validation', 1)->get();
            return view('student.index', compact('courses', 'tickets', 'banners', 'certificates', 'banners_state'));
        } else {
            // Getting The Visible Courses
            $courses = Course::where('visible', 1)->where('activation', 1)->where('validation', 1)->get();
            return view('student.index', compact('courses', 'banners', 'banners_state'));
        }
    }

    // To Show The Form Of Registering Of The Student
    public function create()
    {
        $countries = Country::all();
        $cities = City::where('country_id', 1)->get();
        return view('student.register', compact('countries', 'cities'));
    }

    // The Registering Data Goes Here
    public function store(Request $request)
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

        // Creating The User
        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'phone' => "+966" . $request->phone,
            'role_id' => 5,
            'status' => 1,
            'password' => Hash::make($request->password),
        ]);

        //Creating The Student
        Student::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'gender_id' => $request->gender,
            'city_id' => $request->city,
            'image' => 'default.jpg',
            'year' => 0,
            'month' => 0,
            'day' => 0,
        ]);

        // Logging In The New User And Redirect Him To The Index
        auth()->login($user);

        // Redirect To The Index After Creating And Logging In
        return redirect()->route('account.index');

    }

    // To Preview A Center Profile
    public function show($username)
    {

        // When User|Student Wants To See The Profile Of The Center
        $user = User::where('username', $username)->first();
        if (empty($user)) {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من اسم الجهة");
        } else {

            // Getting All Courses
            $courses = Course::where('center_id', $user->center->id)->where('activation', 1)->where('validation', 1)->get();

            $tickets = $this->get_auth_tickets();
            $certificates = $this->get_auth_new_certificates();

            // Getting Current Courses Base On Date
            $current_courses = Course::where('center_id', $user->center->id)->where('start_date', '>=', date('Y-m-d'))->where('activation', 1)->count();
            // Getting Finished Courses Base On Date
            $finished_courses = Course::where('center_id', $user->center->id)->where('start_date', '<', date('Y-m-d'))->count();

            return view('student.center-profile', compact('user', 'courses', 'tickets', 'certificates', 'current_courses', 'finished_courses'));

        }
    }

    // To Show Course Details Before Reserving It
    public function show_course($username, $identifier)
    {

        // Checking The Username Of The Center
        $user = User::where('username', $username)->where('role_id', 2)->first();

        // If The Username Is Wrong
        if (empty($user)) {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الجهة");
        } else {

            // Checking The Course Unique Identifier
            $course = Course::where('identifier', $identifier)->where('activation', 1)->where('validation', 1)->first();

            // If The Identifier Is Wrong
            if (empty($course)) {
                return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الدورة");
            } else {

                // This Variable Will Hold Either 1 Or 1 To Identify Weather To Show Social Media Account Or Not
                $social_accounts_state = 0;
                $social_accounts_array = array();

                foreach ($user->center->socialMediaAccount as $social){
                    if ( $social->status == 0 ){
                        array_push($social_accounts_array, 0);
                    }
                }

                if ( count($social_accounts_array) == count($user->center->socialMediaAccount) ){
                    $social_accounts_state = 0;
                }else{
                    $social_accounts_state = 1;
                }


                $social_media_accounts = CenterSocialMedia::where('center_id', $user->center->id)->get();

                // Checking If The User Is Authenticated And His Role Is 5 That Mean He Is A User
                if ($this->check_authenticate()) {

                    $reservations = Reservation::where('course_id', $course->id)->get();
                    $reservation_state = 0;
                    foreach ($reservations as $reservation){
                        if ( $reservation->student_id == Auth::user()->student->id ){
                            $reservation_state = 1;
                        }
                    }

                    $tickets = $this->get_auth_tickets();
                    $certificates = $this->get_auth_new_certificates();

                    $date1 = date_create(date("Y-m-d"));
                    $date2 = date_create($course->end_reservation);
                    $diff = date_diff($date1, $date2);
                    $date_state = $diff->format("%R%a");

                    $days = $diff->format("%a");

                    if( $date_state >= 0 ){
                        $date_state = 0;
                    }else{
                        $date_state = 1;
                    }

                    // Return The View Of The Details
                    return view('student.show-course-details', compact('course', 'social_media_accounts', 'tickets', 'certificates', 'reservation_state', 'date_state', 'days', 'social_accounts_state'));
                } else {

                    $date1 = date_create(date("Y-m-d"));
                    $date2 = date_create($course->end_reservation);
                    $diff = date_diff($date1, $date2);
                    $date_state = $diff->format("%R%a");

                    $days = $diff->format("%a");

                    if( $date_state >= 0 ){
                        $date_state = 0;
                    }else{
                        $date_state = 1;
                    }

                    $reservation_state = 0;
                    return view('student.show-course-details', compact('course', 'social_media_accounts', 'reservation_state', 'date_state', 'days', 'social_accounts_state'));
                }

            }

        }

    }

    // To Show Final Step Before Reserving The Course
    public function reservation_course_form($identifier)
    {
//        if ($this->check_authenticate()) {

            // Checking The Course Unique Identifier
            $course = Course::where('identifier', $identifier)->where('activation', 1)->where('validation', 1)->first();

            // If The Identifier Is Wrong
            if (empty($course)) {
                return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الدورة");
            }else{

                if ( $course->start_date >= date("Y-m-d") ){

                    // Getting All Center Bank Accounts
                    $accounts = CenterAccount::where('center_id', $course->center->id)->get();

                    $tickets = $this->get_auth_tickets();
                    $certificates = $this->get_auth_new_certificates();;

                    // Return The View Of Booking The Course
                    return view('student.reserve-course', compact('course', 'accounts', 'tickets', 'certificates'));

                }else{
                    return $this->error_page('شكلك ضايع ما تعرف ان الدورة منهية اش رايك تختار دورة غيرها');
                }

            }

//        } else {
//            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
//        }

    }

    // The Data Of Reservation Goes Here And The Process Happens Here
    public function course_reservation_confirm(Request $request, $identifier)
    {

//        if ($this->check_authenticate()) {

            // Getting The Course Information
            $course = Course::where('identifier', $identifier)->where('activation', 1)->where('validation', 1)->first();

            // Making Sure The Course Is Exist
            if (empty($course)) {
                return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الدورة");
            }else {
                if ( $course->start_date >= date("Y-m-d") ){

                    // Checking If Course Already Reserved
                    $reserve = Reservation::where('course_id', $course->id)->where('student_id', Auth::user()->student->id)->first();
                    if (empty($reserve)) {
                        return redirect()->route('account.ticket')->withErrors(['تم حجز الدورة مسبقا قم بحذف الحجز القديم لكي تتمكن من حجزها مجددا']);
                    }else{

                        // Validating The Request Data
                        $request->validate([
                            'coupon_code' => 'nullable|string|min:3|max:30',
                        ]);

                        // Getting The Coupons Of The Course
                        $coupon = Coupon::where('code', $request->coupon_code)->where('course_id', $course->id)->first();

                        // Check If The User Coupon Is Exist
                        if (empty($coupon)) {
                            Reservation::create([
                                'student_id' => Auth::user()->student->id,
                                'coupon_id' => 0,
                                'course_id' => $course->id,
                                'identifier' => Str::random(10),
                            ]);
                        } else {
                            Reservation::create([
                                'student_id' => Auth::user()->student->id,
                                'coupon_id' => $coupon->id,
                                'course_id' => $course->id,
                                'identifier' => Str::random(10),
                            ]);
                        }

                        // Redirect To The Page That Show All Tickets Of The User | Student
                        return redirect()->route('account.ticket')->with('success', 'تم حجز دورة ' . $course->title . ' بنجاح قم بتسديد المبلغ لكي يتم إصدار البطاقة');

                    }

                }else {

                    return $this->error_page('شكلك ضايع ما تعرف ان الدورة منهية اش رايك تختار دورة غيرها');

                }
            }

//        } else {
//            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
//        }


    }

    // To Edit The Information Of The Student
    public function edit()
    {

        if ($this->check_authenticate()) {

            // Getting The Information Of The Student
            $user = User::find(Auth::user()->student->user_id);

            // Getting All Cites
            $cities = City::where('country_id', $user->student->city->country->id)->get();

            // Getting All Countries
            $countries = Country::all();


            // Save The Total Count
            $tickets = $this->get_auth_tickets();
            $certificates = $this->get_auth_new_certificates();

            // Return To The View Of Editing The Information
            return view('student.edit-account', compact('user', 'countries', 'cities', 'tickets', 'certificates'));

        } else {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
        }

    }

    // the Data Of Editing Information Goes Here And The Process Happens Here
    public function update(Request $request)
    {

        if ($this->check_authenticate()) {

            // Getting All Cities Which Belongs To The Country That The User | Student Chose
            $cities = City::where('country_id', $request->country)->get();

            // Checking If The Country Id Is Valid
            if (count($cities) < 1) {
                return redirect()->route('account.edit')->withErrors(['الرجاء التأكد من الدولة']);
            }

            // An Empty Array Of City Will Be Filled Soon
            $cities_data = array();

            // Fetching The Cities Data Into The Array
            foreach ($cities as $city) {
                array_push($cities_data, $city->id);
            }

            // Validating The Request Data

            // Getting The SubInformation Of The User | Student
            $student = Student::where('user_id', Auth::user()->student->user_id)->first();

            // This Counter Will Increase If Any New Data Is Different To The Old One
            $counter = 0;

            // Comparing The First Name Old Data To The New
            if ($student->first_name != $request->first_name) {

                $request->validate([
                    'first_name' => 'required|string|max:10|min:2',
                ]);

                $student->first_name = $request->first_name;
                $counter++;
            }

            // Comparing The Second Name Old Data To The New
            if ($student->second_name != $request->second_name) {
                $request->validate([
                    'second_name' => 'required|string|max:10|min:2',
                ]);
                $student->second_name = $request->second_name;
                $counter++;
            }

            // Comparing The Third Name Old Data To The New
            if ($student->third_name != $request->third_name) {
                $request->validate([
                    'third_name' => 'required|string|max:10|min:2',
                ]);
                $student->third_name = $request->third_name;
                $counter++;
            }

            // Comparing The Last Name Old Data To The New
            if ($student->last_name != $request->last_name) {
                $request->validate([
                    'last_name' => 'required|string|max:10|min:2',
                ]);
                $student->last_name = $request->last_name;
                $counter++;
            }

            // Comparing Phone Old Data To The New
            if ($student->user->phone != $request->phone) {
                $request->validate([
                    'phone' => 'required|starts_with:+966|string|max:13|min:13|unique:users,phone',
                ]);
                $student->user->phone = $request->phone;
                $counter++;
            }

            // Comparing Email Old Data To The New
            if ($student->user->email != $request->email) {
                $request->validate([
                    'email' => 'required|string|max:100|unique:users,email',
                ]);
                $student->user->email = $request->email;
                $counter++;
            }

            // Comparing Username Old Data To The New
            if ($student->user->username != $request->username) {
                $request->validate([
                    'username' => 'required|string|max:20:min:5|unique:users,username',
                ]);
                $student->user->username = $request->username;
                $counter++;
            }

            // Comparing City Old Data To The New
            if ($student->city_id != $request->city) {
                $request->validate([
                    'city' => 'required|exists:cities,id|',
                ]);
                $student->city_id = $request->city;
                $counter++;
            }


            // Comparing Year Old Data To The New
            if ($student->year != $request->year) {
                $request->validate([
                    'year' => 'required|integer|max:2019|min:1930',
                ]);
                $student->year = $request->year;
                $counter++;
            }

            // Comparing Month Old Data To The New
            if ($student->month != $request->month) {
                $request->validate([
                    'month' => 'required|integer|max:12|min:1',
                ]);
                $student->month = $request->month;
                $counter++;
            }

            // Comparing Day Old Data To The New
            if ($student->day != $request->day) {
                $request->validate([
                    'day' => 'required|integer|max:31|min:1',
                ]);
                $student->day = $request->day;
                $counter++;
            }

            // Checking If The Request Has An Image
            if ($request->hasFile('profile-image')) {

                $request->validate([
                    'profile-image' => 'sometimes|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                ]);

                if (file_exists('public/account-images/' . $student->url)) {
                    if (Storage::delete('public/account-images/' . $student->url)) {
                        $file = $request->file('profile-image')->store('public/account-images');
                        $file_name = basename($file);
                        $student->url = $file_name;
                    }
                } else {
                    $file = $request->file('profile-image')->store('public/account-images');
                    $file_name = basename($file);
                    $student->url = $file_name;
                }
                $counter++;
            }

            // Checking If The Counter Is Greater Than 0 Then Do The Update
            if ($counter == 0) {
                return redirect()->route('account.edit')->withErrors(['قم بتحديث بعض الحقول لكي يتم حفظ البيانات']);
            } else {
                $student->save();
                $student->user->save();
                return redirect()->route('account.edit')->with('success', 'تم تحديث البيانات الشخصية بنجاح');
            }

        } else {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
        }


    }

    // This Function For Canceling Course Reservation
    public function destroy_course_reservation($identifier)
    {
        if ($this->check_authenticate()) {

            $reservation = Reservation::where('identifier', $identifier)->first();

            if (empty($reservation)) {
                return redirect()->route('account.tickets')->withErrors(["الرجاء التأكد من معرف الحجز المراد إلغاءه"]);
            }else{

                $reservation = Reservation::where('identifier', $identifier)->where('confirmation', 0)->first();

                if (empty($reservation)) {
                    return redirect()->route('account.ticket')->withErrors(["لايمكنك إلغاء الحجز بعد ان تم تأكيد قم بالتواصل مع إدارة الموقع"]);
                }else{
                    $reservation->payment->delete();
                    $reservation->delete();
                    return redirect()->route('account.ticket')->with('success', 'تم إلغاء حجز الدورة بنجاح');
                }

            }

        } else {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
        }
    }

    // To Show The Form Of Logging in For The Student
    public function create_sign_in()
    {
        // Returning The View
        return view('student.login');
    }

    // To Show All Tickets Of The User | Student
    public function tickets()
    {
        if ($this->check_authenticate()) {

            // Getting All Reservation For The User | Student
            $reservations = Reservation::where('student_id', Auth::user()->student->id)->get();
            $tickets = $this->get_auth_tickets();
            $certificates = $this->get_auth_new_certificates();
            // Returning The View Of The Tickets
            return view('student.tickets', compact('reservations', 'tickets', 'certificates'));

        } else {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
        }

    }

    // To Show All Tickets Of The User | Student By Filter
    private function all_tickets()
    {

        if ($this->check_authenticate()){

            // Getting All Reservation For The User | Student
            $reservations = Reservation::where('student_id', Auth::user()->student->id)->get();

            // Getting Count Of The Tickets That Is Not Payed For

            foreach ($reservations as $reservation) {


                if (!is_null($reservation->payment)) {
                    if ($reservation->course->start_date >= date('y-m-d')) {

                        if ($reservation->course->start_date > date('y-m-d') && $reservation->confirmation == 1) {

                            $ticket_type = "confirmed";

                        } else if ($reservation->course->start_date > date('y-m-d') && $reservation->confirmation == 0) {
                            $ticket_type = "AdminUnconfirmed";
                        }

                    } else {
                        $ticket_type = "finished";
                    }
                } else {
                    if ($reservation->course->type == "free") {

                        $ticket_type = "FreeUnconfirmed";

                    } else {
                        $ticket_type = "StudentUnconfirmed";
                    }
                }


                $subData = array(
                    'title' => $reservation->course->title,
                    'confirmation' => $reservation->confirmation,
                    'date' => $reservation->course->start_date,
                    'ticket_type' => $ticket_type,
                    'city' => $reservation->course->city->name,
                    'price' => $reservation->course->price,
                    'type' => $reservation->course->type,
                    'identifier' => $reservation->identifier,
                    'poster_1' => $reservation->course->image->image,
                );
                array_push($this->response['response'], $subData);
            }

            array_push($this->response['status'], 'success');
            array_push($this->response['errors'], null);

            return response()->json($this->response);

        }else{
            return response()->json(array("Unauthenticated"));
        }

    }

    // To Show All The Finished Tickets Of The User | Student By Filter
    private function finished_tickets()
    {

        if ($this->check_authenticate()){

            // Getting All Reservation For The User | Student
            $reservations = Reservation::where('student_id', Auth::user()->student->id)->where('confirmation', 1)->get();

            // Getting Count Of The Tickets That Is Not Payed For
            foreach ($reservations as $reservation) {

                if ($reservation->course->start_date < date('y-m-d')) {

                    $ticket_type = "finished";
                    $subData = array(
                        'title' => $reservation->course->title,
                        'confirmation' => $reservation->confirmation,
                        'date' => $reservation->course->start_date,
                        'ticket_type' => $ticket_type,
                        'city' => $reservation->course->city->name,
                        'price' => $reservation->course->price,
                        'type' => $reservation->course->type,
                        'identifier' => $reservation->identifier,
                        'poster_1' => $reservation->course->image->image,
                    );

                    array_push($this->response['response'], $subData);

                }
            }

            array_push($this->response['status'], 'success');
            array_push($this->response['errors'], null);

            return response()->json($this->response);

        }else{
            return response()->json(array("Unauthenticated"));
        }

    }

    // To Show All The Confirmed Tickets Of The User | Student By Filter
    private function confirmed_tickets()
    {

        if ($this->check_authenticate()){
            // Getting All Reservation For The User | Student
            $reservations = Reservation::where('student_id', Auth::user()->student->id)->where('confirmation', 1)->get();

            // Getting Count Of The Tickets That Is Not Payed For
            foreach ($reservations as $reservation) {

                if ($reservation->course->start_date >= date('y-m-d') && $reservation->confirmation == 1) {

                    $ticket_type = "confirmed";
                    $subData = array(
                        'title' => $reservation->course->title,
                        'confirmation' => $reservation->confirmation,
                        'date' => $reservation->course->start_date,
                        'ticket_type' => $ticket_type,
                        'city' => $reservation->course->city->name,
                        'price' => $reservation->course->price,
                        'type' => $reservation->course->type,
                        'identifier' => $reservation->identifier,
                        'poster_1' => $reservation->course->image->image,
                    );

                    array_push($this->response['response'], $subData);

                }
            }

            array_push($this->response['status'], 'success');
            array_push($this->response['errors'], null);

            return response()->json($this->response);
        }else{
            return response()->json(array("Unauthenticated"));
        }

    }

    // To Show All The Unconfirmed Tickets Of The User | Student By Filter
    private function unconfirmed_tickets()
    {

        if ($this->check_authenticate()){
            // Getting All Reservation For The User | Student
            $reservations = Reservation::where('student_id', Auth::user()->student->id)->where('confirmation', 0)->get();

            // Getting Count Of The Tickets That Is Not Payed For
            foreach ($reservations as $reservation) {

                if ($reservation->course->start_date >= date('y-m-d') && $reservation->confirmation == 0) {
                    if ($reservation->course->type == "free") {
                        $ticket_type = "FreeUnconfirmed";
                    } else {
                        if (!is_null($reservation->payment)) {
                            $ticket_type = "AdminUnconfirmed";
                        } else {
                            $ticket_type = "StudentUnconfirmed";
                        }
                    }

                    $subData = array(
                        'title' => $reservation->course->title,
                        'confirmation' => $reservation->confirmation,
                        'date' => $reservation->course->start_date,
                        'ticket_type' => $ticket_type,
                        'city' => $reservation->course->city->name,
                        'price' => $reservation->course->price,
                        'type' => $reservation->course->type,
                        'identifier' => $reservation->identifier,
                        'poster_1' => $reservation->course->image->image,
                    );

                    array_push($this->response['response'], $subData);

                }
            }

            array_push($this->response['status'], 'success');
            array_push($this->response['errors'], null);

            return response()->json($this->response);
        }else{
            return response()->json(array("Unauthenticated"));
        }

    }

    // This Function Handle The Filter Of Showing The Tickets
    public function filtered_tickets(Request $request)
    {
        $filter = $request->type;

        switch ($filter) {
            case "all":
                return $this->all_tickets();
                break;

            case "finished":
                return $this->finished_tickets();
                break;

            case "confirmed":
                return $this->confirmed_tickets();
                break;

            case "unconfirmed":
                return $this->unconfirmed_tickets();
                break;

            default:
                return $this->all_tickets();
                break;
        }
    }

    // To Show The Form Of Confirming A Payment For The Course
    public function payment_confirmation($identifier)
    {

        if ($this->check_authenticate()) {

            // The Reservation That Wanted To Be Confirmed
            $reservation = Reservation::where('identifier', $identifier)->where('student_id', Auth::user()->student->id)->first();

            // Checking If The Reservation iIs Exist
            if (empty($reservation)) {
                return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز");
            }else{

                if ($reservation->course->start_date < date("Y-m-d")) {
                    return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز او من تاريخ الحجز");
                }else{
                    $tickets = $this->get_auth_tickets();
                    $certificates = $this->get_auth_new_certificates();

                    return view('student.payment-confirmation', compact('reservation', 'tickets', 'certificates'));
                }

            }

        } else {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
        }

    }

    // The Data Of Confirmation Goes Here And The Process Happens Here
    public function confirm(Request $request, $identifier)
    {

        if ($this->check_authenticate()) {

            // Getting The Reservation Of The User | Student
            $reservation = Reservation::where('identifier', $identifier)->where('student_id', Auth::user()->student->id)->first();

            // Checking If The Reservation iIs Exist
            if (empty($reservation)) {
                return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز");
            }else {

                if ($reservation->course->start_date < date("Y-m-d")) {
                    return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز او من تاريخ الحجز");
                }else {

                    // Validation The Request Data
                    $request->validate([
                        'account_owner' => 'required|string|max:50|min:10',
                        'account_number' => 'required|max:30|min:10',
                        'receipt-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:500',
                    ]);

                    // Checking If The Request Has An Image
                    $file = $request->file('receipt-image')->store('public/receipt-images');
                    $file_name = basename($file);

                    // Saving The Data Into The Database
                    PaymentConfirmation::create([
                        'account_owner' => $request->account_owner,
                        'account_number' => $request->account_number,
                        'image' => $file_name,
                        'reservation_id' => $reservation->id,
                        'status' => 1,
                    ]);

                    // Redirect After Saving The Data Of Confirmation
                    return redirect()->route('account.ticket')->with('success', 'تم إضافة معلومات الدفع سيتم اصدار التذكرة بعد التأكدة من صحة معلومات الدفع');

                }

            }

        } else {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
        }

    }

    // To Show The Form Of Editing The Payment Confirmation
    public function edit_payment_confirmation_form($identifier)
    {

        if ($this->check_authenticate()) {

            // The Confirmation That Will Be Edit
            $reservation = Reservation::where('identifier', $identifier)->where('student_id', Auth::user()->student->id)->first();

            // Checking If The Reservation Is Exist
            if (empty($reservation)) {
                return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز");
            }else {

                // Checking If The Date Of The Course Is Old
                if ($reservation->course->start_date < date("Y-m-d")) {
                    return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز او من تاريخ الحجز");
                }else {
                    $tickets = $this->get_auth_tickets();
                    $certificates = $this->get_auth_new_certificates();

                    return view('student.edit-payment-confirmation', compact('reservation', 'tickets', 'certificates'));
                }

            }

        } else {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
        }

    }

    // The Data Of Editing The Payment Confirmation Goes Here And The Process Happens Here
    public function update_payment_confirmation(Request $request, $identifier)
    {

        if ($this->check_authenticate()) {

            // Getting The Reservation That Will Be Edit
            $reservation = Reservation::where('identifier', $identifier)->where('student_id', Auth::user()->student->id)->first();

            if (empty($reservation)) {
                return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز");
            }else {

                if ($reservation->course->start_date < date("Y-m-d")) {
                    return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز او من تاريخ الحجز");
                }else {
                    // Validating The Request Data
                    $request->validate([
                        'account_owner' => 'string|max:50|min:10',
                        'account_number' => 'max:20|min:20',
                        'receipt-image' => 'image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                    ]);

                    // Getting The Old payment Confirmation Data
                    $payment = PaymentConfirmation::where('reservation_id', $reservation->id)->first();

                    // This Variable Will Change If There Is A New File With The Request
                    $file_name = null;

                    // Checking If The Request Has An Image
                    if ($request->hasFile('receipt-image')) {
                        $file = $request->file('receipt-image')->store('public/receipt-images');
                        $file_name = basename($file);
                    }

                    // This Counter Will Be Increase If The New Data Is Different To The Old
                    $counter = 0;

                    // Comparing The Old Account Owner With New
                    if ($request->account_owner != $payment->account_owner) {
                        $payment->account_owner = $request->account_owner;
                        $counter++;
                    }

                    // Comparing The Old Account Number With New
                    if ($request->account_number != $payment->account_number) {
                        $payment->account_number = $request->account_number;
                        $counter++;
                    }

                    // Comparing The Payment Image With New
                    if ($file_name != null) {
                        $payment->image = $file_name;
                        $counter++;
                    }

                    // Checking The Counter Is Greater Than 0 Then Save The Changes
                    if ($counter == 0) {
                        return redirect()->route('student.payment.confirmation.edit')->withErrors(['قم بتحديث بعض الحقول لكي يتم حفظها']);
                    }else {
                        $payment->update();
                        return redirect()->route('account.ticket')->with('success', 'تم تعديل معلومات الدفع سيتم اصدار التذكرة بعد التأكدة من صحة معلومات الدفع');
                    }

                }

            }

        } else {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
        }

    }

    // To Show The Form Of Resetting The Password
    public function create_reset_password()
    {
        if (Auth::check() && Auth::user()->role_id == 5) {

            $tickets = $this->get_auth_tickets();
            $certificates = $this->get_auth_new_certificates();
            return view('student.account-reset-password', compact('tickets', 'certificates'));

        } else {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
        }

    }

    // The Data Of Resetting Password Goes Here And The Process Happens Here
    public function reset_password(Request $request)
    {

        if ($this->check_authenticate()) {

            // The User | Student Data
            $user = User::find(Auth::user()->id);
            // Checking If The Old Password Is Correct
            if (Hash::check($request->old_password, $user->password)) {
                // Validating The Request Data
                $request->validate([
                    'password' => 'required|string|max:32|min:6|confirmed',
                ]);
                // Check If The New Password Equal The New Password
                if (Hash::check($request->password, $user->password)) {
                    // Return With Error Message
                    return redirect()->route('account.password')->withErrors('كلمة المرور الجديدة لابد ان تكون مختلفة عن القديمة');
                } else {
                    // Hash The New Password
                    $user->password = Hash::make($request->password);
                    // Save The New Password
                    $user->save();
                    // Redirect After Resetting The Password
                    return redirect()->route('account.password')->with('success', 'تم تغير كلمة المرور بنجاح');
                }
            } else {
                // Redirect With Error Message If The Old Password Is Wrong
                return redirect()->route('account.password')->withErrors('كلمة المرور القديمة غير صحصيحة');
            }

        } else {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
        }

    }

    // This Function Show The Contact Us Page
    public function contact_us()
    {
        $tickets = $this->get_auth_tickets();
        $certificates = $this->get_auth_new_certificates();

        // Returning The View Of The Tickets
        return view('student.contact-us', compact('tickets', 'certificates'));
    }

    // The Data Of Contacting Us
    public function contact_us_confirm(Request $request)
    {

        $request->validate([
            'subject' => 'required|string|max:50|min:6',
            'name' => 'required|string|max:40|min:6',
            'phone' => 'required|max:15|min:10',
            'email' => 'required|email|max:100',
            'message' => 'required|string|max:200|min:10',
        ]);


//        try {

            if (Auth::check()) {
                $registered = 1;
                $account_id = Auth::user()->id;
            } else {
                $registered = 0;
                $account_id = 0;
            }

            ContactUs::create([
                'subject' => $request->subject,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'message' => $request->message,
                'registered' => $registered,
                'account_id' => $account_id,
            ]);

            return redirect()->route('account.contact_us')->with('success', 'تم إرسال الرسالة بنجاح');

//        } catch (\Exception $e) {
//            return redirect()->route('account.contact_us')->withErrors(['هناك خطأ تقني الرجاء المحاولة لاحقا'])->withInput();
//        }

    }

    // Show All Certificates Of The User || Student
    public function certificates()
    {

        if ($this->check_authenticate()) {

            $all_certificates = Certificate::where('student_id', Auth::user()->student->id)->get();
            $tickets = $this->get_auth_tickets();
            $certificates = $this->get_auth_new_certificates();
            return view('student.certificates', compact('all_certificates', 'tickets', 'certificates'));

        } else {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
        }

    }

    // Show Course Certificate
    public function show_certificate($identifier)
    {
        if ($this->check_authenticate()) {

            $course = Course::where('identifier', $identifier)->first();

            if (empty($course)) {
                return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الدورة");
            }else {
                $certificate = Certificate::where('student_id', Auth::user()->student->id)->where('course_id', $course->id)->first();

                if (empty($certificate)) {
                    return $this->error_page("لم يتم إصدار الشهادة الرجاء التأكد من الجهة او من معرف الدورة");
                }else {
                    $tickets = $this->get_auth_tickets();
                    $certificates = $this->get_auth_new_certificates();

                    $certificate->viewed = 1;
                    $certificate->save();

                    return "You Have The Certificate";
                }
            }
        } else {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
        }
    }

    // Show The Ticket Of The Course
    public function show_course_ticket($identifier)
    {

        if ($this->check_authenticate()) {

            $check_reservation = Reservation::where('identifier', $identifier)->first();

            if (empty($check_reservation)) {
                return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز");
            }else {
                $check_reservation_confirmation = Reservation::where('identifier', $identifier)->where('confirmation', 1)->first();

                if (empty($check_reservation_confirmation)) {
                    return redirect()->route('account.ticket')->withErrors(['للأسف التذكرة ما اصدرت انتظر شوية كمان']);
                }else {
                    $reservation = Reservation::where('student_id', Auth::user()->student->id)->where('identifier', $identifier)->first();

                    $tickets = $this->get_auth_tickets();
                    $certificates = $this->get_auth_new_certificates();

                    return view('student.show-ticket', compact('tickets', 'certificates', 'reservation'));
                }
            }

        } else {
            return $this->error_page("شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس اش رايك تتاكد من صلاحياتك");
        }

    }

}
