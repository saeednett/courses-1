<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Category;
use App\City;
use App\Country;
use App\Coupon;
use App\CourseTrainer;
use App\Trainer;
use App\User;
use App\Course;
use App\Center;
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

                if (count($course_admin_data) > 0) {

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
    public function show_courses_for_payment_confirmation($identifier)
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
    public function payment_confirmation_confirm(Request $request, $identifier)
    {

        $course = Course::where('identifier', $identifier)->first();

        if (count($course) == 0) {
            abort(404);
        }

        $reservations_data = Reservation::where('course_id', $course->id)->get();

        $students = array();
        $identifiers = array();

        foreach ($reservations_data as $reservation) {
            array_push($students, $reservation->student_id);
            array_push($identifiers, $reservation->identifier);
        }

//        dd($students);

        $request->validate([
            'student' => 'required|array|max:' . count($students),
            'student.*' => 'required|integer|' . Rule::in($students),
            'payment' => 'required|array|size:' . count($students),
            'payment.*' => 'required|integer|max:1|min:0',
            'identifier' => 'required|array|max:' . count($students) . 'size:' . count($students),
            'identifier.*' => 'required|string|max:10|min:10|' . Rule::in($identifiers),
        ]);

        $counter = 0;

        for ($i = 0; $i < count($students); $i++) {
            if ($request->payment[$i] == 1) {
                $reservation = Reservation::where('student_id', $students[$i])->where('identifier', $identifiers[$i])->first();
                $reservation->confirmation = 1;
                $reservation->save();
                $counter++;
            }
        }

        if ($counter == 0) {
            return redirect()->route('admin.courses.payment', $identifier)->withErrors(['الزجاء قم بتحديث بعض البيانات لكي يتم حفظها']);
        }
        return redirect()->route('admin.courses.payment', $identifier)->with('success', 'تم تأكيد الدفع بنجاح');
    }

    // To Show All Course
    public function show_courses()
    {
        $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();

        $course_admin = array();
        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

            if (count($course_admin_data) > 0) {

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
    public function courses_payment_show()
    {
        $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();

        $course_admin = array();
        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

            if (count($course_admin_data) > 0) {

                if ($course_admin_data->role_id == 1) {
                    array_push($course_admin, $course_admin_data->course_id);
                } else {
                    array_push($course_attender, $course_admin_data->course_id);
                }

            }

        }

        $course_admin = count($course_admin);
        $course_attender = count($course_attender);
        return view('admin.all-courses-payment', compact('courseAdmin', 'course_admin', 'course_attender'));
    }

    // To Show The Table Of All Courses That Will Show Their Student Who Are Registered
    public function show_courses_for_show_student()
    {
        $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();

        $course_admin = array();
        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

            if (count($course_admin_data) > 0) {

                if ($course_admin_data->role_id == 1) {
                    array_push($course_admin, $course_admin_data->course_id);
                } else {
                    array_push($course_attender, $course_admin_data->course_id);
                }

            }

        }

        $course_admin = count($course_admin);
        $course_attender = count($course_attender);
        return view('admin.all-courses-students', compact('courseAdmin', 'course_admin', 'course_attender'));
    }

    // To Show One Course Student
    public function show_course_students($identifier)
    {
        $course = Course::where('identifier', $identifier)->first();

        if (count($course) == 0) {
            abort(404);
        }

        $admin_courses = CourseAdmin::where('admin_id', Auth::user()->admin->id)->get();
        $courses_identifiers = array();

        foreach ($admin_courses as $course) {
            array_push($courses_identifiers, $course->course->identifier);
        }

        if (!in_array($identifier, $courses_identifiers)) {
            abort(404);
        }

        $reservations = Reservation::where('course_id', $course->id)->get();


//        $course_admin = array();
//        $course_attender = array();
//        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();
//
//        for ($i = 0; $i < count($courses_data); $i++) {
//
//            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();
//
//            if (count($course_admin_data) > 0) {
//
//                if ($course_admin_data->role_id == 1) {
//                    array_push($course_admin, $course_admin_data->course_id);
//                } else {
//                    array_push($course_attender, $course_admin_data->course_id);
//                }
//
//            }
//
//        }
//        $course_admin = count($course_admin);
//        $course_attender = count($course_attender);


        return view('admin.show-course-students', compact('course', 'reservations'));
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

            if (count($course_admin_data) > 0) {

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
        $admin = User::find(Auth::user()->admin->user_id);
        if ($admin->name != $request->name) {
            $request->validate([
                'name' => 'required|string|max:50|min:7',
            ]);
            $counter++;
        }

        if ($admin->phone != $request->phone) {
            $request->validate([
                'phone' => 'required|string|max:20|min:10|starts_with:+',
            ]);
            $admin->phone = $request->phone;
            $counter++;
        }

        if ($admin->email != $request->email) {
            $request->validate([
                'email' => 'required|string|max:50|min:7',
            ]);
            $admin->email = $request->email;
            $counter++;
        }

        if ($admin->username != $request->username) {
            $request->validate([
                'username' => 'required|string|max:20|unique:users,username',
            ]);
            $admin->username = $request->username;
            $counter++;
        }

        // Checking If The Request Has An Image
        if ($request->hasFile('profile-image')) {
            if (File::exists('storage/admin-images/', $admin->admin->image)) {
                if (Storage::delete('public/admin-images/' . $admin->admin->image)) {
                    $file = $request->file('profile-image')->store('public/admin-images');
                    $file_name = basename($file);
                    $admin->admin->image = $file_name;
                }
            }
            $counter++;
        }

        if ($counter == 0) {
            return redirect()->route('admin.edit')->withErrors(['min-error' => 'الرجاء قم بتحديث بعض الحقول لكي يتم حفظها', 'name' => ' ', 'email' => ' ', 'phone' => ' ', 'username' => ' ', 'profile-image' => ' ']);
        }
        $admin->save();
        $admin->admin->save();
        return redirect()->route('admin.edit')->with('success', 'تم تحديث البيانات الشخصية بنجاح');
    }

    //
    public function reset_password()
    {
        $admin = User::find(Auth::user()->admin->user_id);

        $course_admin = array();
        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

            if (count($course_admin_data) > 0) {

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
    public function reset_password_confirm(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string|max:32|min:8',
            'password' => 'required|string|max:32|min:8',
            'password_confirmation' => 'required|string|same:password',
        ]);

        $admin = User::find(Auth::user()->admin->user_id);

        if (!Hash::check($request->old_password, $admin->password)) {
            return redirect()->route('admin.reset.password')->withErrors(['old_password' => ['كلمة المرور القديمة غير صحيحة']]);
        }

        if (Hash::check($request->password, $admin->password)) {
            return redirect()->route('admin.reset.password')->withErrors(['password' => ['الرجاء اختيار كلمة مرور اخرى غير الحالية']]);
        }

        $admin->password = Hash::make($request->password);
        $admin->save();
        return redirect()->route('admin.reset.password')->with('success', 'تم تغير كلمة النرور بنجاح');

    }

    // To Show The Form Of Editing Course
    public function course_edit($identifier)
    {

        $course = Course::where('identifier', $identifier)->first();

        if (count($course) < 1) {
            abort(404);
        }

        $admin_courses = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('role_id', 1)->where('course_id', $course->id)->first();

        if (count($admin_courses) < 1) {
            abort(404);
        }

        $categories = Category::all();
        $cities = City::all();
        $countries = Country::all();
        $trainers = Trainer::where('center_id', Auth::user()->admin->center->id)->get();
        return view('admin.edit-course', compact('course', 'categories', 'countries', 'cities', 'trainers'));
    }

    // The Data Of Editing Course Goes Here And The Process Happens Here
    public function course_update(Request $request, $id)
    {
        $courseAdmin = CourseAdmin::where('course_id', $id)->where('role_id', 1)->where('admin_id', Auth::user()->admin->id)->first();
        if (count($courseAdmin) < 1) {
            abort(404);
        }

        $course = Course::find($id);

        // Getting Center Main Information
        $center = Center::find(Auth::user()->admin->center->id);
        // Trainers Array That Will Hold Ids Of The Trainers Who Belong To The Center
        $trainers_data = array();
        // Getting Trainers Information
        $trainers = Trainer::where('center_id', Auth::user()->admin->center->id)->get();

        // Making Sure That The Center Has Trainers
        if (count($trainers) < 1) {
            abort(404);
        }
        // Fetching Trainers Data Into The Array
        foreach ($center->trainer as $trainer) {
            array_push($trainers_data, $trainer->id);
        }

        $counter = 0;
        // Validating The Request Data
        $request->validate([
            // The Title Of The Course
            'title' => 'required|string|max:50|min:10',
            // the Category Of The Course
            'category' => 'required|integer|max:99|min:1|exists:categories,id',
            // If The Course Is Visible To The Users
            'visible' => 'required|integer|max:2|min:1',
            // The Template Of The Certificate Of The Course
            'template' => 'required|integer|max:3|min:1',
            // The Country Of The City
            'country' => 'required|integer|max:99|min:1|exists:countries,id',
            // The City Of The Course
            'city' => 'required|integer|max:99|min:1|exists:cities,id',
            // The Address Of tHE Course
            'address' => 'required|string|max:150|min:10',
            // The Location The Course On Google Map
            'location' => 'required|string|max:150|min:20',
            // The Cover And Image Of The Course
            'course-poster-1' => 'nullable|image|mimetypes:image/png,image/jpg,image/jpeg|max:500',
            'course-poster-2' => 'nullable|image|mimetypes:image/png,image/jpg,image/jpeg|max:500',
            // The Description Of The Course
            'description' => 'required|string|max:200|min:50',


            //The Trainers Array Of The Course
            'trainer' => 'required|array|max:' . count($center->trainer),
            // The Trainers Array Data
            'trainer.*' => 'required|integer|distinct|' . Rule::in($trainers_data),

            // The Type Of Course Payed Or Free
            'type' => 'required|string|' . Rule::in(['payed', 'free']),
            //The Coupons Indicator Of The Coupons
            'coupon' => 'required_if:type,payed|integer|max:1|min:0',
            //The Coupons Array Data
            'coupon_code' => 'required_if:coupon,2|array',
            'coupon_code.*' => 'required|string|distinct',
            'coupon_discount' => 'required_if:coupon,2|array|size:' . count($request->coupon_code),
            'coupon_discount.*' => 'required|integer',

            // The Start Date Of The Course
            'start_date' => 'required|date|after_or_equal:' . date('Y-m-d'),
            // The Finish Date Of The Course
            'finish_date' => 'required|date|after_or_equal:' . $request->start_date,
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

        ]);

        if ($course->title != $request->title) {
            $course->title = $request->title;
            $counter++;
        }

        if ($course->category_id != $request->category) {
            $course->category_id = $request->category;
            $counter++;
        }

        if ($course->visible != $request->visible) {
            $course->visible = $request->visible;
            $counter++;
        }

        if ($course->template_id != $request->template) {
            $course->template_id = $request->template;
            $counter++;
        }

        if ($course->city_id != $request->city) {
            $course->city_id = $request->city;
            $counter++;
        }

        if ($course->address != $request->address) {
            $course->address = $request->address;
            $counter++;
        }


        if ($course->location != $request->location) {
            $course->location = $request->location;
            $counter++;
        }

        if ($course->description != $request->description) {
            $course->description = $request->description;
            $counter++;
        }

        if ($course->type != $request->type) {
            $course->type = $request->type;
            $counter++;
        }

        // Checking If There Are Changes In The Coupons List
        if (is_null($request->coupon)) {
            if ($course->coupon != 0) {
                $course->coupon = 0;
                $counter++;
            }
            for ($i = 0; $i < count($course->discountCoupon); $i++) {
                $course->discountCoupon[$i]->delete();
            }
        } else {

            if (count($request->coupon_code) > count($course->discountCoupon)) {

                for ($i = 0; $i < count($request->coupon_code); $i++) {

                    if (isset($course->discountCoupon[$i])) {
                        for ($x = 0; $x < count($course->discountCoupon); $x++) {

                            $counter_ = 0;
                            if ($course->discountCoupon[$x]->code != $request->coupon_code[$i]) {
                                $course->discountCoupon[$x]->code = $request->coupon_code[$i];
                                $counter_++;
                            }

                            if ($course->discountCoupon[$x]->discount != $request->coupon_discount[$i]) {
                                $course->discountCoupon[$x]->discount = $request->coupon_discount[$i];
                                $counter_++;
                            }

                            if ($counter_ != 0) {
                                $course->discountCoupon[$x]->save();
                            }

                        }
                    } else {
                        Coupon::create([
                            'code' => $request->coupon_code[$i],
                            'discount' => $request->coupon_discount[$i],
                            'course_id' => $course->id,
                        ]);
                    }

                }

            } elseif (count($request->coupon_code) < count($course->discountCoupon)) {

                for ($i = 0; $i < count($course->discountCoupon); $i++) {

                    if (isset($request->coupon_code[$i])) {
                        for ($x = 0; $x < count($request->coupon_code); $x++) {

                            $counter_ = 0;
                            if ($course->discountCoupon[$i]->code != $request->coupon_code[$x]) {
                                $course->discountCoupon[$i]->code = $request->coupon_code[$x];
                                $counter_++;
                            }

                            if ($course->discountCoupon[$i]->discount != $request->coupon_discount[$x]) {
                                $course->discountCoupon[$i]->discount = $request->coupon_discount[$x];
                                $counter_++;
                            }

                            if ($counter_ != 0) {
                                $course->discountCoupon[$x]->save();
                            }

                        }
                    } else {
                        $course->discountCoupon[$i]->delete();
                    }

                }

            } else {
                for ($i = 0; $i < count($course->discountCoupon); $i++) {
                    $counter_ = 0;
                    if ($course->discountCoupon[$i]->code != $request->coupon_code[$i]) {
                        $course->discountCoupon[$i]->code = $request->coupon_code[$i];
                        $counter_++;
                    }

                    if ($course->discountCoupon[$i]->discount != $request->coupon_discount[$i]) {
                        $course->discountCoupon[$i]->discount = $request->coupon_discount[$i];
                        $counter_++;
                    }

                    if ($counter_ != 0) {
                        $course->discountCoupon[$i]->save();
                    }
                }
            }
        }

        $total_trainers = Trainer::where('center_id', Auth::user()->admin->center->id)->get();

        // Checking If There Are Changes In The Trainer List
        if (count($course->trainer) == count($total_trainers)) {

            if (count($request->trainer) > count($total_trainers)) {
                return redirect()->route('admin.course.edit', $course->id)->withErrors(['لا يمكنك إضافة مدربين ليسوا مسجلين في النظام']);
            } elseif (count($request->trainer) < 1) {
                return redirect()->route('admin.course.edit', $course->id)->withErrors(['لا يمكنك حذف كافة المدربين من الدورة']);
            } else {
                for ($i = 0; $i < count($course->trainer); $i++) {
                    if ($course->trainer[$i]->trainer_id != $request->trainer[$i]) {
                        $course->trainer[$i]->trainer_id = $request->trainer[$i];
                        $counter++;
                    }
                    $course->trainer[$i]->save();
                }
            }

        } else {

            if (count($request->trainer) > count($total_trainers)) {
                return redirect()->route('admin.course.edit', $course->id)->withErrors(['لا يمكنك إضافة مدربين ليسوا مسجلين في النظام']);
            } elseif (count($request->trainer) < 1) {
                return redirect()->route('admin.course.edit', $course->id)->withErrors(['لا يمكنك حذف كافة المدربين من الدورة']);
            } else {


                for ($x = 0; $x < count($request->trainer); $x++) {

                    if (isset($course->trainer[$x])) {
                        for ($i = 0; $i < count($course->trainer); $i++) {
                            if ($course->trainer[$i]->trainer_id != $request->trainer[$x]) {
                                $course->trainer[$i]->trainer_id = $request->trainer[$x];
                                $counter++;
                            }
                            $course->trainer[$i]->save();
                        }
                    } else {

                        CourseTrainer::create([
                            'course_id' => $course->id,
                            'trainer_id' => $request->trainer[$x],
                        ]);

                    }


                }


            }


        }


//        dd($request->hasFile('course-poster-1'));

        // Checking If The Request Has An Image
        if ($request->hasFile('course-poster-1')) {
            if (File::exists('storage/course-images/', $course->image[0]->image)) {
                if (Storage::delete('public/course-images/' . $course->image[0]->image)) {
                    $file = $request->file('course-poster-1')->store('public/course-images');
                    $file_name = basename($file);
                    $course->image[0]->image = $file_name;
                    $course->image[0]->save();
                    $counter++;
                }
            }
        }

        // Checking If The Request Has An Image
        if ($request->hasFile('course-poster-2')) {
            if (File::exists('storage/course-images/', $course->image[1]->image)) {
                if (Storage::delete('public/course-images/' . $course->image[1]->image)) {
                    $file = $request->file('course-poster-2')->store('public/course-images');
                    $file_name = basename($file);
                    $course->image[1]->image = $file_name;
                    $course->image[1]->save();
                    $counter++;
                }
            }
        }

        if ($course->start_date != $request->start_date) {
            $course->start_date = $request->start_date;
            $counter++;
        }


        if ($course->finish_date != $request->finish_date) {
            $course->finish_date = $request->finish_date;
            $counter++;
        }

        if ($course->end_reservation != $request->end_reservation) {
            $course->end_reservation = $request->end_reservation;
            $counter++;
        }

        if ($course->start_time != $request->start_time . ":00") {
            $course->start_time = $request->start_time;
            $counter++;
        }

        if ($course->attendance != $request->attendance) {
            $course->attendance = $request->attendance;
            $counter++;
        }

        if ($request->type == 'free') {
            if ($course->price != 0) {
                $course->price = 0;
                $counter++;
            }
        } else {
            if ($course->price != $request->price) {
                $course->price = $request->price;
                $counter++;
            }
        }

        if ($course->gender != $request->gender) {
            $course->gender = $request->gender;
            $counter++;
        }


        if ($counter == 0) {
            return redirect()->route('admin.course.edit', $course->id)->withErrors(['قم بتحديث بعض الحقول لكي يتم حفظها']);
        }

        $course->save();
        return redirect()->route('admin.course.edit', $course->id)->with('success', 'تم تحديث معلومات الدورة بنجاح');

    }

    public function show_courses_for_students_attendance()
    {
        $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();
        return view('admin.all-courses-attendance', compact('courseAdmin'));
    }

    public function show_student_attendance($identifier)
    {

        $course = Course::where('identifier', $identifier)->first();
        if (count($course) == 0) {
            abort(404);
        }

        $identifiers = array();
        $admin_courses = Course::where('center_id', Auth::user()->admin->center->id)->get();
        foreach ($admin_courses as $admin_course) {
            array_push($identifiers, $admin_course->identifier);
        }

        if (!in_array($identifier, $identifiers)) {
            abort(404);
        }

        $course_admin = array();
        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

            if (count($course_admin_data) > 0) {

                if ($course_admin_data->role_id == 1) {
                    array_push($course_admin, $course_admin_data->course_id);
                } else {
                    array_push($course_attender, $course_admin_data->course_id);
                }

            }

        }

        $course_admin = count($course_admin);
        $course_attender = count($course_attender);

        return view('admin.show-course-attendance', compact('course', 'course_admin', 'course_attender'));
    }


    public function courses_activation()
    {
        $courseAdmin = CourseAdmin::where('admin_id', Auth::user()->Admin->id)->where('role_id', 1)->get();
//        dd($courseAdmin[0]->course);
        return view('admin.courses-activation', compact('courseAdmin'));
    }

    public function courses_activation_confirm(Request $request)
    {
        $courses = CourseAdmin::where('admin_id', Auth::user()->Admin->id)->where('role_id', 1)->get();
        $identifiers = array();
        for ($i = 0; $i < count($courses); $i++) {
            array_push($identifiers, $courses[$i]->course->identifier);
        }
        $request->validate([
            'activation' => 'required|array|size:' . count($courses),
            'activation.*' => 'required|integer|max:1|min:0',
            'course' => 'required|array|size:' . count($courses),
            'course.*' => 'required|string|max:10|min:10|' . Rule::in($identifiers),
        ]);

        $counter = 0;

        for ($i = 0; $i < count($courses); $i++) {

            if ($courses[$i]->course->activation != $request->activation[$i]) {
                $courses[$i]->course->activation = $request->activation[$i];
                $courses[$i]->course->save();
                $counter++;
            }
        }

        if ($counter == 0) {
            return redirect()->route('admin.courses.activation')->withErrors(['قم بتحديث بعض الحقول لكي يتم حفظها']);
        }
        return redirect()->route('admin.courses.activation')->with('success', 'تم تحديث البيانات بنجاح');
    }

    public function show_courses_for_take_students_attendance()
    {
        $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();
        return view('admin.all-courses-take-attendance', compact('courseAdmin'));
    }

    public function take_students_attendance($identifier, $date)
    {
        if ( $date > date("Y-m-d") ){
            abort(404);
        }elseif ( $date < date("Y-m-d") ){
            abort(404);
        }
        $course = Course::where('identifier', $identifier)->first();
        return view('admin.take-attendance', compact('course'));
    }

    public function show_course_schedule_for_take_attendance($identifier)
    {
        $course = Course::where('identifier', $identifier)->first();

        if( count($course) < 1 ){
            abort(404);
        }
        $date1 = date_create($course->start_date);
        $date2 = date_create($course->finish_date);
        $diff = date_diff($date1, $date2);
        $days = $diff->format("%a");
        return view('admin.show-course-schedule', compact('course','days'));
    }

    public function take_students_attendance_confirm(Request $request)
    {
        return "Hello";
    }

    public function destroy($id)
    {
        //
    }
}
