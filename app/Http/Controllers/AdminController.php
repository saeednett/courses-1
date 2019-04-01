<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Category;
use App\Certificate;
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
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // This Function Returns The Count Of Course Attendance Privilege
    private function get_auth_course_attendance()
    {

        $course_attender = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->where('role_id', 2)->first();

            if (count($course) > 0) {

                array_push($course_attender, $course->course_id);

            }

        }

        return count($course_attender);

    }

    // This Function Returns The Count Of Course Admin Privilege
    private function get_auth_course_admin()
    {

        $course_admin = array();

        $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

        for ($i = 0; $i < count($courses_data); $i++) {

            $course = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->where('role_id', 1)->first();

            if (count($course) > 0) {

                array_push($course_admin, $course->course_id);

            }

        }

        return count($course_admin);

    }

    // This Function Returns An Error Page
    private function error_page($title = "خطأ", $message = "صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة")
    {
        if (Auth::user()->role_id == 1) {
            return view('admin.error-page')->withErrors(['error_title' => $title, 'message', $message]);
        } elseif (Auth::user()->role_id == 2) {
            return view('admin.error-page')->withErrors(['error_title' => $title, 'message', $message]);
        } elseif (Auth::user()->role_id == 5) {
            return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
        } else {
            $course_admin = $this->get_auth_course_admin();
            $course_attender = $this->get_auth_course_attendance();
            return view('admin.error-page', compact('course_admin', 'course_attender'))->withErrors(['error_title' => $title, 'message' => $message]);
        }
    }

    // This Function Returns The Data Of The Main Page Of The Admin
    public function index($admin)
    {

        if ($admin == Auth::user()->username && Auth::user()->role_id == 3) {

            $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();
            $course_admin = $this->get_auth_course_admin();
            $course_attender = $this->get_auth_course_attendance();
            return view('admin.index', compact('courseAdmin', 'course_admin', 'course_attender'));
        } else {

            return $this->error_page();

        }

    }

    // This Function Returns All Students Of A Course To Confirm Their Payments
    public function course_payment_show_students($identifier)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $course = Course::where('identifier', $identifier)->first();
            if (count($course) < 1) {
                return $this->error_page("خطأ", "الرجاء التأكد من مهرف الدورة");
            } else {

                $admin = CourseAdmin::where('course_id', $course->id)->where('admin_id', Auth::user()->admin->id)->where('role_id', 1)->first();

                if (count($admin) < 1) {
                    return $this->error_page();
                } else {

                    $course_admin = $this->get_auth_course_admin();
                    $course_attender = $this->get_auth_course_attendance();
                    return view('admin.confirm-payment', compact('course', 'course_admin', 'course_attender'));

                }

            }

        } else {

            return $this->error_page();

        }

    }

    // The Data Of Confirming The Payment Goes Here And The Process Happens Here
    public function course_payment_confirm(Request $request, $identifier)
    {

        if (Auth::check() && Auth::user()->role_id) {

            $course = Course::where('identifier', $identifier)->first();

            if (count($course) < 1) {
                return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");
            } else {

                $admin = CourseAdmin::where('course_id', $course->id)->where('admin_id', Auth::user()->admin->id)->where('role_id', 1)->first();

                if (count($admin) < 1) {
                    return $this->error_page();
                } else {

                    $reservations_data = Reservation::where('course_id', $course->id)->where('confirmation', 0)->get();

                    if (count($reservations_data) < 1) {

                        return $this->error_page("خطأ", "تم تأكيد الدفع لجميع طلاب هذه الدورة");

                    } else {


                        $students = array();
                        $identifiers = array();

                        foreach ($reservations_data as $reservation) {
                            array_push($students, $reservation->student_id);
                            array_push($identifiers, $reservation->identifier);
                        }

                        $request->validate([
                            'student' => 'required|array|size:' . count($students),
                            'student.*' => 'required|integer|' . Rule::in($students),
                            'payment' => 'required|array|size:' . count($students),
                            'payment.*' => 'required|integer|max:1|min:0',
                            'identifier' => 'required|array|size:' . count($students),
                            'identifier.*' => 'required|string|max:10|min:10|' . Rule::in($identifiers),
                        ]);

                        $counter = 0;

                        for ($i = 0; $i < count($students); $i++) {
                            if ($request->payment[$i] == 1) {
                                $reservation = Reservation::where('student_id', $students[$i])->where('identifier', $identifiers[$i])->first();
                                $reservation->confirmation = 1;
                                $reservation->barcode = $reservation->course->identifier . $reservation->identifier . Str::random(10);
                                $reservation->save();
                                $counter++;
                            }
                        }

                        if ($counter == 0) {
                            return redirect()->route('admin.courses.payment', $identifier)->withErrors(['الزجاء قم بتحديث بعض البيانات لكي يتم حفظها']);
                        } else {
                            return redirect()->route('admin.courses.payment', $identifier)->with('success', 'تم تأكيد الدفع بنجاح');
                        }
                    }

                }

            }

        } else {

            return $this->error_page();

        }

    }

    // This Functions Returns The List Of Courses That Belongs To The Admin
    public function show_courses()
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();

            $course_admin = $this->get_auth_course_admin();
            $course_attender = $this->get_auth_course_attendance();

            return view('admin.show-courses', compact('courseAdmin', 'course_admin', 'course_attender'));

        } else {

            return $this->error_page();

        }
    }

    // This Function Returns All Courses To Select One And The Confirm It's Payments
    public function courses_payment_show()
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->where('role_id', 1)->get();
            return view('admin.all-courses-payment', compact('courseAdmin', 'course_admin', 'course_attender'));

        } else {

            return $this->error_page();

        }
    }

    // This Function Returns All Courses To Select One The Show All Students Who Registered To It
    public function show_courses_for_show_student()
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();
            $course_admin = $this->get_auth_course_admin();
            $course_attender = $this->get_auth_course_attendance();
            return view('admin.all-courses-students', compact('courseAdmin', 'course_admin', 'course_attender'));

        } else {

            return $this->error_page();

        }

    }

    // This Function Returns All Students Of The Selected Course
    public function show_course_students($identifier)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $course = Course::where('identifier', $identifier)->first();

            if (count($course) < 1) {
                return $this->error_page("خطأ", "الرجاا التأكد من معرف الدورة");
            } else {

                $admin = CourseAdmin::where('course_id', $course->id)->where('admin_id', Auth::user()->admin->id)->get();

                if (count($admin) < 1) {
                    return $this->error_page();
                } else {
                    $reservations = Reservation::where('course_id', $course->id)->where('confirmation', 1)->get();
                    $course_admin = $this->get_auth_course_admin();
                    $course_attender = $this->get_auth_course_attendance();
                    return view('admin.show-course-students', compact('course', 'reservations', 'course_admin', 'course_attender'));
                }

            }

        } else {

            return $this->error_page();

        }

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

    // This Function Returns The Information Of The Admin To Be Edit
    public function edit()
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $admin = User::find(Auth::user()->admin->user_id);
            $course_admin = $this->get_auth_course_admin();
            $course_attender = $this->get_auth_course_attendance();
            return view('admin.edit-admin', compact('admin', 'course_admin', 'course_attender'));

        } else {

            return $this->error_page();

        }
    }

    // The Data Of Editing Admin Information Goes Here And The Process Happens Here
    public function update(Request $request)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $counter = 0;
            $admin = User::find(Auth::user()->admin->user_id);

            if ($admin->admin->name != $request->name) {
                $request->validate([
                    'name' => 'required|string|max:50|min:7',
                ]);
                $admin->admin->name = $request->name;
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
                    'email' => 'required|email|max:50',
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

        } else {

            return $this->error_page();

        }

    }

    // This Function Returns The Page For Resetting Admin Password
    public function reset_password()
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $admin = User::find(Auth::user()->admin->user_id);
            $course_admin = $this->get_auth_course_admin();
            $course_attender = $this->get_auth_course_attendance();
            return view('admin.reset-password', compact('admin', 'course_admin', 'course_attender'));

        } else {

            return $this->error_page();

        }

    }

    // The Data Of Resetting Admin Password Goes Here And The Process Happens Here
    public function reset_password_confirm(Request $request)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

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

        } else {
            return $this->error_page();
        }

    }

    // This Function Returns Course Data To Be Edit
    public function course_edit($identifier)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $course = Course::where('identifier', $identifier)->first();

            if (count($course) < 1) {
                return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");
            }

            $admin = CourseAdmin::where('course_id', $course->id)->where('admin_id', Auth::user()->admin->id)->where('role_id', 1)->first();

            if (count($admin) < 1) {
                return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");
            }

            $categories = Category::all();
            $countries = Country::all();
            $cities = City::all();
            $trainers = Trainer::where('center_id', Auth::user()->admin->center->id)->get();
            return view('admin.edit-course', compact('course', 'categories', 'countries', 'cities', 'trainers'));

        } else {
            return $this->error_page();
        }
    }

    // The Data Of Editing Course Goes Here And The Process Happens Here
    public function course_update(Request $request, $identifier)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $course = Course::where('identifier', $identifier)->first();
            if (count($course) < 1) {
                return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");
            } else {

                $admin = CourseAdmin::where('course_id', $course->id)->where('admin_id', Auth::user()->admin->id)->where('role_id', 1)->first();
                if (count($admin) < 1) {
                    return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");
                } else {

                    // Getting Center Main Information
                    $center = Center::find(Auth::user()->admin->center->id);
                    // Trainers Array That Will Hold Ids Of The Trainers Who Belong To The Center
                    $trainers_data = array();
                    // Getting Trainers Information
                    $trainers = Trainer::where('center_id', Auth::user()->admin->center->id)->get();

                    // Making Sure That The Center Has Trainers
                    if (count($trainers) < 1) {
                        return $this->error_page("خطأ", "لايمكنك إنشاء دورة من دون مدربين");
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
                        return redirect()->route('admin.course.edit', $identifier)->withErrors(['قم بتحديث بعض الحقول لكي يتم حفظها']);
                    }

                    $course->save();
                    return redirect()->route('admin.course.edit', $identifier)->with('success', 'تم تحديث معلومات الدورة بنجاح');

                }

            }

        } else {
            return $this->error_page();
        }

    }

    // This Function Returns All Courses To Select One And The Return Their Students Attendance List
    public function show_courses_for_students_attendance()
    {
        if (Auth::check() && Auth::user()->role_id == 3) {

            $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();
            return view('admin.all-courses-attendance', compact('courseAdmin'));

        } else {

            return $this->error_page();

        }
    }

    // This Function Show The Attendance Of Student Who Registered In The Course
    public function show_student_attendance($identifier)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $course = Course::where('identifier', $identifier)->first();

            if (count($course) < 1) {

                return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");

            } else {

                $admin = CourseAdmin::where('course_id', $course->id)->where('admin_id', Auth::user()->admin->id)->first();

                if (count($admin) < 1) {
                    return $this->error_page();
                } else {

                    $course_admin = $this->get_auth_course_admin();
                    $course_attender = $this->get_auth_course_attendance();
                    return view('admin.show-course-attendance', compact('course', 'course_admin', 'course_attender'));

                }

            }

        } else {
            return $this->error_page();
        }

    }

    // This Function Returns All Courses That Belongs To The Admin To Activate Or Deactivate Them
    public function courses_activation()
    {
        if (Auth::check() && Auth::user()->role_id == 3) {

            $courseAdmin = CourseAdmin::where('admin_id', Auth::user()->Admin->id)->where('role_id', 1)->get();
            return view('admin.courses-activation', compact('courseAdmin'));

        } else {

            return $this->error_page();

        }

    }

    // This Function For The Process Of Activating And Deactivating The Courses
    public function courses_activation_confirm(Request $request)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $courses = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('role_id', 1)->get();
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

        } else {

            return $this->error_page();

        }

    }

    // This Function Returns All Courses To Select One Then To Show It's Attendance
    public function show_courses_for_take_students_attendance()
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $courseAdmin = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();
            return view('admin.all-courses-take-attendance', compact('courseAdmin'));

        } else {

            return $this->error_page();

        }

    }

    public function take_students_attendance($identifier, $date)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            if ($date > date("Y-m-d")) {
                return $this->error_page("خطأ", "الرجاء التأكد من تاريخ اليوم المراد تحضيره");
            } elseif ($date < date("Y-m-d")) {
                return $this->error_page("خطأ", "الرجاء التأكد من تاريخ اليوم المراد تحضيره");
            } else {

                $course = Course::where('identifier', $identifier)->first();

                $date1 = date_create($course->start_date);
                $date2 = date_create($course->end_date);
                $diff = date_diff($date1, $date2);
                $days = $diff->format("%a");

                $students = Reservation::where('course_id', $course->id)->where('confirmation', 1)->count();
                return view('admin.take-attendance', compact('course', 'students', 'days'));

            }

        } else {

            return $this->error_page();

        }
    }

    // This Function Returns All Courses To Select One To Show It's Schedule To Take Attendance
    public function show_course_schedule_for_take_attendance($identifier)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $course = Course::where('identifier', $identifier)->first();

            if (count($course) < 1) {
                return $this->error_page("خطأ", "الرجاء التأكدمن معرف الدورة");
            } else {

                $admin = CourseAdmin::where('course_id', $course->id)->where('admin_id', Auth::user()->admin->id)->first();

                if (count($admin) < 1) {

                    return $this->error_page();

                } else {

                    $date1 = date_create($course->start_date);
                    $date2 = date_create($course->end_date);
                    $diff = date_diff($date1, $date2);
                    $days = $diff->format("%a");
                    return view('admin.show-course-schedule', compact('course', 'days'));

                }

            }

        } else {

            return $this->error_page();

        }

    }

    public function take_students_attendance_confirm(Request $request, $identifier, $date)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $course = Course::where('identifier', $identifier)->first();

            if (count($course) < 1) {
                return $this->error_page("", "الرجاء التاأكد من معرف الدورة");
            } else {

                $admin = CourseAdmin::where('course_id', $course->id)->where('admin_id', Auth::user()->admin->id)->where('role_id', 1)->first();

                if (count($admin) < 1) {
                    return $this->error_page();
                } else {

                    $total_student = array();

                    foreach ($course->reservation as $reservation) {
                        if ($reservation->confirmation == 1) {
                            array_push($total_student, $reservation->student_id);
                        }
                    }

                    $request->validate([
                        'attendance' => 'required|array|size:' . count($total_student),
                        'attendance.*' => 'required|integer|max:1|min:0',
                        'student' => 'required|array|size:' . count($total_student),
                        'student.*' => 'required|integer|' . Rule::in($total_student),
                    ]);

                    $counter = 0;

                    for ($i = 0; $i < count($total_student); $i++) {

                        $attendance = Attendance::where('course_id', $course->id)->where('student_id', $total_student[$i])->where('date', $date)->first();
                        $reservation = Reservation::where('course_id', $course->id)->where('student_id', $request->student[$i])->where('confirmation', 1)->first();

                        if (count($attendance) > 0) {

                            if ($attendance->status != $request->attendance[$i]) {
                                $attendance->status = $request->attendance[$i];
                                $attendance->save();
                                $counter++;
                            }

                        } else {

                            Attendance::create([
                                'date' => date('Y-m-d'),
                                'course_id' => $course->id,
                                'student_id' => $request->student[$i],
                                'admin_id' => Auth::user()->Admin->id,
                                'reservation_id' => $reservation->id,
                                'status' => $request->attendance[$i],
                            ]);
                            $counter++;
                        }
                    }

                    if ($counter == 0) {
                        return redirect()->route('admin.course.take.attendance', [$identifier, $date])->withErrors(['قم بتحضير بعض الطلاب لكي يتم حفظ البيانات الجديدة']);
                    }

                    return redirect()->route('admin.course.take.attendance', [$identifier, $date])->with('success', 'تم حفظ البيانات الجديدة بنجاح');

                }
            }

        } else {

            return $this->error_page();

        }


    }

    // This Function Preview The Course For The Admin In New Page
    public function course_preview($identifier)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {


            $course = Course::where('identifier', $identifier)->first();

            $admin = CourseAdmin::where('course_id', $course->id)->where('admin_id', Auth::user()->admin->id)->first();

            if (count($admin) < 1) {
                return $this->error_page();
            } else {

                if (count($course) < 1) {
                    return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");
                } else {
                    return view('admin.course-preview', compact('course'));
                }

            }

        } else {
            return $this->error_page();
        }

    }

    public function destroy($id)
    {
        //
    }

    // This Function Returns All Courses To Select One Then Show All Students For Creating Certificates
    public function show_courses_for_creating_certificates()
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $courses = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('role_id', 1)->get();

            if (count($courses) < 1) {
                return $this->error_page();
            } else {

                $course_admin = $this->get_auth_course_admin();
                $course_attender = $this->get_auth_course_attendance();
                return view('admin.all-courses-certificates', compact('courses', 'course_admin', 'course_attender'));

            }

        } else {

            return $this->error_page();

        }
    }

    // This Function Returns All Students Who Got Certificate In The Selected Course
    public function show_students_certificate($identifier){

        $course = Course::where('identifier', $identifier)->first();


        if ( count($course) < 1 ){

            return $this->error_page();

        }else{

            $admin = CourseAdmin::where('course_id', $course->id)->where('admin_id', Auth::user()->admin->id)->first();

            if ( count($admin) < 1 ){

                return $this->error_page();

            }else{

                $date1 = date_create($course->start_date);
                $date2 = date_create($course->end_date);
                $diff = date_diff($date1, $date2);
                $days = $diff->format("%a");


                $students = Reservation::where('course_id', $course->id)->where('confirmation', 1)->count();
                $certificates = Certificate::where('course_id', $course->id)->get();
                return view('admin.show-course-certificates', compact('certificates','course', 'days', 'students'));

            }

        }
    }

    public function show_course_students_for_certificate($identifier)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {

            $course = Course::where('identifier', $identifier)->first();

            if (count($course) < 1) {
                return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");
            } else {

                $admin = CourseAdmin::where('course_id', $course->id)->where('admin_id', Auth::user()->admin->id)->where('role_id', 1)->first();

                if (count($admin) < 1) {
                    return $this->error_page();
                } else {


                    $reservations = Reservation::where('course_id', $course->id)->where('confirmation', 1)->get();
                    $course_admin = $this->get_auth_course_admin();
                    $course_attender = $this->get_auth_course_attendance();

                    $date1 = date_create($course->start_date);
                    $date2 = date_create($course->end_date);
                    $diff = date_diff($date1, $date2);
                    $days = $diff->format("%a");

                    $students = Reservation::where('course_id', $course->id)->where('confirmation', 1)->count();

                    return view('admin.show-course-students-certificate', compact('course', 'students', 'reservations', 'days', 'course_admin', 'course_attender'));

                }

            }

        } else {

            return $this->error_page();

        }

    }

    public function generate_certificate(Request $request, $identifier)
    {

        if (Auth::check() && Auth::user()->role_id == 3) {
            $course = Course::where('center_id', Auth::user()->admin->center->id)->where('identifier', $identifier)->first();
            $reservation = Reservation::where('course_id', $course->id)->where('confirmation', 1)->get();

            $request->validate([
                'certificates' => 'required|array|size:' . count($reservation),
                'certificates.*' => 'required|integer|max:1|min:0',
                'students' => 'required|array|size:' . count($reservation),
                'students.*' => 'required|integer|distinct',

            ]);

            $counter = 0;
            if (count($course) < 1) {
                return $this->error_page();
            } else {

                $admin = CourseAdmin::where('course_id', $course->id)->where('admin_id', Auth::user()->admin->id)->first();

                if (count($admin) < 1) {
                    return $this->error_page();
                } else {

                    for ($i = 0; $i < count($request->students); $i++) {

                        $user = Reservation::where('course_id', $course->id)->where('confirmation', 1)->where('student_id', $request->students[$i])->first();

                        if (count($user) > 0) {

                            Certificate::create([
                                'date' => date('Y-m-d'),
                                'student_id' => $user->student->id,
                                'course_id' => $course->id,
                                'admin_id' => Auth::user()->admin->id,
                                'reservation_id' => $user->id,
                                'viewed' => 0,
                            ]);

                            $counter++;


                        }

                    }

                    if ($counter == 0) {
                        return redirect()->route('admin.courses.certificate.students', $identifier)->withErrors(['لم يتم إصدار الشهادات']);
                    } else {
                        return redirect()->route('admin.courses.certificate.students', $identifier)->with('success', 'تم إصدتر الشهادات بنجاح');
                    }

                }

            }
        } else {
            return $this->error_page();
        }

    }

    public function financial_report(){

        if( Auth::check() && Auth::user()->role_id == 3 ){

            $courses = Course::where('center_id', Auth::user()->admin->center->id)->get();

            $months = array();
            $details = array();

            foreach ($courses as $course){

                $reservation_count = Reservation::where('course_id', $course->id)->where('confirmation', 1)->count();



                // Getting The Courses Count
                if ( isset($details[substr($course->start_date,0,7)]) ){
                    $details[substr($course->start_date,0,7)][0] += 1;
                }else{
                    $details[substr($course->start_date,0,7)] = array(1);
                }

                // Getting The Student Count
                if ( isset($details[substr($course->start_date,0,7)][1]) ){
                    $details[substr($course->start_date,0,7)][1] += $reservation_count;
                }else{
                    array_push($details[substr($course->start_date,0,7)], $reservation_count);
                }

                // Getting The Total Expected Money Of All Courses
                if ( isset($details[substr($course->start_date,0,7)][2]) ){
                    $details[substr($course->start_date,0,7)][2] += ($course->price * $reservation_count);
                }else{
                    array_push($details[substr($course->start_date,0,7)], ($course->price * $reservation_count) );
                }

                // Getting The Total Income Money Of All Courses
                if ( isset($details[substr($course->start_date,0,7)][3]) ){
                    $details[substr($course->start_date,0,7)][3] += ( $course->price * $course->attendance);
                }else{
                    array_push($details[substr($course->start_date,0,7)],  $course->price * $course->attendance);
                }


                if (!in_array(substr($course->start_date,0,7), $months)){
                    array_push($months, substr($course->start_date,0,7));
                }

            }


            return view('admin.show-financial-reports', compact('courses', 'details'));

        }else{

            return $this->error_page();

        }

    }

    public function courses_financial_report($date){

        if ( Auth::check() && Auth::user()->role_id == 3 ){

            if( strlen($date) != 7 ){
                return $this->error_page();
            }else{
                preg_match('/(^20[0-9]{2}+-[0-9]{2})/', $date, $output_array);

                if ( empty($output_array) ){
                    return $this->error_page('fewfv');
                }else{
                    $courses = Course::where('center_id', Auth::user()->admin->center->id)->where('start_date', 'like', '%'. $date .'%')->get();
                    return view('admin.show-courses-report', compact('courses'));

                }

            }

        }else{
            return $this->error_page();
        }

    }

}
