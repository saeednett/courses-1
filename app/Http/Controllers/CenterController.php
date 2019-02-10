<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Appointment;
use App\Bank;
use App\Category;
use App\Center;
use App\CenterAccount;
use App\City;
use App\Country;
use App\Coupon;
use App\Course;
use App\CourseAdmin;
use App\CourseTrainer;
use App\Image;
use App\Nationality;
use App\Reservation;
use App\Title;
use App\Trainer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class CenterController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth-center')->except(['cities']);
//    }


    public function check_coupon($course_identifier, $coupon)
    {
        $course = Course::select('id')->where('identifier', $course_identifier)->get();
        $response['status'] = array();
        $response['errors'] = array();
        $response['response'] = array();

        if (count($course) == 0) {
            array_push($response['status'], "Error");
            array_push($response['errors'], "Wrong Course Identifier");
            array_push($response['response'], null);
            return response()->json($response);
        }

        $coupon = Coupon::where('coupon_code', $coupon)->get();

        if (count($coupon) == 0) {
            array_push($response['status'], "Failed");
            array_push($response['errors'], null);
            array_push($response['response'], "كود الخصم غير موجود");
            return response()->json($response);
        } else {
            array_push($response['status'], "Success");
            array_push($response['errors'], null);
            array_push($response['response'], "%" . $coupon[0]->discount . " كود الخصم موجود بقيمة  ");
            return response()->json($response);
        }

    }

    // For Registration Select City
    public function cities(Request $request, $id)
    {
        if ($request->ajax()) {
            $cities = City::where('country_id', $id)->get();
            $data['data'] = array();
            foreach ($cities as $city) {
                $array = array('id' => $city->id, 'name' => $city->name);
                array_push($data['data'], $array);
            }

            return response()->json($data);
        } else {
            abort(400);
        }
    }

    public function bank_account($center_id, $bank_id)
    {

        $center = User::find($center_id);

        if ($center->role_id != 2) {
            $response['error'] = ['Wrong Center Identifier'];
            return response()->json($response);
        }

        $banks_data = array();
        $banks_id = CenterAccount::select('bank_id')->where('center_id', $center->center->id)->get();

        foreach ($banks_id as $id) {
            array_push($banks_data, $id->bank_id);
        }

        if (!in_array((int)$bank_id, $banks_data)) {
            $response['error'] = ['Wrong Bank Identifier'];
            return response()->json($response);
        }

        $bank = Bank::find($bank_id);
        $accounts = CenterAccount::where('center_id', $center->center->id)->where('bank_id', $bank_id)->get();
        $response['response'] = array();
        foreach ($accounts as $account) {
            $response['response'] = ['id' => $bank->id, 'name' => $bank->name, 'logo' => $bank->logo, 'account_owner' => $account->account_owner, 'account_number' => $account->account_number];
        }


        return response()->json($response);
    }

    public function index($center)
    {
        if ($center == Auth::user()->username) {
            $courses = Course::where('center_id', Auth::user()->id)->get();
            $trainers = Trainer::where('center_id', Auth::user()->id)->get();
            $admins = Admin::where('center_id', Auth::user()->id)->get();
            $course_id = Course::select('id')->where('center_id', Auth::user()->id)->get();
            $students = Reservation::find($course_id)->count();
            return view('center.index', compact('courses', 'trainers', 'admins', 'students'));
        } else {
            return abort(404);
        }
    }

    public function create()
    {
        $banks = Bank::all();
        $countries = Country::all();
        return view('center.register', compact('countries', 'banks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|min:10|unique:users,name',
            'verification_code' => 'required|string|max:10|min:4|unique:centers,verification_code',
            'verification_authority' => 'required|string|max:50|min:10',
            'country' => 'required|integer|max:99|min:1|exists:countries,id',
            'city' => 'required|integer|max:99|min:1|exists:cities,id',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:9|unique:users,phone',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|max:32|min:8|confirmed',
            'bank' => 'required|integer|max:99|min:1|exists:banks,id',
            'account_owner' => 'required|string|max:50|min:10',
            'account_number' => 'required|digits:20|unique:center_accounts,account_number',
            'website' => 'required|string|max:50|min:10|unique:centers,website',
            'profile-cover' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:500',
            'profile-logo' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:500',
        ]);

        DB::beginTransaction();

        try {
            $center = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'phone' => "+966" . $request->phone,
                'role_id' => 2,
                'password' => Hash::make($request->password),
            ]);

            $cover = "";
            $logo = "";

            for ($i = 0; $i < 2; $i++) {
                $input_names = ['profile-cover', 'profile-logo'];
                $file = $request->file($input_names[$i])->store('public/center-images');
                $file_name = basename($file);
                if ($i == 0) {
                    $cover = $file_name;
                } else {
                    $logo = $file_name;
                }
            }


            $center = Center::create([
                'user_id' => $center->id,
                'verification_code' => $request->verification_code,
                'verification_authority' => $request->verification_authority,
                'website' => $request->website,
                'city_id' => $request->city,
                'status' => 1,
                'cover' => $cover,
                'logo' => $logo,
            ]);

            CenterAccount::create([
                'account_owner' => 'Test Owner',
                'account_number' => $request->account_number,
                'bank_id' => $request->bank,
                'center_id' => $center->id,
            ]);

            DB::commit();

            auth()->login($center);
            return redirect()->route('center.index', $request->username);

        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
    }

    public function show($name)
    {
        // When User|Student Wants To See The Profile Of The Center

        $center = User::where('username', $name)->first();
        if (count($center) == 0) {
            abort(404);
        }
        $courses = Course::where('center_id', $center->center->id)->get();
        return view('student.center-profile', compact('center', 'courses'));
    }

    public function edit()
    {
        $id = Auth::user()->id;
        $center = User::find($id);
        $cities = City::where('country_id', $center->center->city->country_id)->get();
        $countries = Country::all();
        $banks = Bank::all();

        $courses = Course::where('center_id', Auth::user()->center->id)->get();
        $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
        $admins = Admin::where('center_id', Auth::user()->center->id)->get();

        $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
        $students = Reservation::find($course_id)->count();

        return view('center.edit-center', compact('center', 'banks', 'countries', 'cities', 'courses', 'trainers', 'admins', 'students'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:50|min:10|' . Rule::unique('users')->ignore(Auth()->user()->id),
            'verification_code' => 'required|string|max:10|min:4|' . Rule::unique('centers')->ignore(Auth()->user()->id, 'user_id'),
            'verification_authority' => 'required|string|max:50|min:10',
            'country' => 'required|integer|max:99|min:1|exists:countries,id',
            'city' => 'required|integer|max:99|min:1|exists:cities,id',
            'email' => 'required|email|' . Rule::unique('users')->ignore(Auth()->user()->id),
            'phone' => 'required|' . Rule::unique('users')->ignore(Auth()->user()->id),
            'username' => 'required|string|' . Rule::unique('users')->ignore(Auth()->user()->id),
//            'bank' => 'required|integer|max:99|min:1|exists:banks,id',
//            'account_number' => 'required|digits:20|' . Rule::unique('centers')->ignore(Auth()->user()->id, 'user_id'),
            'website' => 'required|string|max:50|min:10|' . Rule::unique('centers')->ignore(Auth()->user()->id, 'user_id'),
            'profile-cover' => 'sometimes|image|mimetypes:image/png,image/jpg,image/jpeg||max:500',
            'profile-logo' => 'sometimes|image|mimetypes:image/png,image/jpg,image/jpeg||max:500',
        ]);

        $counter = 0;

        $id = Auth::user()->id;
        $center = User::find($id);

        if ($center->name != $request->name) {
            $center->name = $request->name;
            $counter++;
        }

        if ($center->center->verification_code != $request->verification_code) {
            $center->center->verification_code = $request->verification_code;
            $counter++;
        }

        if ($center->center->verification_authority != $request->verification_authority) {
            $center->center->verification_authority = $request->verification_authority;
            $counter++;
        }

        if ($center->center->city_id != $request->city) {
            $center->center->city_id = $request->city;
            $counter++;
        }

        if ($center->email != $request->email) {
            $center->email = $request->email;
            $counter++;
        }

        if ($center->username != $request->username) {
            $center->username = $request->username;
            $counter++;
        }

//        if ($center->center->bank_id != $request->bank) {
//            $center->center->bank_id = $request->bank;
//            $counter++;
//        }
//
//        if ($center->center->account_number != $request->account_number) {
//            $center->center->account_number = $request->account_number;
//            $counter++;
//        }

        if ($center->center->website != $request->website) {
            $center->center->website = $request->website;
            $counter++;
        }


        if ($request->hasFile('profile-cover')) {
            $counter++;
            if (File::exists('public/center-images/' . $center->center->cover)) {
                if (Storage::delete('public/center-images/' . $center->center->cover)) {
                    $file = $request->file('profile-cover')->store('public/center-images');
                    $file_name = basename($file);
                    $center->center->cover = $file_name;
                }
            } else {
                $file = $request->file('profile-cover')->store('public/center-images');
                $file_name = basename($file);
                $center->center->cover = $file_name;
            }

        }

        if ($request->hasFile('profile-logo')) {
            $counter++;
            if (File::exists('public/center-images/' . $center->center->logo)) {
                if (Storage::delete('public/center-images/' . $center->center->logo)) {
                    $file = $request->file('profile-logo')->store('public/center-images');
                    $file_name = basename($file);
                    $center->center->logo = $file_name;
                }
            } else {
                $file = $request->file('profile-logo')->store('public/center-images');
                $file_name = basename($file);
                $center->center->logo = $file_name;
            }

        }

        if ($center->center->about != $request->about) {
            $center->center->about = $request->about;
            $counter++;
        }



        if ($counter > 0) {
            $center->save();
            $center->center->save();
        } else {
            return redirect()->route('center.edit')->withErrors(['قم بتحديث بعض الحقول لكي يتم حفظها', 'لم يتم تحديث اي حقل']);
        }


        return redirect()->route('center.edit')->with('success', 'تم تعديل البيانات بنجاح');
    }

    public function destroy($id)
    {

    }

    public function create_sign_in()
    {
        return view('center.login');
    }

    public function create_trainer()
    {
        $nationalities = Nationality::all();
        $titles = Title::all();

        $courses = Course::where('center_id', Auth::user()->center->id)->get();
        $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
        $admins = Admin::where('center_id', Auth::user()->center->id)->get();

        $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
        $students = Reservation::find($course_id)->count();

        return view('center.create-trainer', compact('nationalities', 'titles', 'courses', 'trainers', 'admins', 'students'));
    }

    public function store_trainer(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:50|min:6|unique:users,name',
            'username' => 'required|string|max:20|:min:5|unique:users,username',
            'phone' => 'required|starts_with:+|max:15|min:9|unique:users,phone',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|max:32|min:8|confirmed',
            'title' => 'required|integer|max:99|min:1|exists:titles,id',
            'nationality' => 'required|integer|max:99|min:1|exists:nationalities,id',
            'profile-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:500',
        ]);

        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'phone' => $request->phone,
                'role_id' => 4,
                'password' => Hash::make($request->password),
            ]);

            $file = $request->file('profile-image')->store('public/trainer-images');
            $file_name = basename($file);

            Trainer::create([
                'user_id' => $user->id,
                'center_id' => Auth::user()->center->id,
                'title_id' => $request->title,
                'nationality_id' => $request->nationality,
                'image' => $file_name,
            ]);

            DB::commit();


        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('center.trainer.create')->withErrors(['لم يتم إضافة المدرب', 'الرجاء المحاولة مجددا']);
        }

        return redirect()->route('center.trainer.create')->with('success', 'تم إضافة المدرب بنجاح');
    }

    public function edit_trainer($id)
    {
        $trainer = Trainer::findOrFail($id);
        if ($trainer->center_id == Auth::user()->id) {

            $titles = Title::all();
            $nationalities = Nationality::all();

            $trainers = Trainer::where('center_id', Auth::user()->id)->get();
            $courses = Course::where('center_id', Auth::user()->id)->get();
            $admins = Admin::where('center_id', Auth::user()->id)->get();
            $course_id = Course::select('id')->where('center_id', Auth::user()->id)->get();
            $students = Reservation::find($course_id)->count();

            return view('center.edit-trainer', compact('trainer', 'titles', 'nationalities', 'trainers', 'courses', 'admins', 'students'));

        } else {
            return abort(400);
        }
    }

    public function update_trainer(Request $request, $id)
    {
        $trainer = Trainer::find($id);

        if ($trainer->user->name != $request->name) {
            $request->validate([
                'name' => 'required|string|max:50|min:10|unique:users,name',
            ]);
        }

        if ($trainer->user->username != $request->username) {
            $request->validate([
                'username' => 'required|string|max:20|:min:5|unique:users,username',
            ]);
        }

        if ($trainer->user->phone != $request->phone) {
            $request->validate([
                'phone' => 'required|string|starts_with:+|max:13|min:9||unique:users,phone'
            ]);
        }

        if ($trainer->user->email != $request->email) {
            $request->validate([
                'email' => 'required|string|email|unique:users,email'
            ]);
        }

        $request->validate([
            'title' => 'required|integer|max:99|min:1|exists:titles,id',
            'nationality' => 'required|integer|max:99|min:1|exists:nationalities,id',
        ]);


        $counter = 0;

        if ($trainer->user->name != $request->name) {
            $trainer->user->name = $request->name;
            $counter++;
        }

        if ($trainer->user->username != $request->username) {
            $trainer->user->username = $request->username;
            $counter++;
        }

        if ($trainer->user->phone != $request->phone) {
            $trainer->user->phone = $request->phone;
            $counter++;
        }

        if ($trainer->user->email != $request->email) {
            $trainer->user->email = $request->email;
            $counter++;
        }

        if ($trainer->title_id != $request->title) {
            $trainer->title_id = $request->title;
            $counter++;
        }

        if ($trainer->nationality_id != $request->nationality) {
            $trainer->nationality_id = $request->nationality;
            $counter++;
        }

        if ($counter == 0) {
            return redirect()->route('center.trainer.edit', $trainer->id)->withErrors(['لم يتم التعديل على اي حقل', 'الرجاء تعديل بعض الحقول لكي يتم حفظها']);
        }

        $trainer->save();
        $trainer->user->save();
        return redirect()->route('center.trainer.edit', $trainer->id)->with('success', 'تم تعديل البيانات بنجاح');
    }

    public function show_trainers()
    {

        $trainers = Trainer::where('center_id', Auth::user()->id)->get();


        $courses = Course::where('center_id', Auth::user()->id)->get();
        $admins = Admin::where('center_id', Auth::user()->id)->get();
        $course_id = Course::select('id')->where('center_id', Auth::user()->id)->get();
        $students = Reservation::find($course_id)->count();

        return view('center.show-trainers', compact('trainers', 'courses', 'admins', 'students'));
    }

    public function create_course()
    {
        $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
        $admins = Admin::where('center_id', Auth::user()->center->id)->get();
        $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
        $students = Reservation::find($course_id)->count();
        $courses = Course::where('center_id', Auth::user()->center->id)->get();
        if (count($trainers) <= 0) {
            (['title' => 'لاتوجد دورات في النظام', 'error' => 'من فضلك قم بإضافة بعض الدورات لكي تتمكن من تعيين مدربين لها',]);
            return view("center.error-description", compact('trainers', 'admins', 'students', 'courses'))->withErrors(['title' => 'لايوجد مدربين في النظام', 'error' => 'من فضلك قم بإضافة بعض المدربين لكي تتمكن من إضافة الدورات']);
        }


        $cities = City::where('country_id', 1)->get();
        $countries = Country::all();
        $categories = Category::all();

        return view('center.create-course', compact('trainers', 'admins', 'students', 'cities', 'countries', 'categories', 'courses'));
    }

    public function store_course(Request $request)
    {

        $center = User::find(Auth::user()->id);
        $trainers_data = array();

        $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();

        if (count($trainers) <= 0) {
            abort(404);
        }

        foreach ($center->trainer as $data) {
            array_push($trainers_data, $data->user_id);
        }


        $request->validate([
            'title' => 'required|string|max:50|min:10|unique:courses,title',
            'category' => 'required|integer|max:99|min:1|exists:categories,id',
            'template' => 'required|integer|max:3|min:1',
            'visible' => 'required|integer|max:2|min:1',
            'city' => 'required|integer|max:99|min:1|exists:cities,id',
            'country' => 'required|integer|max:99|min:1|exists:countries,id',
            'address' => 'required|string|max:150|min:10',
            'location' => 'required|string|max:150|min:20',
            'description' => 'required|string|max:200|min:50',

            /* Trainer Section */
            'trainer' => 'required|array|max:' . count($center->trainer),
            'trainer.*' => 'required|integer|distinct|' . Rule::in($trainers_data),
            /* Course Type Section If It Is Free or Payed */
            'type' => 'required|integer|max:2|min:1',
            /* Coupon Section */
            'coupon' => 'required_if:type,2',
            'coupon_code' => 'required_if:coupon,2|array',
            'coupon_discount' => 'required_if:coupon,2|array|size:' . count($request->coupon_code),
            /* Appointments Of The Course */
            'date' => 'required|array|max:10|min:1',
            'date.*' => 'required|date|distinct',
            'time' => 'required|array|max:10|min:1|size:' . count($request->date),
            'time.*' => ['required',
                'regex:/(^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$)/'
            ],

            'attendance' => 'required|array|size:' . count($request->date),
            'attendance.*' => 'required|integer|min:0',
            'price' => 'required|array|size:' . count($request->date),
            'price.*' => 'required|integer|min:0',

            'gender' => 'required|array|size:' . count($request->date),
            'gender.*' => 'required|integer|max:3|min:1',

            'course-poster-1' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg|max:500',
            'course-poster-2' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg|max:500',
        ]);


            $course = Course::create([
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'address' => $request->address,
                'center_id' => Auth::user()->center->id,
                'category_id' => $request->category,
                'city_id' => $request->city,
                'template_id' => $request->template,
                'visible' => $request->visible,
                'validation' => 0,

            ]);

            if ($request->hasFile('course-poster-1') && $request->hasFile('course-poster-2')) {
                for ($i = 1; $i <= 2; $i++) {
                    $file = $request->file('course-poster-' . $i)->store('public/course-images');
                    $file_name = basename($file);

                    Image::create([
                        'url' => $file_name,
                        'course_id' => $course->id,
                    ]);
                }
            }

            for ($i = 0; $i < count($request->trainer); $i++) {
                CourseTrainer::create([
                    'course_id' => $course->id,
                    'trainer_id' => $request->trainer[$i],
                ]);
            }

            if ($request->type == 2) {
                for ($i = 0; $i < count($request->coupon_code); $i++) {
                    Coupon::create([
                        'coupon_code' => $request->coupon_code[$i],
                        'course_id' => $course->id,
                        'discount' => $request->coupon_discount[$i],
                    ]);
                }
            }

            for ($i = 0; $i < count($request->date); $i++) {
                Appointment::create([
                    'course_id' => $course->id,
                    'date' => $request->date[$i],
                    'time' => $request->time[$i],
                    'attendance' => $request->attendance[$i],
                    'price' => $request->price[$i],
                    'gender' => $request->gender[$i],
                ]);
            }

            return redirect()->route('center.course.create')->with('success', 'تم إضافة الدورة بنجاح');


    }

    public function edit_course()
    {

    }

    public function update_course()
    {

    }

    public function show_courses()
    {

        $courses = Course::where('center_id', Auth::user()->center->id)->get();
        $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
        $admins = Admin::where('center_id', Auth::user()->center->id)->get();
        $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
        $students = Reservation::find($course_id)->count();

        return view('center.show-courses', compact('courses', 'trainers', 'admins', 'students'));
    }

    public function create_admin()
    {
        $courses = Course::where('center_id', Auth::user()->id)->get();
        $trainers = Trainer::where('center_id', Auth::user()->id)->get();
        $admins = Admin::where('center_id', Auth::user()->id)->get();
        $course_id = Course::select('id')->where('center_id', Auth::user()->id)->get();
        $students = Reservation::find($course_id)->count();

        return view('center.create-admin', compact('courses', 'trainers', 'admins', 'students'));
    }

    public function store_admin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|min:6|unique:users,name',
            'username' => 'required|string|max:20|:min:5|unique:users,username',
            'phone' => 'required|starts_with:+|max:15|min:9|unique:users,phone',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|max:32|min:8|confirmed',
            'profile-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:500',
        ]);

        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 3,
            ]);

            $file = $request->file('profile-image')->store('public/admin-images');
            $file_name = basename($file);

            Admin::create([
                'user_id' => $user->id,
                'center_id' => Auth::user()->id,
                'status' => 1,
                'image' => $file_name,
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('center.admin.create')->withErrors(['لم يتم إضافة المدرب', 'الرجاء المحاولة مجددا'])->withInput();
        }
        return redirect()->route('center.admin.create')->with('success', 'تم إضافة المسؤول بنجاح');
    }

    public function edit_admin($id)
    {

        $admin = Admin::findorFail($id);
        if ($admin->center_id == Auth::user()->id) {

            $courses = Course::where('center_id', Auth::user()->id)->get();
            $trainers = Trainer::where('center_id', Auth::user()->id)->get();
            $admins = Admin::where('center_id', Auth::user()->id)->get();
            $course_id = Course::select('id')->where('center_id', Auth::user()->id)->get();
            $students = Reservation::find($course_id)->count();

            return view('center.edit-admin', compact('admin', 'courses', 'trainers', 'admins', 'students'));
        } else {
            abort(404);
        }
    }

    public function update_admin(Request $request, $id)
    {
        $admin = Admin::find($id);


        $counter = 0;

        if ($admin->user->name != $request->name) {
            $request->validate([
                'name' => 'required|string|max:50|min:6|unique:users,name',
            ]);
            $admin->user->name = $request->name;
            $counter++;
        }

        if ($admin->user->username != $request->username) {
            $request->validate([
                'username' => 'required|string|max:20|:min:5|unique:users,username',
            ]);
            $admin->user->username = $request->username;
            $counter++;
        }

        if ($admin->user->phone != $request->phone) {
            $request->validate([
                'phone' => 'required|starts_with:+|max:15|min:9|unique:users,phone',
            ]);
            $admin->user->phone = $request->phone;
            $counter++;
        }

        if ($admin->user->email != $request->email) {
            $request->validate([
                'email' => 'required|string|email|unique:users,email',
            ]);
            $admin->user->email = $request->email;
            $counter++;
        }

        if ($counter == 0) {
            return redirect()->route('center.admin.edit', $id)->withErrors(['لم يتم التعديل على اي حقل', 'الرجاء تعديل بعض الحقول لكي يتم حفظها']);
        }

        $admin->user->save();
        return redirect()->route('center.admin.edit', $id)->with('success', 'تم تعديل البيانات بنجاح');
    }

    public function show_admins()
    {
        $admins = Admin::where('center_id', Auth::user()->id)->get();
        $courses = Course::where('center_id', Auth::user()->id)->get();
        $trainers = Trainer::where('center_id', Auth::user()->id)->get();
        $course_id = Course::select('id')->where('center_id', Auth::user()->id)->get();
        $students = Reservation::find($course_id)->count();
        return view('center.show-admins', compact('admins', 'courses', 'trainers', 'students'));
    }

    public function assign_course_admin()
    {
        $courses = Course::where('center_id', Auth::user()->center->id)->get();
        $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
        $admins = Admin::where('center_id', Auth::user()->center->id)->get();
        $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
        $students = Reservation::find($course_id)->count();

        if (count($courses) <= 0) {
            return view("center.error-description", compact('trainers', 'admins', 'students', 'courses'))->withErrors(['title' => 'لاتوجد دورات في النظام', 'error' => 'من فضلك قم بإضافة بعض الدورات لكي تتمكن من تعيين مدربين لها',]);
        } elseif (count($admins) <= 0) {
            return view("center.error-description", compact('trainers', 'admins', 'students', 'courses'))->withErrors(['title' => 'لايوجد مدراء في النظام', 'error' => 'من فضلك قم بإضافة بعض المدراء لكي تتمكن من تعيينهم مدربين للدورات',]);
        }

        return view('center.assign-course-admin', compact('courses', 'trainers', 'admins', 'students'));
    }

    public function store_course_admin(Request $request)
    {

        $courses = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
        $course_data = array();
        foreach ($courses as $course) {
            array_push($course_data, $course->id);
        }

        $admins = Admin::where('center_id', Auth::user()->center->id)->get();
        $admin_data = array();
        foreach ($admins as $admin) {
            array_push($admin_data, $admin->user->id);
        }

        if (count($courses) <= 0) {
            abort(404);
        }


        $request->validate([
            'course' => 'required|integer|max:99|min:0|exists:courses,id|' . Rule::in($course_data),
            'admin' => 'required|integer|max:99|min:0|' . Rule::in($admin_data),
            'role' => 'required|integer|max:2|min:1',
        ]);


        CourseAdmin::create([
            'course_id' => $request->course,
            'user_id' => $request->admin,
            'role_id' => $request->role,
        ]);

        return redirect()->route('center.course.admin.assign')->with('success', 'تم تعيين المسؤول بنجاح');
    }

}
