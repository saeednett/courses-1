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
use Illuminate\Support\Str;
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


    // To Check A Coupon Of A Course If It Is Valid
    public function check_coupon($course_identifier, $coupon)
    {
        $course = Course::select('id')->where('identifier', $course_identifier)->first();
        $response['status'] = array();
        $response['errors'] = array();
        $response['response'] = array();

        if (count($course) == 0) {
            array_push($response['status'], "Error");
            array_push($response['errors'], "Wrong Course Identifier");
            array_push($response['response'], null);
            return response()->json($response);
        }

        $coupon = Coupon::where('coupon_code', $coupon)->where('course_id', $course->id)->first();

        if (count($coupon) == 0) {
            array_push($response['status'], "Failed");
            array_push($response['errors'], null);
            array_push($response['response'], "كود الخصم غير موجود");
            return response()->json($response);
        } else {
            array_push($response['status'], "Success");
            array_push($response['errors'], null);
            array_push($response['response'], "%" . $coupon->discount . " كود الخصم موجود بقيمة  ");
            return response()->json($response);
        }

    }

    // To Return A Cities List Of A Country
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

    // To Return A Bank Account Information Of The Center
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

    // To Show The Index Of The Center After Login
    public function index($center)
    {
        if ($center == Auth::user()->username) {

            $courses = Course::where('center_id', Auth::user()->center->id)->get();
            $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
            $admins = Admin::where('center_id', Auth::user()->center->id)->get();

            $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
            $students = Reservation::find($course_id);

            $course_admin = CourseAdmin::where('course_id', 3)->first();
//            dd($course_admin);

            $total_students = array();

            for ($i = 0; $i < count($students); $i++) {
                if ($i == 0) {
                    array_push($total_students, $students[$i]->student_id);
                } else {
                    if (!in_array($students[$i]->student_id, $total_students)) {
                        array_push($total_students, $students[$i]->student_id);
                    }
                }
            }
            $total_students = count($total_students);
            return view('center.index', compact('courses', 'trainers', 'admins', 'students', 'total_students'));
        } else {
            return abort(404);
        }
    }

    // To Show The Form Of Creating A New Center
    public function create()
    {
        $banks = Bank::all();
        $countries = Country::all();
        return view('center.register', compact('countries', 'banks'));
    }

    // The Data Of Creating Or Registering For The Center Goes Here And The Process Happens Here
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

    // To Show The Center Information For The Student
    public function show($name)
    {
        // When User|Student Wants To See The Profile Of The Center

        $center = User::where('username', $name)->first();
        if (count($center) == 0) {
            abort(404);
        }

        $course_id = array();
        $current_appointment = array();
        $past_appointment = array();

        foreach ($center->center->course as $course) {
            array_push($course_id, $course->id);
        }

        for ($i = 0; $i < count($course_id); $i++) {
            $max_appointment = Appointment::where('course_id', $course_id[$i])->max('date');
            if ($max_appointment > date('Y-m-d')) {
                array_push($current_appointment, $max_appointment);
            } else {
                array_push($past_appointment, $max_appointment);
            }
        }

        $courses = Course::where('center_id', $center->center->id)->get();
        return view('student.center-profile', compact('center', 'courses', 'current_appointment', 'past_appointment'));
    }

    // To Show The Form Of Editing Center Information
    public function edit()
    {

        // The Center That Will Be Edited
        $center = User::find(Auth::user()->id);

        $cities = City::where('country_id', $center->center->city->country_id)->get();
        // Get All Countries
        $countries = Country::all();
        // Get All Banks
        $banks = Bank::all();

        // All Admins Who Belongs To The Center
        $admins = Admin::where('center_id', Auth::user()->center->id)->get();
        // All Courses Which Belongs To The Center
        $courses = Course::where('center_id', Auth::user()->center->id)->get();
        // All Trainers Who Belongs To The Center
        $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
        // All Courses Id's Of The Courses Which Who Belongs To The Center
        $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
        // All Students Who Reserved A Course Of The Center
        $students = Reservation::find($course_id);
        // An Empty Array To Hold The Different Id's Of The Students
        $total_students = array();
        for ($i = 0; $i < count($students); $i++) {
            if ($i == 0) {
                array_push($total_students, $students[$i]->student_id);
            } else {
                if (!in_array($students[$i]->student_id, $total_students)) {
                    array_push($total_students, $students[$i]->student_id);
                }
            }
        }
        // To Hold The Count Of The Array And Pass It As String
        $total_students = count($total_students);

        return view('center.edit-center', compact('center', 'banks', 'countries', 'cities', 'courses', 'trainers', 'admins', 'students', 'total_students'));
    }

    // The Data Of Updating A Center Goes Here And The Process Happens Here
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

    // To Show The Form Of Signing in For The Center
    public function create_sign_in()
    {
        return view('center.login');
    }

    // To Show The Form Of Creating New Trainer
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

    // The Data Of Storing New Trainer Goes Here And The Process Happens Here
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

    // To Show The Form Of Editing A Trainer
    public function edit_trainer($id)
    {
        // The Trainer That Will Be Edited
        $trainer = Trainer::findOrFail($id);
        if ($trainer->center_id == Auth::user()->center->id) {

            // Get All Titles To Chose One Of Them
            $titles = Title::all();
            // Get All Nationalities To Chose One Of Them
            $nationalities = Nationality::all();
            // All Admins Who Belongs To The Center
            $admins = Admin::where('center_id', Auth::user()->center->id)->get();
            // All Courses Which Belongs To The Center
            $courses = Course::where('center_id', Auth::user()->center->id)->get();
            // All Trainers Who Belongs To The Center
            $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
            // All Courses Id's Of The Courses Which Who Belongs To The Center
            $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
            // All Students Who Reserved A Course Of The Center
            $students = Reservation::find($course_id);
            // An Empty Array To Hold The Different Id's Of The Students
            $total_students = array();
            for ($i = 0; $i < count($students); $i++) {
                if ($i == 0) {
                    array_push($total_students, $students[$i]->student_id);
                } else {
                    if (!in_array($students[$i]->student_id, $total_students)) {
                        array_push($total_students, $students[$i]->student_id);
                    }
                }
            }
            // To Hold The Count Of The Array And Pass It As String
            $total_students = count($total_students);


            return view('center.edit-trainer', compact('trainer', 'titles', 'nationalities', 'trainers', 'courses', 'admins', 'students', 'total_students'));

        } else {
            return abort(400);
        }
    }

    // The Data Of Updating A Trainer Goes Here And The Process Happens Here
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

    // To Show All Trainers Who Belongs To The Center
    public function show_trainers()
    {

        // All Admins Who Belongs To The Center
        $admins = Admin::where('center_id', Auth::user()->center->id)->get();
        // All Courses Which Belongs To The Center
        $courses = Course::where('center_id', Auth::user()->center->id)->get();
        // All Trainers Who Belongs To The Center
        $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
        // All Courses Id's Of The Courses Which Who Belongs To The Center
        $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
        // All Students Who Reserved A Course Of The Center
        $students = Reservation::find($course_id);
        // An Empty Array To Hold The Different Id's Of The Students
        $total_students = array();
        for ($i = 0; $i < count($students); $i++) {
            if ($i == 0) {
                array_push($total_students, $students[$i]->student_id);
            } else {
                if (!in_array($students[$i]->student_id, $total_students)) {
                    array_push($total_students, $students[$i]->student_id);
                }
            }
        }
        // To Hold The Count Of The Array And Pass It As String
        $total_students = count($total_students);


        return view('center.show-trainers', compact('trainers', 'courses', 'admins', 'students', 'total_students'));
    }

    // To Show The Form Of Creating New Course
    public function create_course()
    {
        // All Trainers Who Belongs To The Center
        $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
        if (count($trainers) <= 0) {
            (['title' => 'لاتوجد دورات في النظام', 'error' => 'من فضلك قم بإضافة بعض الدورات لكي تتمكن من تعيين مدربين لها',]);
            return view("center.error-description", compact('trainers', 'admins', 'students', 'courses'))->withErrors(['title' => 'لايوجد مدربين في النظام', 'error' => 'من فضلك قم بإضافة بعض المدربين لكي تتمكن من إضافة الدورات']);
        }
        // All Admins Who Belongs To The Center
        $admins = Admin::where('center_id', Auth::user()->center->id)->get();
        // All Courses Which Belongs To The Center
        $courses = Course::where('center_id', Auth::user()->center->id)->get();
        // All Courses Id's Of The Courses Which Who Belongs To The Center
        $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
        // All Students Who Reserved A Course Of The Center
        $students = Reservation::find($course_id);
        // An Empty Array To Hold The Different Id's Of The Students
        $total_students = array();
        for ($i = 0; $i < count($students); $i++) {
            if ($i == 0) {
                array_push($total_students, $students[$i]->student_id);
            } else {
                if (!in_array($students[$i]->student_id, $total_students)) {
                    array_push($total_students, $students[$i]->student_id);
                }
            }
        }
        // To Hold The Count Of The Array And Pass It As String
        $total_students = count($total_students);

        // Get The First Cities The The Rest With Ajax Rexuest
        $cities = City::where('country_id', 1)->get();
        // Get All Countries
        $countries = Country::all();
        // Get All Categories
        $categories = Category::all();

        return view('center.create-course', compact('trainers', 'admins', 'students', 'cities', 'countries', 'categories', 'courses', 'total_students'));
    }

    // The Data Of Storing New Course Goes Here And The Process Happens Here
    public function store_course(Request $request)
    {
        // Getting Center Main Information
        $center = User::find(Auth::user()->id);
        // Trainers Array That Will Hold Ids Of The Trainers Who Belong To The Center
        $trainers_data = array();
        // Getting Trainers Information
        $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();

        // Making Sure That The Center Has Trainers
        if (count($trainers) <= 0) {
            abort(404);
        }
        // Fetching Trainers Data Into The Array
        foreach ($center->center->trainer as $data) {
            array_push($trainers_data, $data->user_id);
        }
        // Validating The Request Data
        $request->validate([
            // The Title Of The Course
            'title' => 'required|string|max:50|min:10|unique:courses,title',
            // the Category Of The Course
            'category' => 'required|integer|max:99|min:1|exists:categories,id',
            // The Template Of The Certificate Of The Course
            'template' => 'required|integer|max:3|min:1',
            // If The Course Is Visible To The Users
            'visible' => 'required|integer|max:2|min:1',
            // The City Of The Course
            'city' => 'required|integer|max:99|min:1|exists:cities,id',
            // The Country Of The City
            'country' => 'required|integer|max:99|min:1|exists:countries,id',
            // The Address Of tHE Course
            'address' => 'required|string|max:150|min:10',
            // The Location The Course On Google Map
            'location' => 'required|string|max:150|min:20',
            // The Description Of tHE Course
            'description' => 'required|string|max:200|min:50',
            //The Trainers Array Of The Course
            'trainer' => 'required|array|max:' . count($center->center->trainer),
            // The Trainers Array Data
            'trainer.*' => 'required|integer|distinct|' . Rule::in($trainers_data),
            // The Type Of Course Payed Or Free
            'type' => 'required|integer|max:2|min:1',
            //The Coupons Array Of The Course
            'coupon' => 'required_if:type,2',
            //The Coupons Array Data
            'coupon_code' => 'required_if:coupon,2|array',
            'coupon_discount' => 'required_if:coupon,2|array|size:' . count($request->coupon_code),
            // The Start Date Of The Course
            'start_date' => 'required|date',
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
            // The Cover And Image Of The Course
            'course-poster-1' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg|max:500',
            'course-poster-2' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg|max:500',
        ]);

        DB::beginTransaction();
        try {
            // Creating The New Course
            $course = Course::create([
                'title' => $request->title,
                'identifier' => Str::random(10),
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
            // Making Sure That The Data Has A Cover And Image For The Course
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
            // Storing The Course Trainers
            for ($i = 0; $i < count($request->trainer); $i++) {
                CourseTrainer::create([
                    'course_id' => $course->id,
                    'trainer_id' => $request->trainer[$i],
                ]);
            }
            // Storing The Course Coupons If The Type Is Payed
            if ($request->type == 2) {
                for ($i = 0; $i < count($request->coupon_code); $i++) {
                    Coupon::create([
                        'coupon_code' => $request->coupon_code[$i],
                        'course_id' => $course->id,
                        'discount' => $request->coupon_discount[$i],
                    ]);
                }
            }
            // Storing The Appointment Date Of The Course
            // If The Price Is Empty Course Is Free
            if (is_null($request->price)) {
                Appointment::create([
                    'course_id' => $course->id,
                    'start_date' => $request->start_date,
                    'finish_date' => $request->finish_date,
                    'end_reservation' => $request->end_reservation,
                    'start_time' => $request->start_time,
                    'attendance' => $request->attendance,
                    'price' => 0,
                    'gender' => $request->gender,
                ]);
            } else {
                Appointment::create([
                    'course_id' => $course->id,
                    'start_date' => $request->start_date,
                    'finish_date' => $request->finish_date,
                    'end_reservation' => $request->end_reservation,
                    'start_time' => $request->start_time,
                    'attendance' => $request->attendance,
                    'price' => $request->price,
                    'gender' => $request->gender,
                ]);
            }

            // Save The Changes If The Is No Errors
            DB::commit();

            return redirect()->route('center.course.create')->with('success', 'تم إضافة الدورة بنجاح');
        } catch (\Exception $e) {
            // Don't Save The Changes If The Is Errors
            DB::rollBack();
            return "Error";
        }
    }

    // To Show The Form Of Editing A Course
    public function edit_course()
    {

    }

    // The Data Of Updating A Course Goes Here And The Process Happens Here
    public function update_course()
    {

    }

    // To Show All Courses Which Belongs To The Center
    public function show_courses()
    {

        $courses = Course::where('center_id', Auth::user()->center->id)->get();
        $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
        $admins = Admin::where('center_id', Auth::user()->center->id)->get();
        $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
        $students = Reservation::find($course_id)->count();

        return view('center.show-courses', compact('courses', 'trainers', 'admins', 'students'));
    }

    // To Show The Form Of Creating New Admin
    public function create_admin()
    {
        $courses = Course::where('center_id', Auth::user()->id)->get();
        $trainers = Trainer::where('center_id', Auth::user()->id)->get();
        $admins = Admin::where('center_id', Auth::user()->id)->get();
        $course_id = Course::select('id')->where('center_id', Auth::user()->id)->get();
        $students = Reservation::find($course_id)->count();

        return view('center.create-admin', compact('courses', 'trainers', 'admins', 'students'));
    }

    // The Data Of Storing New Admin Goes Here And The Process Happens Here
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

    // To Show The Form Editing Admin
    public function edit_admin($id)
    {
        // The Data Of The Admin That Will Be Edited
        $admin = Admin::findorFail($id);
        if ($admin->center_id == Auth::user()->center->id) {
            // All Admins Who Belongs To The Center
            $admins = Admin::where('center_id', Auth::user()->center->id)->get();
            // All Courses Which Belongs To The Center
            $courses = Course::where('center_id', Auth::user()->center->id)->get();
            // All Trainers Who Belongs To The Center
            $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
            // All Courses Id's Of The Courses Which Who Belongs To The Center
            $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
            // All Students Who Reserved A Course Of The Center
            $students = Reservation::find($course_id);
            // An Empty Array To Hold The Different Id's Of The Students
            $total_students = array();
            for ($i = 0; $i < count($students); $i++) {
                if ($i == 0) {
                    array_push($total_students, $students[$i]->student_id);
                } else {
                    if (!in_array($students[$i]->student_id, $total_students)) {
                        array_push($total_students, $students[$i]->student_id);
                    }
                }
            }
            // To Hold The Count Of The Array And Pass It As String
            $total_students = count($total_students);
            return view('center.edit-admin', compact('admin', 'courses', 'trainers', 'admins', 'students', 'total_students'));
        } else {
            abort(404);
        }
    }

    // The Data Of Updating Admin Goes Here And The Process Happens Here
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

    // To Show All Admins Who Belongs To The Center
    public function show_admins()
    {
        // All Admins Who Belongs To The Center
        $admins = Admin::where('center_id', Auth::user()->center->id)->get();
        // All Courses Which Belongs To The Center
        $courses = Course::where('center_id', Auth::user()->center->id)->get();
        // All Trainers Who Belongs To The Center
        $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
        // All Courses Id's Of The Courses Which Who Belongs To The Center
        $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
        // All Students Who Reserved A Course Of The Center
        $students = Reservation::find($course_id);
        // An Empty Array To Hold The Different Id's Of The Students
        $total_students = array();
        for ($i = 0; $i < count($students); $i++) {
            if ($i == 0) {
                array_push($total_students, $students[$i]->student_id);
            } else {
                if (!in_array($students[$i]->student_id, $total_students)) {
                    array_push($total_students, $students[$i]->student_id);
                }
            }
        }
        // To Hold The Count Of The Array And Pass It As String
        $total_students = count($total_students);
        return view('center.show-admins', compact('admins', 'courses', 'trainers', 'students', 'total_students'));
    }

    // To Show The Form Of Assigning Course Admin
    public function assign_course_admin()
    {
        $courses = Course::where('center_id', Auth::user()->center->id)->get();
        $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
        $admins = Admin::where('center_id', Auth::user()->center->id)->get();
        $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
        $students = Reservation::find($course_id);

        if (count($courses) <= 0) {
            return view("center.error-description", compact('trainers', 'admins', 'students', 'courses'))->withErrors(['title' => 'لاتوجد دورات في النظام', 'error' => 'من فضلك قم بإضافة بعض الدورات لكي تتمكن من تعيين مدربين لها',]);
        } elseif (count($admins) <= 0) {
            return view("center.error-description", compact('trainers', 'admins', 'students', 'courses'))->withErrors(['title' => 'لايوجد مدراء في النظام', 'error' => 'من فضلك قم بإضافة بعض المدراء لكي تتمكن من تعيينهم مدربين للدورات',]);
        }

        $total_students = array();
        for ($i = 0; $i < count($students); $i++) {
            if ($i == 0) {
                array_push($total_students, $students[$i]->student_id);
            } else {
                if (!in_array($students[$i]->student_id, $total_students)) {
                    array_push($total_students, $students[$i]->student_id);
                }
            }
        }
        $total_students = count($total_students);

        return view('center.assign-course-admin', compact('courses', 'trainers', 'admins', 'students', 'total_students'));
    }

    // The Data Of Assigning Course Admin Goes Here And The Process Happens Here
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
            array_push($admin_data, $admin->id);
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
            'admin_id' => $request->admin,
            'role_id' => $request->role,
        ]);

        return redirect()->route('center.course.admin.assign')->with('success', 'تم تعيين المسؤول بنجاح');
    }

    public function contact_us(){

    }

    public function about_us(){

    }

}
