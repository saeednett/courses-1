<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Attendance;
use App\Center;
use App\CenterAccount;
use App\City;
use App\Country;
use App\Coupon;
use App\Course;
use App\CourseAdmin;
use App\CourseTrainer;
use App\Image;
use App\Reservation;
use App\Trainer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CenterAPIController extends Controller
{
    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $response = array(
        'status' => array(),
        'errors' => array(),
        'response' => array(),
    );
    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $data = array();

    // This Function For Register New Center
    public function register(Request $request)
    {
        $request->validate([
            'center_type' => 'required|integer|max:1|min:0',
        ]);

        // type of 1 means the center is profit and need some more information
        if ($request->center_type == 1) {

            $request->validate([
                // This Part For User Account
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|digits:10|unique:users,phone|',
                'username' => 'required|string|max:20|min:5|unique:users,username',
                'password' => 'required|string|max:32|min:6|confirmed',
                // This Part For Center Account
                'name' => 'required|string|max:20|min:5|unique:centers,name',
                'country' => 'required|integer|exists:countries,id',
                'city' => 'required|integer|exists:cities,id',
                'about' => 'required|string|max:200',
                'website' => 'nullable|string|regex:/www[.]+([a-zA-z]{1,20})+[.](com|org|net|edu|biz{3})/|max:50|min:10',
                'profile-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                'verification_code' => 'required|string|max:10|min:4|unique:centers,verification_code',
                'verification_authority' => 'required|string|max:30|min:10',
                // This Part For Center Bank Account Information
                'bank' => 'required|integer|exists:banks,id',
                'account_owner' => 'required|string|max:20|min:5',
                'account_number' => 'required|digits:20|unique:center_accounts,account_number',

            ]);

        } else if ($request->center_type == 0) {

            $request->validate([
                // This Part For User Account
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|digits:10|unique:users,phone|',
                'username' => 'required|string|unique:users,username',
                'password' => 'required|string|max:32|min:6|confirmed',
                // This Part For Center Account
                'name' => 'required|string|max:20|min:5|unique:centers,name',
                'country' => 'required|integer|exists:countries,id',
                'city' => 'required|integer|exists:cities,id',
                'about' => 'required|string|max:200',
                'website' => 'nullable|string|regex:/www[.]+([a-zA-z]{1,20})+[.](com|org|net|edu|biz{3})/|max:50|min:10',
                'profile-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
            ]);

        }

        DB::beginTransaction();

        try {

            $user = User::create([
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $request->phone,
                'role_id' => 2,
                'password' => Hash::make($request->password),
            ]);

            if ($request->hasFile('profile-image')) {
                $file = $request->file('profile-image')->store('public/center-images');
                $file_name = basename($file);
                $logo = $file_name;
            }

            $center = Center::create([
                'name' => $request->name,
                'user_id' => $user->id,
                'verification_code' => $request->verification_code,
                'verification_authority' => $request->verification_authority,
                'website' => $request->website,
                'city_id' => 1,
                'about' => $request->about,
                'status' => 1,
                'logo' => $logo,
                'type' => $request->type,
            ]);

            if ($request->center_type == 1) {
                CenterAccount::create([
                    'center_id' => $center->id,
                    'bank_id' => $request->bank,
                    'account_owner' => $request->account_owner,
                    'account_number' => $request->account_number,
                ]);

            }

            DB::commit();

            $token = auth('api')->login($user);

            $this->response['response'] = array(
                'token' => $token,
                'message' => 'تم التسجيل بنجاح',
                'type' => auth('api')->user()->role->name
            );

            array_push($this->response['status'], 'Success');
            array_push($this->response['errors'], null);
            return response()->json($this->response);

        } catch (\Exception $e) {
            DB::rollback();
            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], "خطأ تقني أثناء التسجيل");
            array_push($this->response['response'], null);
            return response()->json($this->response);
        }
    }

    // This Function For Creating New Course
    public function create_course(Request $request)
    {

        // Getting Center Main Information
        $center = Center::find(auth('api')->user()->center->id);

        // Trainers Array That Will Hold Ids Of The Trainers Who Belong To The Center
        $trainers_data = array();

        // Getting Trainers Information
        $trainers = Trainer::where('center_id', auth('api')->user()->center->id)->get();

        // Making Sure That The Center Has Trainers
        if (count($trainers) < 1) {
            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], 'لايوجد مدربين مسجلين في النظام');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }
        // Fetching Trainers Data Into The Array
        foreach ($center->trainer as $trainer) {
            array_push($trainers_data, $trainer->id);
        }

        $coupon_code = 0;

        if ( !is_null($request->coupon_code) ){
            $coupon_code = $request->coupon_code;
        }

        // Validating The Request Data
        $request->validate([
            // The Title Of The Course
            'title' => 'required|string|max:50|min:10',
            // the Category Of The Course
            'category' => 'required|integer|exists:categories,id',
            // If The Course Is Visible To The Users
            'visible' => 'required|integer|max:2|min:1',
            // The Template Of The Certificate Of The Course
            'template' => 'required|integer|exists:templates,id',
            // The Country Of The City
            'country' => 'required|integer|exists:countries,id',
            // The City Of The Course
            'city' => 'required|integer|exists:cities,id|exists:cities,id',
            // The Address Of tHE Course
            'address' => 'required|string|max:150|min:10',
            // The Location The Course On Google Map
            'location' => 'required|string|max:150|min:10',
            // The Cover And Image Of The Course
            'course-image-1' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg|max:400',
            'course-image-2' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg|max:400',
            // The Description Of The Course
            'description' => 'required|string|max:200|min:10',


            //The Trainers Array Of The Course
            'trainer' => 'required|array|max:' . count($center->trainer),
            // The Trainers Array Data
            'trainer.*' => 'required|integer|distinct|' . Rule::in($trainers_data),


            // The Type Of Course Payed Or Free
            'type' => 'required|integer|max:2|min:1',
            //The Coupons Indicator Of The Coupons
            'coupon' => 'required_if:type,2|integer|max:1|min:0',
            //The Coupons Array Data
            'coupon_code' => 'required_if:coupon,1|array',
            'coupon_code.*' => 'required|string|distinct',
            'coupon_discount' => 'required_if:coupon,1|array|size:' . count($coupon_code),
            'coupon_discount.*' => 'required|integer',

            // The Start Date Of The Course
            'start_date' => 'required|date',
            // The Finish Date Of The Course
            'end_date' => 'required|date|after_or_equal:' . $request->start_date,
            // The Deadline Of Reservation
            'end_reservation' => 'required|date|before_or_equal:' . $request->start_date,
            // The Start Time Of The Course
            'start_time' => ['required', 'regex:/(^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$)/', 'string', 'max:5', 'min:5'],
            // The Total Attendance Of The Course
            'attendance' => 'required|digits_between:1,4',
            // The Price Of The Course
            'price' => 'required_if:type,2|digits_between:1,4',
            // The Attendance Gender
            'gender' => 'required|digits_between:1,3|',
            // Total Hours Of The Course
            'hours' => 'required|digits_between:1,4|',
            // The Activation of The Course
            'activation' => 'required|digits_between:0,1|',

        ]);

        DB::beginTransaction();
        try {

            if (is_null($request->price)) {
                $price = 0;
            } else {
                $price = $request->price;
            }

            if ($request->type == 1) {
                $type = 'free';
            } else {
                $type = 'payed';
            }

            if (is_null($request->coupon)) {
                $coupon = 0;
            } else {
                $coupon = $request->coupon;
            }

            // Creating The New Course
            $course = Course::create([
                'title' => $request->title,
                'identifier' => Str::random(10),
                'address' => $request->address,
                'location' => $request->location,
                'price' => $price,
                'type' => $type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'start_time' => $request->start_time,
                'end_reservation' => $request->end_reservation,
                'attendance' => $request->attendance,
                'gender' => $request->gender,
                'coupon' => $coupon,
                'hours' => $request->hours,
                'activation' => $request->activation,
                'category_id' => $request->category,
                'city_id' => $request->city,
                'template_id' => $request->template,
                'center_id' => auth('api')->user()->center->id,
                'visible' => $request->visible,
                'description' => $request->description,
                'validation' => 0,

            ]);

            // Making Sure That The Data Has A Cover And Image For The Course
            if ($request->hasFile('course-image-1') && $request->hasFile('course-image-2')) {
                $file = $request->file('course-image-1')->store('public/course-images');
                $file_name = basename($file);

                $file_2 = $request->file('course-image-1')->store('public/course-images');
                $file_name_2 = basename($file_2);

                Image::create([
                    'image' => $file_name,
                    'image_2' => $file_name_2,
                    'course_id' => $course->id,
                ]);
            }

            // Storing The Course Trainers
            for ($i = 0; $i < count($request->trainer); $i++) {
                CourseTrainer::create([
                    'course_id' => $course->id,
                    'trainer_id' => $request->trainer[$i],
                ]);
            }

            // Storing The Course Coupons If The Type Is Payed
            if ($request->coupon == 2) {
                for ($i = 0; $i < count($request->coupon_code); $i++) {
                    Coupon::create([
                        'code' => $request->coupon_code[$i],
                        'discount' => $request->coupon_discount[$i],
                        'course_id' => $course->id,
                    ]);
                }
            }

            // Save The Changes If The Is No Errors
            DB::commit();

            array_push($this->response['status'], 'Success');
            array_push($this->response['errors'], null);
            array_push($this->response['response'], '');

            return response()->json($this->response);
        } catch (\Exception $e) {

            DB::rollBack();

            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], 'خطأ تقني أثناء إضافة الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);

        }
    }

    // This Function For Editing One Course
    public function edit_course(Request $request, $identifier)
    {

    }

    // This Function For Updating One Course
    public function update_course(Request $request, $identifier)
    {

    }

    // This Function For Creating New Admin
    public function create_admin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|min:6|unique:admins,name',
            'username' => 'required|string|max:20|:min:5|unique:users,username',
            'phone' => 'required|max:9|min:9|unique:users,phone',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|max:32|min:6|confirmed',
            'profile-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
        ]);

        DB::beginTransaction();

        try {

            $user = User::create([
                'username' => $request->username,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 3,
            ]);

            $file = $request->file('profile-image')->store('public/admin-images');
            $file_name = basename($file);

            Admin::create([
                'name' => $request->name,
                'user_id' => $user->id,
                'center_id' => Auth::user()->center->id,
                'image' => $file_name,
                'status' => $request->status,
            ]);

            DB::commit();

            array_push($this->response['status'], 'Success');
            array_push($this->response['errors'], null);
            array_push($this->response['response'], 'تم إضافة المدير بنجاح');

            return response()->json($this->response);


        } catch (\Exception $e) {
            DB::rollback();
            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], 'خطأ تقني أثناء إضافة لمدير');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }
    }

    // This Function For Creating New Trainer
    public function create_trainer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|min:5|unique:trainers,name',
            'username' => 'required|string|max:20|:min:5|unique:users,username',
            'phone' => 'required|max:9|min:9|unique:users,phone',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|max:32|min:6|confirmed',
            'title' => 'required|integer|exists:titles,id',
            'nationality' => 'required|integer|exists:nationalities,id',
            'profile-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
        ]);

        DB::beginTransaction();

        try {

            $user = User::create([
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $request->phone,
                'role_id' => 4,
                'password' => Hash::make($request->password),
            ]);

            $file = $request->file('profile-image')->store('public/trainer-images');
            $file_name = basename($file);

            Trainer::create([
                'name' => $request->name,
                'user_id' => $user->id,
                'center_id' => Auth::user()->center->id,
                'title_id' => $request->title,
                'nationality_id' => $request->nationality,
                'image' => $file_name,
            ]);

            DB::commit();

            array_push($this->response['status'], 'success');
            array_push($this->response['errors'], null);
            array_push($this->response['response'], 'تم إضافة المدرب بنجاح');

            return response()->json($this->response);

        } catch (Exception $e) {
            DB::rollback();
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'خطأ تقني أثناء إضافة المدرب');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }
    }

    // This Function For Taking Attendance For One Student And One Course Course
    public function take_attendance(Request $request)
    {
        $course = Course::where('identifier', $request->identifier)->where('center_id', auth('api')->user()->center->id)->get();

        if (count($course) < 1) {
            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], 'الرجاء التأكد من معرف الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        $students_data = Reservation::where('course_id', $course->id)->where('confirmation', 1)->get();
        $students = array();

        foreach ($students_data as $student) {
            array_push($students, $student->id);
        }

        $date = array();
        $date1 = date_create($course->start_date);
        $date2 = date_create($course->finish_date);
        $diff = date_diff($date1, $date2);
        $days = $diff->format("%a");

        for ($i = 0; $i < $days; $i++) {
            array_push($date, date('Y-m-d', strtotime($course->start_date . " +$i Day ")));
        }

        $request->validate([
            'date' => 'required|date|' . Rule::in($date),
            'identifier' => 'required|max:10|min:10',
            'student' => 'required|integer|' . Rule::in($students),
            'attendance' => 'required|integer|max:1|min:0',
        ]);

        $attendance = Attendance::where('date', $request->date)->where('student_id', $request->student)->where('course_id', $course->id)->first();

        if (!empty($attendance)) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'تم تحضير الطالب لهذا اليوم');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {
            Attendance::create([
                'date' => $request->date,
                'course_id' => $course->id,
                'student_id' => $request->student,
                'admin_id' => 0,
                'status' => 1,
            ]);

            array_push($this->response['status'], 'Success');
            array_push($this->response['errors'], null);
            array_push($this->response['response'], 'تم تحضير الطالب بنجاح');

            return response()->json($this->response);
        }
    }

    // This Function Show The Attendance Of A Specific Date
    public function show_attendance(Request $request)
    {

        $request->validate([
            'identifier' => 'required|string|max:10|min:10',
        ]);

        $course = Course::where('identifier', $request->identifier)->where('center_id', auth('api')->center->id)->first();

        if (empty($course)) {
            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], 'الرجاء التأكد من معرف الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }


        if ( count($course->reservation) < 1 ){
            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], 'لايوجد اي حجز لهذه الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        $date = array();

        $date1 = date_create($course->start_date);
        $date2 = date_create($course->finish_date);
        $diff = date_diff($date1, $date2);
        $days = $diff->format("%a");

        for ($i = 0; $i < $days; $i++) {
            array_push($date, date('Y-m-d', strtotime($course->start_date . " +$i Day ")));
        }

        $request->validate([
            'date' => 'required|date' . Rule::in($date),
        ]);

        $attendances = Attendance::where('date', $request->date)->where('course_id', $course->id)->get();

        if (count($attendances) < 1) {
            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], 'لم يتم تحضير اي طالب لهذا التاريخ');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {

            foreach ($attendances as $attendance) {

                if ( $attendance->admin == 0 ){
                    $subData = array(
                        'student_id' => $attendance->studentid,
                        'student' => $attendance->student->first_name . " " . $attendance->student->second_name. " ". $attendance->student->third_name,
                        'date' => $attendance->date,
                        'admin' => "Center Administrator",
                    );
                }else {
                    $subData = array(
                        'student_id' => $attendance->studentid,
                        'student' => $attendance->student->first_name . " " . $attendance->student->second_name. " ". $attendance->student->third_name,
                        'date' => $attendance->date,
                        'admin' => $attendance->admin->name,
                    );
                }

                array_push($this->data, $subData);
            }
            array_push($this->response['status'], 'success');
            array_push($this->response['errors'], null);
            array_push($this->response['response'], $this->data);

            return response()->json($this->response);
        }

    }

    // This Function Retrieve Courses And Admins To Assign
    public function retrieve_courses()
    {
        $courses = Course::where('center_id', auth('api')->user()->center->id)->get();

        if (count($courses) < 1) {
            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], 'لاتوجد دورات مسجلة في النظام');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {

            $this->data['admins'] = array();

            $admins = Admin::where('center_id', auth('api')->user()->center->id)->get();

            foreach ($admins as $admin) {
                $subData = array(
                    'id' => $admin->id,
                    'name' => $admin->name,
                );
                array_push($this->$this->data['admins'], $subData);
            }

            $this->data['courses'] = array();

            foreach ($courses as $course) {
                $subData = array(
                    'id' => $course->id,
                    'title' => $course->title,
                );
                array_push($this->$this->data['courses'], $subData);
            }

            array_push($this->response['status'], 'Success');
            array_push($this->response['errors'], null);
            array_push($this->response['response'], $this->data);

            return response()->json($this->response);
        }
    }

    // This Function For Assigning Admin To One Course
    public function assign_admin(Request $request)
    {

        $request->validate([
            'identifier' => 'required|integer|max:10|min:10|exists:courses,identifier',
        ]);

        $course = Course::where('identifier', $request->identifier)->where('center_id', auth('api'))->first();

        if ( empty($course) ){
            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], 'الرجاء التأكد من معرف الدورة');
            array_push($this->response['response'], null);
        }

        $admins = Admin::where('center_id', auth('api')->user()->center->id)->get();

        if ( count($admins) < 1 ){
            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], 'الرجاء التأكد من وجود مسؤولين مسجلين في النظام');
            array_push($this->response['response'], null);
        }

        $admin_data = array();
        foreach ($admins as $admin) {
            array_push($admin_data, $admin->id);
        }


        $check = CourseAdmin::where('course_id', $request->course)->where('admin_id', $request->admin)->first();

        if (!empty($check)) {
            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], 'تم تعيين هذا المسؤول لهذه الدورة مسبقا');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        $request->validate([
            'identifier' => 'required|integer|max:10|min:10|exists:courses,identifier',
            'admin' => 'required|integer|' . Rule::in($admin_data),
            'role' => 'required|integer|max:2|min:1',
        ]);


        CourseAdmin::create([
            'course_id' => $course->id,
            'admin_id' => $request->admin,
            'role_id' => $request->role,
        ]);

        array_push($this->response['status'], 'Success');
        array_push($this->response['errors'], null);
        array_push($this->response['response'], 'تم تعيين المسؤول بنجاح');

        return response()->json($this->response);
    }

    // This Function For Confirming Payments For One Course
    public function confirm_payment(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string|max:10|min:10|exists:courses,identifier',
            'student' => 'required|integer|exists:students,id',
            'confirmation' => 'required|integer|max:1|min:0',
        ]);

        $course = Course::where('identifier', $request->identifier)->where('center_id', auth('api')->user()->center->id)->get();
        $reservation = Reservation::where('student', $request->student)->where('course_id', $course->id)->first();

        if (empty($reservation)) {
            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], 'لايوجد حجز لهذا الطالب');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {

            if ($reservation->confirmation == 1) {
                $reservation->confirmation = 1;
                $reservation->save();

                array_push($this->response['status'], 'Failed');
                array_push($this->response['errors'], null);
                array_push($this->response['response'], 'تم تأكيد الحجز مسبقا');

                return response()->json($this->response);
            } else {
                $reservation->confirmation = 1;
                $reservation->save();

                array_push($this->response['status'], 'Success');
                array_push($this->response['errors'], null);
                array_push($this->response['response'], 'تم تأكيد الحجز');

                return response()->json($this->response);
            }
        }
    }

    // This Function For Showing The Details Of Confirming The Payments
    public function show_payment_confirmation(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string|exists:courses,identifier',
        ]);

        $course = Course::where('center_id', auth('api')->user()->center->id)->where('identifier', $request->identifier)->first();

        if (empty($course)) {
            array_push($this->response['status'], 'Failed');
            array_push($this->response['errors'], 'الرجاء التأكد من معرف الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        } else {
            $reservations = Reservation::where('course_id', $course->id)->get();

            foreach ($reservations as $reservation) {
                $subData = array(
                    'student_id' => $reservation->student->id,
                    'student' => $reservation->student->first_name . " " . $reservation->student->second_name. " ".$reservation->student->third_name,
                    'confirmation' => $reservation->confirmation,
                );

                array_push($this->data, $subData);
            }


            array_push($this->response['status'], 'Success');
            array_push($this->response['errors'], null);
            array_push($this->response['response'], $this->data);

            return response()->json($this->response);
        }
    }

    // This Function To Show The Personal Data
    public function me()
    {
        $user = User::find(auth('api')->user()->center->user_id);
        if ($user->center->type == 1) {

            $this->data = [
                'name' => $user->center->name,
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone,
                'verification_code' => $user->center->verification_code,
                'verification_authority' => $user->center->verification_authority,
                'website' => $user->center->website,
                'profile-image' => "/storage/center-images/" . $user->center->logo,
                'type' => $user->center->type,
                'about' => $user->center->about,
            ];

        } else {

            $this->data = [
                'name' => $user->center->name,
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone,
                'profile-image' => "/storage/center-images/" . $user->center->logo,
                'type' => $user->center->type,
                'about' => $user->center->about,
            ];

        }

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
        array_push($this->response['response'], "Logged Out Successfully");

        return response()->json($this->response);
    }

    // This Function For Refreshing The Old Token And Replace It With A New One
    public function refresh()
    {
        array_push($this->response['status'], 'Success');
        array_push($this->response['errors'], null);
        array_push($this->response['response'], $this->respondWithToken(auth('api')->refresh()));

        return response()->json($this->response);
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
