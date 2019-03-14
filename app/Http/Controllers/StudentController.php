<?php

namespace App\Http\Controllers;

use App\AdvertisingBanner;
use App\CenterAccount;
use App\City;
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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class StudentController extends Controller
{

    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $response = array(
        'status' => array(),
        'errors' => array(),
        'response' => array(),
    );
    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $data = array();

    private function get_auth_tickets()
    {
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

        return $tickets;
    }

    // This Function Return All Courses
    private function all_curses()
    {
        // Getting The Visible Courses
        $courses = Course::where('visible', 1)->where('activation', 1)->get();

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
        $courses = Course::where('visible', 1)->where('type', 'payed')->where('activation', 1)->get();

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
        $courses = Course::where('visible', 1)->where('type', 'free')->where('activation', 1)->get();

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
        $courses = Course::where('visible', 1)->where('activation', 1)->get();
        // Getting The Reservation Of The Course To Count The Remain Places
        $courses_data = array();
        foreach ($courses as $course) {
            if (count($course->reservation) < $course->attendance) {
                array_push($courses_data, $course->id);
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
        // Getting All Advertising Banners To Show Them In The Index Page
        $banners = AdvertisingBanner::all();
        if (Auth::check() && Auth::user()->role_id == 5) {

            // Save The Total Count
            $tickets = $this->get_auth_tickets();
            // Getting The Visible Courses
            $courses = Course::where('visible', 1)->get();
            return view('student.index', compact('courses', 'tickets', 'banners'));
        } else {
            // Getting The Visible Courses
            $courses = Course::where('visible', 1)->where('activation', 1)->get();
            return view('student.index', compact('courses', 'banners'));
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
        // Logging In The New User And Redirect Him To The Index
        auth()->login($student);
        // Redirect To The Index After Creating And Logging In
        return redirect()->route('account.index');
    }

    // Unused Function
    public function show($id)
    {
        //
    }

    // To Show Course Details Before Reserving It
    public function show_course($center, $identifier)
    {

        $tickets = $this->get_auth_tickets();

        // Checking The Username Of The Center
        $center = User::where('username', $center)->first();
        // If The Username Is Wrong
        if (count($center) < 1) {
            $error = "شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من اسم الجهة";
            return view('student.error-page', compact('error', 'tickets'));
        }

        // Checking The Course Unique Identifier
        $course = Course::where('identifier', $identifier)->where('activation', 1)->first();
        // If The Identifier Is Wrong
        if (count($course) < 1) {
            $error = "شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الدورة";
            return view('student.error-page', compact('error', 'tickets'));
        }

        // Checking If The User Is Authenticated And His Role Is 5 That Mean He Is A User
        if (Auth::check() && Auth::user()->role_id == 5) {
            // Return The View Of The Details
            return view('student.show-course-details', compact('course', 'tickets'));
        } else {

            $course = Course::where('identifier', $identifier)->where('activation', 1)->first();

            if (count($course) < 1) {
                $error = "شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الدورة";
                return view('student.error-page', compact('error', 'tickets'));
            }
            return view('student.show-course-details', compact('course'));

        }

    }

    // To Show Final Step Before Reserving The Course
    public function reservation_course_form($identifier)
    {
        // Checking The Course Unique Identifier
        $course = Course::where('identifier', $identifier)->where('activation', 1)->first();

        $tickets = $this->get_auth_tickets();

        // If The Identifier Is Wrong
        if (count($course) < 1) {
            $error = "شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الدورة";
            return view('student.error-page', compact('error', 'tickets'));
        }

        // Getting All Center Bank Accounts
        $accounts = CenterAccount::where('center_id', $course->center->id)->get();
        // Return The View Of Booking The Course
        return view('student.reserve-course', compact('course', 'accounts', 'tickets'));

    }

    // The Data Of Reservation Goes Here And The Process Happens Here
    public function course_reservation_confirm(Request $request, $identifier)
    {

        // Getting The Course Information
        $course = Course::where('identifier', $identifier)->where('activation', 1)->first();

        $tickets = $this->get_auth_tickets();

        // Making Sure The Course Is Exist
        if (count($course) < 1) {
            $error = "شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الدورة";
            return view('student.error-page', compact('error', 'tickets'));
        }

        $reserve = Reservation::where('course_id', $course->id)->where('student_id', Auth::user()->student->id)->first();
        if (count($reserve) > 0) {
            return redirect()->route('account.ticket')->withErrors(['تم حجز الدورة مسبقا']);
        }


        // Validating The Request Data
        $request->validate([
            'coupon_code' => 'nullable|string|min:3|max:30',
        ]);

        // Getting The Coupons Of The Course
        $coupon = Coupon::where('code', $request->coupon_code)->where('course_id', $course->id)->first();
        // Check If The User Coupon Is Exist
        if (count($coupon) < 1) {
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

    // To Edit The Information Of The Student
    public function edit()
    {
        // Getting The Information Of The Student
        $user = User::find(Auth::user()->id);
        // Getting All Cites
        $cities = City::where('country_id', $user->student->city->country->id)->get();
        // Getting All Countries
        $countries = Country::all();
        // Get All Reservations To Filter It
        $reservations = Reservation::where('student_id', Auth::user()->student->id)->get();
        // To Filter The Reservation That Is Not Confirmed
        $tickets_data = array();
        foreach ($reservations as $reservation) {
            if ($reservation->course->start_date > date('Y-m-d') && $reservation->confirmation == 0 && is_null($reservation->payment)) {
                array_push($tickets_data, $reservation->id);
            }
        }
        // Save The Total Count
        $tickets = count($tickets_data);
        // Return To The View Of Editing The Information
        return view('student.edit-account', compact('user', 'countries', 'cities', 'tickets'));
    }

    // the Data Of Editing Information Goes Here And The Process Happens Here
    public function update(Request $request)
    {
        // Getting All Cities Which Belongs To The Country That The User | Student Chose
        $cities = City::where('country_id', $request->country)->get();
        // Checking If The Country Id Is Valid
        if (count($cities) < 1) {
            abort(404);
        }
        // An Empty Array Of City Will Be Filled Soon
        $cities_data = array();
        // Fetching The Cities Data Into The Array
        foreach ($cities as $city) {
            array_push($cities_data, $city->id);
        }
        // Validating The Request Data
        $request->validate([
            'first_name' => 'required|string|max:10|min:6',
            'second_name' => 'required|string|max:10|min:6',
            'third_name' => 'required|string|max:10|min:6',
            'last_name' => 'required|string|max:10|min:6',
            'phone' => 'required|starts_with:+966|string|max:9|min:9|' . Rule::unique('users')->ignore(Auth()->user()->id),
            'email' => 'required|string|max:100|' . Rule::unique('users')->ignore(Auth()->user()->id),
            'username' => 'required|string|max:20:min:5|' . Rule::unique('users')->ignore(Auth()->user()->id),
            'city' => 'required|digits:1,99|exists:cities,id|' . Rule::in($cities_data),
            'country' => 'required|exists:countries,id',
            'gender' => 'required|integer|exists:genders,id',
            'year' => 'required|integer|max:2019|min:1930',
            'month' => 'required|integer|max:12|min:1',
            'day' => 'required|integer|max:31|min:1',
            'profile-image' => 'sometimes|image|mimetypes:image/png,image/jpg,image/jpeg||max:400'
        ]);
        // The Id Of User | Student
        $id = Auth::user()->id;
        // Getting The SubInformation Of The User | Student
        $student = Student::where('user_id', $id)->first();
        // This Counter Will Increase If Any New Data Is Different To The Old One
        $counter = 0;
        // Comparing The First Name Old Data To The New
        if ($student->first_name != $request->first_name) {
            $student->first_name = $request->first_name;
            $counter++;
        }
        // Comparing The Second Name Old Data To The New
        if ($student->second_name != $request->second_name) {
            $student->second_name = $request->second_name;
            $counter++;
        }
        // Comparing The Third Name Old Data To The New
        if ($student->third_name != $request->third_name) {
            $student->third_name = $request->third_name;
            $counter++;
        }
        // Comparing The Last Name Old Data To The New
        if ($student->last_name != $request->last_name) {
            $student->last_name = $request->last_name;
            $counter++;
        }
        // Comparing Phone Old Data To The New
        if ($student->user->phone != $request->phone) {
            $student->user->phone = $request->phone;
            $counter++;
        }
        // Comparing Email Old Data To The New
        if ($student->user->email != $request->email) {
            $student->user->email = $request->email;
            $counter++;
        }
        // Comparing Username Old Data To The New
        if ($student->user->username != $request->username) {
            $student->user->username = $request->username;
            $counter++;
        }
        // Comparing City Old Data To The New
        if ($student->city_id != $request->city) {
            $student->city_id = $request->city;
            $counter++;
        }

        // Comparing Year Old Data To The New
        if ($student->year != $request->year) {
            $student->year = $request->year;
            $counter++;
        }

        // Comparing Month Old Data To The New
        if ($student->month != $request->month) {
            $student->month = $request->month;
            $counter++;
        }

        // Comparing Day Old Data To The New
        if ($student->day != $request->day) {
            $student->day = $request->day;
            $counter++;
        }

        // Comparing Gender Old Data To The New
        if ($student->gender_id != $request->gender) {
            $student->gender_id = $request->gender;
            $counter++;
        }
        // Checking If The Request Has An Image
        if ($request->hasFile('profile-image')) {
            $counter++;
            if (File::exists('public/account-images/' . $student->url)) {
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
        }
        // Checking If The Counter Is Greater Than 0 Then Do The Update
        if ($counter > 0) {
            $student->save();
            $student->user->save();
            return redirect()->route('account.edit')->with('success', 'تم تحديث البيانات بنجاح');
        } else {
            return redirect()->route('account.edit')->withErrors(['لاتوجد بيانات جديدة لكي يتم حفظها']);
        }

    }

    // Unused Function
    public function destroy($id)
    {
        //
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
        // Getting All Reservation For The User | Student
        $reservations = Reservation::where('student_id', Auth::user()->student->id)->get();
        $tickets = $this->get_auth_tickets();

        // Returning The View Of The Tickets
        return view('student.tickets', compact('reservations', 'tickets'));
    }

    // To Show All Tickets Of The User | Student By Filter
    private function all_tickets()
    {
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
    }

    // To Show All The Finished Tickets Of The User | Student By Filter
    private function finished_tickets()
    {
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
    }

    // To Show All The Confirmed Tickets Of The User | Student By Filter
    private function confirmed_tickets()
    {
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
    }

    // To Show All The Unconfirmed Tickets Of The User | Student By Filter
    private function unconfirmed_tickets()
    {
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
    public function payment_confirmation(Request $request, $identifier)
    {

        // The Reservation That Wanted To Be Confirmed
        $reservation = Reservation::where('identifier', $identifier)->where('student_id', Auth::user()->student->id)->first();

        $tickets = $this->get_auth_tickets();

        // Checking If The Reservation iIs Exist
        if (count($reservation) < 1) {
            $error = "شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز";
            return view('student.error-page', compact('error', 'tickets'));
        }

        if ($reservation->course->start_date < date("Y-m-d")) {
            $error = "شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز او من تاريخ الحجز";
            return view('student.error-page', compact('error', 'tickets'));
        }

        $tickets = $this->get_auth_tickets();

        return view('student.payment-confirmation', compact('reservation', 'tickets'));
    }

    // The Data Of Confirmation Goes Here And The Process Happens Here
    public function confirm(Request $request, $identifier)
    {

        // Getting The Reservation Of The User | Student
        $reservation = Reservation::where('identifier', $identifier)->where('student_id', Auth::user()->student->id)->first();
        $tickets = $this->get_auth_tickets();

        // Checking If The Reservation iIs Exist
        if (count($reservation) < 1) {
            $error = "شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز";
            return view('student.error-page', compact('error', 'tickets'));
        }

        if ($reservation->course->start_date < date("Y-m-d")) {
            $error = "شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز او من تاريخ الحجز";
            return view('student.error-page', compact('error', 'tickets'));
        }

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

    // To Show The Form Of Editing The Payment Confirmation
    public function edit_payment_confirmation_form($identifier)
    {

        // The Confirmation That Will Be Edit
        $reservation = Reservation::where('identifier', $identifier)->where('student_id', Auth::user()->student->id)->first();

        $tickets = $this->get_auth_tickets();

        // Checking If The Reservation Is Exist
        if (count($reservation) < 1) {
            $error = "شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز";
            return view('student.error-page', compact('error', 'tickets'));
        }

        if ($reservation->course->start_date < date("Y-m-d")) {
            $error = "شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز او من تاريخ الحجز";
            return view('student.error-page', compact('error', 'tickets'));
        }

        return view('student.edit-payment-confirmation', compact('reservation', 'tickets'));
    }

    // The Data Of Editing The Payment Confirmation Goes Here And The Process Happens Here
    public function update_payment_confirmation(Request $request, $identifier)
    {
        // Getting The Reservation That Will Be Edit
        $reservation = Reservation::where('identifier', $identifier)->where('student_id', Auth::user()->student->id)->first();

        $tickets = $this->get_auth_tickets();

        if (count($reservation) < 1) {
            $error = "شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز";
            return view('student.error-page', compact('error', 'tickets'));
        }


        if ($reservation->course->start_date < date("Y-m-d")) {
            $error = "شكلك ضايع وماتعرف فين تبغا ارجع الصفحة الرئسية ولاتحوس او حاول تتاكد من معرف الحجز او من تاريخ الحجز";
            return view('student.error-page', compact('error', 'tickets'));
        }

        // Validating The Request Data
        $request->validate([
            'account_owner' => 'string|max:50|min:10',
            'account_number' => 'max:30|min:10',
            'receipt-image' => 'image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
        ]);

        // Getting The Old payment Confirmation Data
        $payment = PaymentConfirmation::where('reservation_id', $reservation->id)->first();
        // Checking If The Request Has An Image
        if ($request->hasFile('receipt-image')) {
            $file = $request->file('receipt-image')->store('public/receipt-images');
            $file_name = basename($file);
        }
        // This Counter Will Be Increase If The New Data Is Different To The Old
        $counter = 0;
        // This Variable Will Change If The Is A New File With The Request
        $file_name = null;
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
        if ($counter > 0) {
            $payment->update();
            return redirect()->route('account.ticket')->with('success', 'تم تعديل معلومات الدفع سيتم اصدار التذكرة بعد التأكدة من صحة معلومات الدفع');
        }
        // Comparing The Old Account Owner With New
        return redirect()->route('student.payment.confirmation.edit', $reservation->identifier)->withErrors(['لم يتم تعديل المعلومات']);

    }

    // To Show The Form Of Resetting The Password
    public function create_reset_password()
    {
        $tickets = $this->get_auth_tickets();
        return view('student.account-reset-password', compact('tickets'));
    }

    // The Data Of Resetting Password Goes Here And The Process Happens Here
    public function reset_password(Request $request)
    {
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
                return redirect()->route('account.password')->withErrors('لا يمكن استخدام نفس كلمة المرور القديمة');
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
    }
}
