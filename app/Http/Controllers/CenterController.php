<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Attendance;
use App\Bank;
use App\Category;
use App\Center;
use App\CenterAccount;
use App\CenterSocialMedia;
use App\Certificate;
use App\City;
use App\Country;
use App\Coupon;
use App\Course;
use App\CourseAdmin;
use App\CourseTrainer;
use App\Halalah;
use App\Image;
use App\Nationality;
use App\Reservation;
use App\SocialMedia;
use App\Title;
use App\Trainer;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class CenterController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth-center')->except([['register']]);
    }

    // This Function Returns An Error Page
    private function error_page($title, $message)
    {
        $total_courses = $this->get_center_courses();
        $total_trainers = $this->get_center_trainers();
        $total_admins = $this->get_center_admins();
        $total_students = $this->get_center_students();

        return view('center.error-description', compact('total_courses', 'total_trainers', 'total_admins', 'total_students'))->withErrors(['title' => $title, 'error' => $message]);
    }

    // This Function Checks For The Role Id And Returns An Error Page For Other User But Center
    private function external_error_page()
    {
        $title = "خطأ";
        $message = "صلاحياتك لاتسمح لك بالوصول للصفحة المطلوبة";
        $role_id = Auth::user()->role_id;
        switch ($role_id) {
            case 1:
                return redirect()->route("administrator.error-description")->withErrors(['title' => $title, 'error' => $message]);
                break;

            case 3:
                return redirect()->route("admin.error-description")->withErrors(['title' => $title, 'error' => $message]);
                break;

            case 4:
                return redirect()->route("admin.error-description")->withErrors(['title' => $title, 'error' => $message]);
                break;

            case 5:
                return redirect()->route('account.error.description')->withErrors(['title' => $title, 'error' => $message]);
                break;
        }

    }

    // This Function Returns The Amount Of Trainers Of One Course
    private function get_center_trainers()
    {
        if ($this->check_authentication()) {
            // All Trainers Who Belongs To The Center
            $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
            return count($trainers);
        } else {
            return 0;
        }
    }

    // This Function Returns The Amount Of Admins Of One Course
    private function get_center_admins()
    {
        if ($this->check_authentication()) {
            // All Admins Who Belongs To The Center
            $admins = Admin::where('center_id', Auth::user()->center->id)->get();
            return count($admins);
        } else {
            return 0;
        }
    }

    // This Function Returns The Amount Of Courses Of One Course
    private function get_center_courses()
    {
        if ($this->check_authentication()) {
            // All Courses Which Belongs To The Center
            $courses = Course::where('center_id', Auth::user()->center->id)->get();
            return count($courses);
        } else {
            return 0;
        }
    }

    // This Function Returns The Amount Of Students Of One Course
    private function get_center_students()
    {
        if ($this->check_authentication()) {
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
            return count($total_students);
        } else {
            return 0;
        }
    }

    // This Function Checks If User Is Authenticated Or Not And If The Username If Valid
    private function check_authentication_username($username)
    {
        if (Auth::check() && $username == Auth::user()->username && Auth::user()->role_id == 2) {
            return true;
        } else {
            return false;
        }
    }

    // This Function Checks If User Is Authenticated Or Not
    private function check_authentication()
    {
        if (Auth::check() && Auth::user()->role_id == 2) {
            return true;
        } else {
            return false;
        }
    }

    // This Function Is The Main Page After Login
    public function index($center)
    {

        if ($this->check_authentication_username($center)) {

            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            $all_courses = Course::where('center_id', Auth::user()->center->id)->get();
            $all_admins = Admin::where('center_id', Auth::user()->center->id)->get();
            $all_trainers = Trainer::where('center_id', Auth::user()->center->id)->get();

            return view('center.index', compact('all_courses', 'all_admins', 'all_trainers', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns The View Of Registering New Center
    public function register()
    {
        $banks = Bank::all();
        $countries = Country::all();
        $cities = City::where('country_id', 1)->get();
        return view('center.register', compact('countries', 'banks', 'cities'));
    }

    // This Function Handle The Data Of Registering
    public function store(Request $request)
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
                'center_type' => 'required|integer|max:1|min:0',
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
                'center_type' => 'required|integer|max:1|min:0',
                'about' => 'required|string|max:200',
                'website' => 'nullable|string|regex:/www[.]+([a-zA-z]{1,20})+[.](com|org|net|edu|biz{3})/|max:50|min:10',
                'profile-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
            ]);

        }

        DB::beginTransaction();

        try {

            $user = User::create([
                'email' => $request->email,
                'phone' => $request->phone,
                'username' => $request->username,
                'role_id' => 2,
                'password' => Hash::make($request->password),
            ]);


            $file = $request->file('profile-image')->store('public/center-images');
            $file_name = basename($file);
            $image = $file_name;


            $center = Center::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'city_id' => $request->city,
                'type' => $request->center_type,
                'about' => $request->about,
                'website' => $request->website,
                'image' => $image,
                'verification_code' => $request->verification_code,
                'verification_authority' => $request->verification_authority,
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

            auth()->login($user);
            return redirect()->route('center.index', $request->username);

        } catch (\Exception $e) {
            // something went wrong
            DB::rollback();
            return redirect()->route('center.register')->withErrors(['هناك خطأ تقني الرجاء التواصل مع إدارة الموقع'])->withInput()->exceptInput('profile-image');
        }

    }

    // This Function Returns A View With A Specific Admin Information
    public function show_admin_details($username)
    {

    }

    // This Function Returns A View With Center Information To Be Edit
    public function edit()
    {
        if ($this->check_authentication()) {
            // The Center That Will Be Edited
            $user = User::find(Auth::user()->center->user_id);
            // Get All Banks
            $banks = Bank::all();
            // Get All Countries
            $countries = Country::all();
            // All Cities
            $cities = City::where('country_id', $user->center->city->country_id)->get();

            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_admins();
            $total_students = $this->get_center_students();
            return view('center.edit-center', compact('user', 'banks', 'countries', 'cities', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));
        } else {
            return $this->external_error_page();
        }
    }

    // This Function Handle The Data Of Editing Center Information
    public function update(Request $request)
    {

        if ($this->check_authentication()) {
            $counter = 0;
            $user = User::find(Auth::user()->center->user_id);

            if ($user->center->name != $request->name) {
                $request->validate([
                    'name' => 'required|string|max:30|min:5',
                ]);

                $user->center->name = $request->name;
                $counter++;
            }

            if ($user->center->city_id != $request->city) {
                $request->validate([
                    'city' => 'required|integer|exists:cities,id',
                ]);

                $user->center->city_id = $request->city;
                $counter++;
            }

            if ($user->email != $request->email) {
                $request->validate([
                    'email' => 'required|email|max:100',
                ]);

                $user->email = $request->email;
                $counter++;
            }

            if ($user->phone != $request->phone) {
                $request->validate([
                    'phone' => 'required|string|max:15|starts_with:+966',
                ]);

                $user->phone = $request->phone;
                $counter++;
            }

            if ($user->username != $request->username) {
                $request->validate([
                    'username' => 'required|string|max:20|min:5|unique:users,email',
                ]);

                $user->username = $request->username;
                $counter++;
            }

            if ($user->center->about != $request->about) {

                $request->validate([
                    'about' => 'required|max:200|min:7|string|',
                ]);

                $user->center->about = $request->about;
                $counter++;
            }

            if ($user->center->website != $request->website) {
                $request->validate([
                    'website' => 'required|string|max:60|min:10|',
                ]);

                $user->center->website = $request->website;
                $counter++;
            }


            if ($request->hasFile('profile-cover')) {

                $request->validate([
                    'profile-cover' => 'sometimes|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                ]);

                $counter++;
                if (file_exists('storage/center-images/' . $user->center->cover)) {
                    if (Storage::delete('public/center-images/' . $user->center->cover)) {
                        $file = $request->file('profile-cover')->store('public/center-images');
                        $file_name = basename($file);
                        $user->center->cover = $file_name;
                    }
                } else {
                    $file = $request->file('profile-cover')->store('public/center-images');
                    $file_name = basename($file);
                    $user->center->cover = $file_name;
                }

            }

            if ($request->hasFile('profile-image')) {

                $request->validate([
                    'profile-image' => 'sometimes|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                ]);

                $counter++;
                if (file_exists('public/center-images/' . $user->center->logo)) {
                    if (Storage::delete('public/center-images/' . $user->center->logo)) {
                        $file = $request->file('profile-image')->store('public/center-images');
                        $file_name = basename($file);
                        $user->center->image = $file_name;
                    }
                } else {
                    $file = $request->file('profile-image')->store('public/center-images');
                    $file_name = basename($file);
                    $user->center->image = $file_name;
                }

            }

            if ($user->center->verification_code != $request->verification_code) {
                $request->validate([
                    'verification_code' => 'required|integer|max:10|min:4|',
                ]);

                $user->center->verification_code = $request->verification_code;
                $counter++;
            }

            if ($user->center->verification_authority != $request->verification_authority) {
                $request->validate([
                    'verification_authority' => 'required|string|max:50|min:10',
                ]);

                $user->center->verification_authority = $request->verification_authority;
                $counter++;
            }

            if ($counter > 0) {
                $user->save();
                $user->center->save();
            } else {
                return redirect()->route('center.edit')->withErrors(['قم بتحديث بعض الحقول لكي يتم حفظها', 'لم يتم تحديث اي حقل']);
            }

            return redirect()->route('center.edit')->with('success', 'تم تعديل البيانات بنجاح');

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Delete A Course
    public function destroy($id)
    {

    }

    // This Function Returns The View Of Login
    public function login()
    {
        return view('center.login');
    }

    // This Function Returns The View Of Creating Trainer
    public function create_trainer()
    {
        if ($this->check_authentication()) {

            $nationalities = Nationality::all();
            $titles = Title::all();

            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            return view('center.create-trainer', compact('nationalities', 'titles', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Handles The Process Of Creating Trainer
    public function store_trainer(Request $request)
    {

        if ($this->check_authentication()) {

            $request->validate([
                'name' => 'required|string|max:20|min:5|unique:trainers,name',
                'phone' => 'required|starts_with:5|digits:9|unique:users,phone',
                'username' => 'required|string|max:20|:min:5|unique:users,username',
                'email' => 'required|string|max:100|email|unique:users,email',
                'password' => 'required|string|max:32|min:6|confirmed',
                'status' => 'required|integer|max:1|min:0',
                'title' => 'required|integer|exists:titles,id',
                'nationality' => 'required|integer|exists:nationalities,id',
                'profile-image' => 'required|image|mimetypes:image/png|max:400',
            ]);

            DB::beginTransaction();

            try {

                $user = User::create([
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'username' => $request->username,
                    'role_id' => 4,
                    'status' => $request->status,
                    'password' => Hash::make($request->password),
                ]);

                $file = $request->file('profile-image')->store('public/trainer-images');
                $file_name = basename($file);

                Trainer::create([
                    'user_id' => $user->id,
                    'center_id' => Auth::user()->center->id,
                    'title_id' => $request->title,
                    'name' => $request->name,
                    'image' => $file_name,
                    'nationality_id' => $request->nationality,
                ]);

                DB::commit();
                return redirect()->route('center.trainer.create')->with('success', 'تم إضافة المدرب بنجاح');

            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('center.trainer.create')->withErrors(['هناك خطأ تقني الرجاء التواصل مع إدارة الموقع']);
            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns The View Of Editing Trainer
    public function edit_trainer($id)
    {

        if ($this->check_authentication()) {

            // The Trainer That Will Be Edited
            $trainer = Trainer::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (empty($trainer)) {

                return $this->error_page('لايوجد مدربيين في النظام', 'من فضلك قم بالتأكد من معرف المدرب المراد تعديل بياناته');

            } else {

                // Get All Titles To Chose One Of Them
                $titles = Title::all();
                // Get All Nationalities To Chose One Of Them
                $nationalities = Nationality::all();

                // All Courses Which Belongs To The Center
                $total_courses = $this->get_center_courses();
                // All Trainers Who Belongs To The Center
                $total_trainers = $this->get_center_trainers();
                // All Admins Who Belongs To The Center
                $total_admins = $this->get_center_admins();
                // All Students Who Reserved A Course Of The Center
                $total_students = $this->get_center_students();

                return view('center.edit-trainer', compact('trainer', 'titles', 'nationalities', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));

            }

        } else {
            return $this->external_error_page();
        }

    }

    // This FUnction Handles The Process Of Editing Trainer
    public function update_trainer(Request $request, $id)
    {

        if ($this->check_authentication()) {

            $trainer = Trainer::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (empty($trainer)) {

                return redirect()->route('center.admin.edit', $id)->withErrors(['لايوجد مدربيين في النظام', 'الرجاء قم بالتأكد من وجود مدربيين مسجلين في النظام']);

            } else {

                $counter = 0;

                if ($trainer->name != $request->name) {
                    $request->validate([
                        'name' => 'required|string|max:50|min:10|unique:trainers,name',
                    ]);

                    $trainer->name = $request->name;
                    $counter++;
                }

                if ($trainer->user->username != $request->username) {
                    $request->validate([
                        'username' => 'required|string|max:20|:min:5|unique:users,username',
                    ]);

                    $trainer->user->username = $request->username;
                    $counter++;
                }

                if ($trainer->user->phone != $request->phone) {
                    $request->validate([
                        'phone' => 'required|string|starts_with:05|max:10|min:9|unique:users,phone',
                    ]);

                    $trainer->user->phone = $request->phone;
                    $counter++;
                }

                if ($trainer->user->email != $request->email) {
                    $request->validate([
                        'email' => 'required|string|email|max:100|unique:users,email',
                    ]);

                    $trainer->user->email = $request->email;
                    $counter++;
                }

                if ($trainer->user->status != $request->status) {
                    $request->validate([
                        'status' => 'required|integer|max:1|min:0',
                    ]);

                    $trainer->user->status = $request->status;
                    $counter++;
                }


                if ($trainer->title_id != $request->title) {

                    $request->validate([
                        'title' => 'required|integer|exists:titles,id',
                    ]);

                    $trainer->title_id = $request->title;
                    $counter++;
                }

                if ($trainer->nationality_id != $request->nationality) {

                    $request->validate([
                        'nationality' => 'required|integer|exists:nationalities,id',
                    ]);

                    $trainer->nationality_id = $request->nationality;
                    $counter++;
                }

                if ($request->hasFile('profile-image')) {

                    $request->validate([
                        'profile-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                    ]);

                    if (file_exists('storage/trainer-images/' . $trainer->image)) {
                        if (Storage::delete('public/trainer-images/' . $trainer->image)) {
                            $file = $request->file('profile-image')->store('public/trainer-images');
                            $file_name = basename($file);
                            $trainer->image = $file_name;
                        }
                    } else {
                        $file = $request->file('profile-image')->store('public/trainer-images');
                        $file_name = basename($file);
                        $trainer->image = $file_name;
                    }
                    $counter++;

                }

                if ($counter == 0) {
                    return redirect()->route('center.trainer.edit', $trainer->id)->withErrors(['لم يتم التعديل على اي حقل', 'الرجاء تعديل بعض الحقول لكي يتم حفظها']);
                } else {
                    $trainer->save();
                    $trainer->user->save();
                    return redirect()->route('center.trainer.edit', $trainer->id)->with('success', 'تم تعديل البيانات بنجاح');
                }

            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns A View With All Trainers
    public function show_trainers()
    {

        if ($this->check_authentication()) {

            // Courses Which Belongs To The Center
            $total_courses = $this->get_center_courses();
            // Trainers Who Belongs To The Center
            $total_trainers = $this->get_center_trainers();
            // Admins Who Belongs To The Center
            $total_admins = $this->get_center_admins();
            //Students Who Reserved A Course Of The Center
            $total_students = $this->get_center_students();

            $all_trainers = Trainer::where('center_id', Auth::user()->center->id)->get();

            return view('center.show-trainers', compact('total_courses', 'total_trainers', 'total_admins', 'total_students', 'all_trainers'));

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns A View Of Creating Course
    public function create_course()
    {

        if ($this->check_authentication()) {

            // All Courses Which Belongs To The Center
            $total_courses = $this->get_center_courses();
            // All Trainers Who Belongs To The Center
            $total_trainers = $this->get_center_trainers();
            // All Admins Who Belongs To The Center
            $total_admins = $this->get_center_admins();
            // All Students Who Reserved A Course Of The Center
            $total_students = $this->get_center_students();


            if ($total_trainers < 1) {
                return view("center.error-description", compact('total_courses', 'total_trainers', 'total_admins', 'total_students'))->withErrors(['title' => 'لايوجد مدربين في النظام', 'error' => 'من فضلك قم بإضافة بعض المدربين لكي تتمكن من إضافة الدورات']);
            } else {

                // Get The First Cities The The Rest With Ajax Rexuest
                $cities = City::where('country_id', 1)->get();
                // Get All Countries
                $countries = Country::all();
                // Get All Categories
                $categories = Category::all();

                $all_trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
                return view('center.create-course', compact('all_trainers', 'countries', 'cities', 'categories', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));
            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Handles The Process Of Creating Course
    public function store_course(Request $request)
    {
        if ($this->check_authentication()) {


            // Trainers Array That Will Hold Ids Of The Trainers Who Belong To The Center
            $trainers_data = array();
            // Getting Trainers Information
            $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();

            // Making Sure That The Center Has Trainers
            if (count($trainers) < 1) {
                return $this->error_page('خطأ', 'لايوجد مدربين مسجلين في النظام لذا لايمكنك إضافة دورات');
            } else {



                // Fetching Trainers Data Into The Array
                foreach (Auth::user()->center->trainer as $trainer) {
                    array_push($trainers_data, $trainer->id);
                }


                $max_min_women = ($request->attendance - $request->men_amount);

                if ( is_null($request->coupon_code) ){
                    $coupon_code = 0;
                }else{
                    $coupon_code = count($request->coupon_code);
                }

                // Validating The Request Data
                $request->validate([
                    // The Title Of The Course
                    'title' => 'required|string|max:50|min:10',
                    // the Category Of The Course
                    'category' => 'required|integer|exists:categories,id',
                    // If The Course Is Visible To The Users
                    'visible' => 'required|integer|max:1|min:0',
                    // The Template Of The Certificate Of The Course
                    'template' => 'required|integer|max:3|min:1',
                    // The Country Of The City
                    'country' => 'required|integer|exists:countries,id',
                    // The City Of The Course
                    'city' => 'required|integer|exists:cities,id',
                    // The Address Of tHE Course
                    'address' => 'required|string|max:150|min:10',
                    // The Location The Course On Google Map
                    'location' => 'required|string|max:150|min:20',
                    // The Cover And Image Of The Course
                    'course-image-1' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg|max:400',
                    'course-image-2' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg|max:400',
                    // The Description Of The Course
                    'description' => 'required|string|max:200|min:50',
                    //The Trainers Array Of The Course
                    'trainer' => 'required|array|max:' . count(Auth::user()->center->trainer),
                    // The Trainers Array Data
                    'trainer.*' => 'required|integer|distinct|' . Rule::in($trainers_data),
                    // The Type Of Course Payed Or Free
                    'type' => 'required|integer|max:1|min:0',
                    //The Coupons Indicator Of The Coupons
                    'coupon' => 'required_if:type,1|integer|max:1|min:0',
                    //The Coupons Array Data
                    'coupon_code' => 'required_if:coupon,1|array',
                    'coupon_code.*' => 'required|string|distinct',
                    'coupon_discount' => 'required_if:coupon,1|array|size:' . $coupon_code,
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
                    'price' => 'required_if:type,1|digits_between:1,4',
                    // The Attendance Gender
                    'gender' => 'required|integer|max:3|min:1',

                    // Attendance Amount Base On Gender
                    'men_amount' => 'required_if:gender,3|integer|max:'.$request->attendance.'|min:0',
                    'women_amount' => 'required_if:gender,3|integer||max:'.$max_min_women.'|min:'.$max_min_women,

                    // Total Hours Of The Course
                    'hours' => 'required|digits_between:1,4|',
                    // The Activation of The Course
                    'activation' => 'required|integer|max:1|min:1',

                ]);

                DB::beginTransaction();

                try {

                    if (is_null($request->price)) {
                        $price = 0;
                    } else {
                        $price = $request->price;
                    }

                    if ($request->type == 0) {
                        $type = 'free';
                    } else {
                        $type = 'payed';
                    }

                    if (is_null($request->coupon)) {
                        $coupon = 0;
                    } else {
                        $coupon = $request->coupon;
                    }

                    if ($request->gender == 1) {
                        $men = $request->attendance;
                        $women = 0;
                    } elseif ($request->gender == 2) {
                        $men = 0;
                        $women = $request->attendance;
                    } else {
                        $men = $request->men_amount;
                        $women = $request->women_amount;
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
                        'hours' => $request->hours,
                        'end_reservation' => $request->end_reservation,
                        'attendance' => $request->attendance,
                        'gender' => $request->gender,
                        'men' => $men,
                        'women' => $women,
                        'coupon' => $coupon,
                        'category_id' => $request->category,
                        'city_id' => $request->city,
                        'template_id' => $request->template,
                        'center_id' => Auth::user()->center->id,
                        'visible' => $request->visible,
                        'description' => $request->description,
                        'validation' => 0,
                        'activation' => $request->activation,

                    ]);

                    // Making Sure That The Data Has A Cover And Image For The Course
                    if ($request->hasFile('course-image-1') && $request->hasFile('course-image-2')) {

                        $file = $request->file('course-image-1')->store('public/course-images');
                        $file_name = basename($file);

                        $file_2 = $request->file('course-image-2')->store('public/course-images');
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
                    if ($request->coupon == 1) {
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

                    return redirect()->route('center.course.create')->with('success', 'تم إضافة الدورة بنجاح');
                } catch (\Exception $e) {
                    // Don't Save The Changes If The Is Errors
                    DB::rollBack();
                    return redirect()->route('center.course.create')->withErrors(['هناك خطأ تقني الرجاء التواصل مع إدارة الموقع'])->withInput();

                }

            }

        } else {
            return $this->external_error_page();
        }
    }

    // This Function Returns A View With The Course That Will Be Edited
    public function course_edit($identifier)
    {

        if ($this->check_authentication()) {

            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();

            if (empty($course)) {
                return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");
            } else {
                $categories = Category::all();
                $countries = Country::all();
                $cities = City::all();
                $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();


                // Courses Which Belongs To The Center
                $total_courses = $this->get_center_courses();
                // Trainers Who Belongs To The Center
                $total_trainers = $this->get_center_trainers();
                // Admins Who Belongs To The Center
                $total_admins = $this->get_center_admins();
                //Students Who Reserved A Course Of The Center
                $total_students = $this->get_center_students();

                return view('center.edit-course', compact('course', 'categories', 'countries', 'cities', 'trainers', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));
            }

        } else {
            return $this->external_error_page();
        }
    }

    // This Function Handles The Process Of Editing Course
    public function course_update(Request $request, $identifier)
    {

        if ($this->check_authentication()) {

            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();
            if (empty($course)) {
                return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");
            } else {

                // Getting Center Main Information
                $center = Center::find(Auth::user()->center->id);
                // Trainers Array That Will Hold Ids Of The Trainers Who Belong To The Center
                $trainers_data = array();
                // Getting Trainers Information
                $trainers = Trainer::where('center_id', $center->id)->get();

                // Making Sure That The Center Has Trainers
                if (count($trainers) < 1) {
                    return $this->error_page("خطأ", "لايمكنك إنشاء دورة من دون مدربين");
                }
                // Fetching Trainers Data Into The Array
                foreach ($center->trainer as $trainer) {
                    array_push($trainers_data, $trainer->id);
                }

                $counter = 0;

                if ($course->title != $request->title) {
                    $request->validate([
                        // The Title Of The Course
                        'title' => 'required|string|max:50|min:10',
                    ]);
                    $course->title = $request->title;
                    $counter++;
                }

                if ($course->category_id != $request->category) {
                    $request->validate([
                        // the Category Of The Course
                        'category' => 'required|integer|max:99|min:1|exists:categories,id',
                    ]);
                    $course->category_id = $request->category;
                    $counter++;
                }

                if ($course->visible != $request->visible) {
                    $request->validate([
                        // If The Course Is Visible To The Users
                        'visible' => 'required|integer|max:2|min:1',
                    ]);
                    $course->visible = $request->visible;
                    $counter++;
                }

                if ($course->template_id != $request->template) {
                    $request->validate([
                        // The Template Of The Certificate Of The Course
                        'template' => 'required|integer|max:3|min:1',
                    ]);
                    $course->template_id = $request->template;
                    $counter++;
                }

                if ($course->city_id != $request->city) {
                    $request->validate([
                        // The Country Of The City
                        'country' => 'required|integer|exists:countries,id',
                        // The City Of The Course
                        'city' => 'required|integer|exists:cities,id',
                    ]);
                    $course->city_id = $request->city;
                    $counter++;
                }

                if ($course->address != $request->address) {
                    $request->validate([
                        // The Address Of tHE Course
                        'address' => 'required|string|max:150|min:10',
                    ]);
                    $course->address = $request->address;
                    $counter++;
                }


                if ($course->location != $request->location) {
                    $request->validate([
                        // The Location The Course On Google Map
                        'location' => 'required|string|max:150|min:20',
                    ]);
                    $course->location = $request->location;
                    $counter++;
                }

                if ($course->description != $request->description) {
                    $request->validate([
                        // The Description Of The Course
                        'description' => 'required|string|max:200|min:10',
                    ]);
                    $course->description = $request->description;
                    $counter++;
                }

                if ($course->type != $request->type) {
                    $request->validate([
                        // The Type Of Course Payed Or Free
                        'type' => 'required|string|' . Rule::in(['payed', 'free']),
                    ]);
                    $course->type = $request->type;
                    $counter++;
                }

                // Checking If There Are Changes In The Coupons List
                // If The Coupon Parameter Is Null The Course iS Free Then Check If There Are Old Coupons For The Course
                if (is_null($request->coupon)) {
                    if ($course->coupon != 0) {
                        $course->coupon = 0;
                        for ($i = 0; $i < count($course->discountCoupon); $i++) {
                            $course->discountCoupon[$i]->delete();
                        }
                        $counter++;
                    }
                } else { // If The Coupon Parameter Is Not Empty

                    $request->validate([
                        //The Coupons Indicator Of The Coupons
                        'coupon' => 'required_if:type,payed|integer|max:1|min:0',
                        //The Coupons Array Data
                        'coupon_code' => 'required_if:coupon,2|array',
                        'coupon_code.*' => 'required|string|distinct',
                        'coupon_discount' => 'required_if:coupon,2|array|size:' . count($request->coupon_code),
                        'coupon_discount.*' => 'required|integer',
                    ]);

                    if (count($request->coupon_code) > count($course->discountCoupon)) { // If The Coupon Parameter Count Greater Than The Old Coupon Count, We Need To Add The New One

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

                    } elseif (count($request->coupon_code) < count($course->discountCoupon)) { // If The Coupon Parameter Count Less Than The Old Coupon Count, We Need To Delete One

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

                    } else { // If The Coupon Parameter Count Equal The Old Coupon Count, We Need To Check If There Are Changes
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

                $total_trainers = Trainer::where('center_id', Auth::user()->center->id)->get();

                // Checking If There Are Changes In The Trainer List
                if (count($course->trainer) == count($total_trainers)) {

                    // Checking If The Trainers Count In The Request Are Greater Than The Total Trainers Of The Center
                    if (count($request->trainer) > count($total_trainers)) {
                        return redirect()->route('admin.course.edit', $course->id)->withErrors(['لا يمكنك إضافة مدربين ليسوا مسجلين في النظام']);
                    } elseif (count($request->trainer) < 1) { // Checking If The Trainers Count In The Request Are Less Than 1 Or Equal To 0
                        return redirect()->route('admin.course.edit', $course->id)->withErrors(['لا يمكنك حذف كافة المدربين من الدورة']);
                    } else {

                        $request->validate([
                            //The Trainers Array Of The Course
                            'trainer' => 'required|array|max:' . count($center->trainer) . 'min:' . count($center->trainer),
                            // The Trainers Array Data
                            'trainer.*' => 'required|integer|distinct|' . Rule::in($trainers_data),
                        ]);

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
                                $counter++;
                            }


                        }


                    }


                }

                // Checking If The Request Has An Image
                if ($request->hasFile('course-poster-1')) {

                    $request->validate([
                        // The Cover And Image Of The Course
                        'course-poster-1' => 'nullable|image|mimetypes:image/png,image/jpg,image/jpeg|max:500',
                    ]);

                    if (file_exists('storage/course-images/', $course->image[0]->image)) {
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

                    $request->validate([
                        // The Cover And Image Of The Course
                        'course-poster-2' => 'nullable|image|mimetypes:image/png,image/jpg,image/jpeg|max:500',
                    ]);

                    if (file_exists('storage/course-images/', $course->image[1]->image)) {
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
                    $request->validate([
                        // The Start Date Of The Course
                        'start_date' => 'required|date|after_or_equal:' . date('Y-m-d'),
                    ]);
                    $course->start_date = $request->start_date;
                    $counter++;
                }


                if ($course->end_date != $request->end_date) {
                    $request->validate([
                        // The Finish Date Of The Course
                        'end_date' => 'required|date|after_or_equal:' . $request->start_date,
                    ]);
                    $course->end_date = $request->end_date;
                    $counter++;
                }

                if ($course->end_reservation != $request->end_reservation) {
                    $request->validate([
                        // The Deadline Of Reservation
                        'end_reservation' => 'required|date|before_or_equal:' . $request->start_date,
                    ]);
                    $course->end_reservation = $request->end_reservation;
                    $counter++;
                }

                if ($course->start_time != $request->start_time . ":00") {
                    $request->validate([
                        // The Start Time Of The Course
                        'start_time' => ['required', 'regex:/(^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$)/', 'string', 'max:5', 'min:5'],
                    ]);
                    $course->start_time = $request->start_time;
                    $counter++;
                }

                if ($course->attendance != $request->attendance) {

                    $reservation_count = 0;
                    foreach ($course->reservation as $reservation) {
                        if ($reservation->confirmation == 1) {
                            $reservation_count++;
                        }
                    }

                    $request->validate([
                        // The Total Attendance Of The Course
                        'attendance' => 'required|integer|min:' . $reservation_count,
                    ]);

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

                        $request->validate([
                            // The Price Of The Course
                            'price' => 'required_if:type,2|digits_between:1,4',
                        ]);

                        $course->price = $request->price;
                        $counter++;
                    }
                }

                if ($course->gender != $request->gender) {
                    $request->validate([
                        // The Attendance Gender
                        'gender' => 'required|integer|max:3|min:1|',
                    ]);

                    $course->gender = $request->gender;
                    $counter++;
                }


                if ($counter == 0) {
                    return redirect()->route('center.course.edit', $identifier)->withErrors(['قم بتحديث بعض الحقول لكي يتم حفظها']);
                }else{
                    $course->save();
                    return redirect()->route('center.course.edit', $identifier)->with('success', 'تم تحديث معلومات الدورة بنجاح');
                }


            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns A View With Course Information
    public function show_courses($type)
    {
        $types = array(
            "Course",
            "Student",
            "Payment",
            "Attendance",
            "Certificate",
            "TakeAttendance",
            "GenerateCertificate",
        );

        if (!in_array($type, $types)) {
            $type = "Course";
        }

        if ($this->check_authentication()) {

            // Courses Which Belongs To The Center
            $total_courses = $this->get_center_courses();
            // Trainers Who Belongs To The Center
            $total_trainers = $this->get_center_trainers();
            // Admins Who Belongs To The Center
            $total_admins = $this->get_center_admins();
            //Students Who Reserved A Course Of The Center
            $total_students = $this->get_center_students();

            $courses = Course::where('center_id', Auth::user()->center->id)->get();

            return view('center.show-courses', compact('courses', 'total_courses', 'total_trainers', 'total_admins', 'total_students', 'type'));

        } else {
            return $this->external_error_page();
        }
    }

    // This Function Preview The Course For The Center In New Page
    public function course_preview($identifier)
    {

        if ($this->check_authentication()) {

            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();

            if (empty($course)) {
                return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");
            } else {
                $date1 = date_create($course->start_date);
                $date2 = date_create($course->end_date);
                $diff = date_diff($date1, $date2);
                $days = $diff->format("%a");

                return view('center.course-preview', compact('course', 'days'));
            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns A View Of Creating Admin
    public function create_admin()
    {
        if ($this->check_authentication()) {
            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            return view('center.create-admin', compact('total_courses', 'total_trainers', 'total_admins', 'total_students'));
        } else {
            return $this->external_error_page();
        }
    }

    // The Data Of Storing New Admin Goes Here And The Process Happens Here
    public function store_admin(Request $request)
    {

        if ($this->check_authentication()) {

            $request->validate([
                'name' => 'required|string|max:50|min:6|unique:admins,name',
                'phone' => 'required|starts_with:5|max:9|min:9|unique:users,phone',
                'username' => 'required|string|max:20|:min:5|unique:users,username',
                'email' => 'required|string|email|unique:users,email',
                'status' => 'required|integer|max:1|min:0',
                'password' => 'required|string|max:32|min:8|confirmed',
                'profile-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
            ]);

            DB::beginTransaction();

            try {

                $user = User::create([
                    'username' => $request->username,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'status' => $request->status,
                    'role_id' => 3,
                ]);

                $file = $request->file('profile-image')->store('public/admin-images');
                $file_name = basename($file);

                Admin::create([
                    'name' => $request->name,
                    'user_id' => $user->id,
                    'center_id' => Auth::user()->center->id,
                    'image' => $file_name,
                ]);

                DB::commit();
                return redirect()->route('center.admin.create')->with('success', 'تم إضافة المسؤول بنجاح');

            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('center.admin.create')->withErrors(['لم يتم إضافة المدرب', 'الرجاء المحاولة مجددا'])->withInput();
            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns A View With Admin Information That Will Be Edit
    public function edit_admin($id)
    {

        if ($this->check_authentication()) {

            // The Data Of The Admin That Will Be Edited
            $admin = Admin::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (empty($admin)) {
                return $this->error_page('لايوجد مسؤول مسجل في النظام', 'من فضلك قم بالتأكد من معرف المسؤول المراد تعديل بياناته');
            } else {
                // All Courses Which Belongs To The Center
                $total_courses = $this->get_center_courses();
                // All Admins Who Belongs To The Center
                $total_admins = $this->get_center_admins();
                // All Trainers Who Belongs To The Center
                $total_trainers = $this->get_center_trainers();
                // All Students Who Reserved A Course Of The Center
                $total_students = $this->get_center_students();

                return view('center.edit-admin', compact('admin', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));
            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Handles The Process Of Editing Admin
    public function update_admin(Request $request, $id)
    {

        if ($this->check_authentication()) {

            $admin = Admin::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (empty($admin)) {

                return $this->error_page('لايوجد مسؤول مسجل في النظام', 'الرجاء قم بالتأكد من وجود مسؤولين مسجلين في النظام');

            } else {

                $counter = 0;

                if ($admin->user->name != $request->name) {
                    $request->validate([
                        'name' => 'required|string|max:50|min:5|unique:admins,name',
                    ]);

                    $admin->name = $request->name;
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
                        'phone' => 'required|starts_with:+966|max:15|min:15|unique:users,phone',
                    ]);

                    $admin->user->phone = $request->phone;
                    $counter++;
                }

                if ($admin->user->email != $request->email) {
                    $request->validate([
                        'email' => 'required|string|email|max:100|unique:users,email',
                    ]);

                    $admin->user->email = $request->email;
                    $counter++;
                }

                if ($admin->user->status != $request->status) {
                    $request->validate([
                        'status' => 'required|integer|max:1|min:0',
                    ]);

                    $admin->user->status = $request->status;
                    $counter++;
                }

                if ($request->hasFile('profile-image')) {
                    $request->validate([
                        'profile-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                    ]);

                    if (file_exists('storage/trainer-images/' . $admin->image)) {
                        if (Storage::delete('public/trainer-images/' . $admin->image)) {
                            $file = $request->file('profile-image')->store('public/trainer-images');
                            $file_name = basename($file);
                            $admin->image = $file_name;
                        }
                    } else {
                        $file = $request->file('profile-image')->store('public/trainer-images');
                        $file_name = basename($file);
                        $admin->image = $file_name;
                    }
                    $counter++;

                }

                if ($counter == 0) {
                    return redirect()->route('center.admin.edit', $id)->withErrors(['لم يتم التعديل على اي حقل', 'الرجاء تعديل بعض الحقول لكي يتم حفظها']);
                } else {
                    $admin->save();
                    $admin->user->save();
                    return redirect()->route('center.admin.edit', $id)->with('success', 'تم تعديل البيانات بنجاح');
                }

            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns A View With All Admins
    public function show_admins()
    {
        if ($this->check_authentication()) {
            // All Courses Which Belongs To The Center
            $total_courses = $this->get_center_courses();
            // All Trainers Who Belongs To The Center
            $total_trainers = $this->get_center_trainers();
            // All Admins Who Belongs To The Center
            $total_admins = $this->get_center_admins();
            // To Hold The Count Of The Array And Pass It As String
            $total_students = $this->get_center_students();
            // Get All Admins
            $all_admins = Admin::where('center_id', Auth::user()->center->user_id)->get();
            // Returns View
            return view('center.show-admins', compact('all_admins', 'total_courses', 'total_trainers', 'total_admins','students', 'total_students'));

        } else {
            return $this->external_error_page();
        }
    }

    // This Function Returns A View To Assign Admin To Course
    public function assign_course_admin()
    {
        if ($this->check_authentication()) {

            $all_courses = Course::where('center_id', Auth::user()->center->id)->get();
            $all_admins = Admin::where('center_id', Auth::user()->center->id)->get();

            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            if (count($all_courses) < 1) {
                return view("center.error-description", compact('total_courses', 'total_trainers', 'total_admins', 'total_students'))->withErrors(['title' => 'لاتوجد دورات في النظام', 'error' => 'من فضلك قم بإضافة بعض الدورات لكي تتمكن من تعيين مسؤولين لها',]);
            } elseif (count($all_admins) < 1) {
                return view("center.error-description", compact('total_courses', 'total_trainers', 'total_admins', 'total_students'))->withErrors(['title' => 'لايوجد مدراء في النظام', 'error' => 'من فضلك قم بإضافة بعض المدراء لكي تتمكن من تعيينهم مسؤولين للدورات',]);
            } else {
                return view('center.assign-course-admin', compact('all_courses', 'all_admins', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));
            }

        } else {
            return $this->external_error_page();
        }
    }

    // This Function Handles The Process Of Assigning Admin To Course
    public function store_course_admin(Request $request)
    {

        if ($this->check_authentication()) {

            $courses = Course::select('id')->where('center_id', Auth::user()->center->id)->get();

            if (count($courses) < 1) {
                return redirect()->route('center.course.admin.assign')->withErrors(['ليس لديك دورات حتى تقوم بتعيين مسؤولينن لها']);
            } else {

                $admins = Admin::where('center_id', Auth::user()->center->id)->get();

                if ( count($admins) < 1 ){
                    return redirect()->route('center.course.admin.assign')->withErrors(['ليس لديك مسؤولين حتى تقوم بتعيينهم']);
                }

                $course_data = array();

                foreach ($courses as $course) {
                    array_push($course_data, $course->id);
                }

                $admin_data = array();

                foreach ($admins as $admin) {
                    array_push($admin_data, $admin->id);
                }

                $request->validate([
                    'course' => 'required|integer|' . Rule::in($course_data),
                    'admin' => 'required|integer|' . Rule::in($admin_data),
                    'role' => 'required|integer|max:2|min:1',
                ]);

                $check_admin = CourseAdmin::where('admin_id', $request->admin)->where('course_id', $request->course)->where('role_id', $request->role)->first();

                if ( !empty($check_admin) ){
                    return redirect()->route('center.course.admin.assign')->withErrors(['تم تعيين المسؤول بهذه الصلاحيات لهذه الدورة مسبقا']);
                }

                CourseAdmin::create([
                    'course_id' => $request->course,
                    'admin_id' => $request->admin,
                    'role_id' => $request->role,
                ]);

                return redirect()->route('center.course.admin.assign')->with('success', 'تم تعيين المسؤول بنجاح');
            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns A View Of Resetting Password
    public function reset_password()
    {
        if ($this->check_authentication()) {
            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            return view('center.reset-password', compact('total_courses', 'total_trainers', 'total_admins', 'total_students'));

        } else {
            return $this->external_error_page();
        }
    }

    // This Function Handles The Process Resetting Password
    public function reset_password_confirm(Request $request)
    {

        if ($this->check_authentication()) {

            $center = User::find(Auth::user()->id);
            $request->validate([
                'old_password' => 'required|string|max:32|min:6',
                'password' => 'required|string|max:32|min:6',
                'password_confirmation' => 'required|string|max:32|min:6|same:password',
            ]);

            // Checking If The Old Password Is True
            if (!Hash::check($request->old_password, $center->password)) {
                return redirect()->route('center.reset.password')->withErrors(['old_password' => 'كلمة المرور القديمة غير صحيحة']);
            } else {
                // Checking If The New Password Equal The Old Password
                if (Hash::check($request->password, $center->password)) {
                    return redirect()->route('center.reset.password')->withErrors(['password' => 'لايمكنك تغير كلمة المرور بكلمة مرورك الحالية']);
                } else {
                    $center->password = Hash::make($request->password);
                    $center->update();
                    return redirect()->route('center.reset.password')->with('success', 'تم تغير كلمة المرور بنجاح');
                }
            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns All Bank Account Of The Account
    public function show_bank_account()
    {
        if ($this->check_authentication()) {

            $accounts = CenterAccount::where('center_id', Auth::user()->center->id)->get();
            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_trainers();
            $total_students = $this->get_center_students();
            return view('center.show-banks-accounts', compact('accounts', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));
        } else {
            return $this->external_error_page();
        }
    }

    // This Function Returns A View Of Creating Bank Account
    public function create_bank_account()
    {
        if ($this->check_authentication()) {
            $banks = Bank::all();
            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_admins();
            $total_students = $this->get_center_students();
            return view('center.create-bank-account', compact('banks', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));
        } else {
            return $this->external_error_page();
        }
    }

    // This Function Handles The Process Of Creating Bank Account
    public function store_bank_account(Request $request)
    {
        if ($this->check_authentication()) {

            $request->validate([
                'bank' => 'required|integer|exists:banks,id',
                'account_owner' => 'required|string|max:50|min:10',
                'account_number' => 'required|digits_between:15,25',
            ]);

            DB::beginTransaction();

            try {
                CenterAccount::create([
                    'center_id' => Auth::user()->center->id,
                    'bank_id' => $request->bank,
                    'account_owner' => $request->account_owner,
                    'account_number' => $request->account_number,
                ]);

                DB::commit();

                return redirect()->route('center.bank.account.show')->with('success', 'تم إضافة الحساب البنكي بنجاح');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('center.bank.account.create')->withErrors(['هناك خطأ تقني الرجاء التواصل مع إدارة الموقع'])->withInput();
            }


        } else {
            return $this->external_error_page();
        }
    }

    // This Function Returns A View With Bank Account Information To Be Edited
    public function edit_bank_account($id)
    {
        if ($this->check_authentication()) {
            $account = CenterAccount::where('center_id', Auth::user()->center->id)->where('id', $id)->first();
            if (empty($account)) {
                return $this->error_page('خطأ', 'الرجاء التأكد من معرف الحساب المراد تعديله');
            } else {
                $total_courses = $this->get_center_courses();
                $total_trainers = $this->get_center_trainers();
                $total_admins = $this->get_center_admins();
                $total_students = $this->get_center_students();
                $banks = Bank::all();

                return view('center.edit-bank-account', compact('account', 'banks', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));
            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Handles The Process Of Editing Bank Account
    public function update_bank_account(Request $request, $id)
    {

        if ($this->check_authentication()) {

            $account = CenterAccount::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (empty($account)) {
                return $this->error_page('خطأ', 'الرجاء التأكد من معرف الحساب المراد تعديله');
            } else {

                $counter = 0;

                if ($account->bank_id != $request->bank) {
                    $request->validate([
                        'bank' => 'required|integer|exists:banks,id',
                    ]);

                    $account->bank_id = $request->bank;
                    $counter++;
                }

                if ($account->account_owner != $request->account_owner) {
                    $request->validate([
                        'account_owner' => 'required|string|max:50|min:10',
                    ]);

                    $account->account_owner = $request->account_owner;
                    $counter++;
                }

                if ($account->account_number != $request->account_number) {
                    $request->validate([
                        'account_number' => 'required|integer|max:20|min:20',
                    ]);

                    $account->account_number = $request->account_number;
                    $counter++;
                }

                if ($counter == 0) {
                    return redirect()->route('center.bank.account.edit', $id)->withErrors(['قم بتحديث بعض حقول  لكي يتم حفظها']);
                } else {
                    $account->save();
                    return redirect()->route('center.bank.account.edit', $id)->with('success', 'تم تعديل البيانات بنجاح');
                }
            }
        } else {
            return $this->external_error_page();
        }

    }

    // This Function Delete A Bank Account Of The Center
    public function delete_bank_account($id)
    {

        if ($this->check_authentication()) {

            $account = CenterAccount::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (empty($account)) {

                return $this->error_page('خطأ', 'الرجاء التأكد من معرف الحساب المراد تعديله');

            } else {

                $account->delete();
                return redirect()->route('center.bank.account.show')->with('success', 'تم حذف الحساب البنكي بنجاح');

            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns A View With A Specific Course Students
    public function show_students($identifier)
    {
        if ($this->check_authentication()) {

            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();
            if (empty($course)) {
                return $this->error_page('خطأ', 'الرجاا التأكد من معرف الدورة');
            } else {
                $reservations = Reservation::where('course_id', $course->id)->get();
                $total_courses = $this->get_center_courses();
                $total_trainers = $this->get_center_trainers();
                $total_admins = $this->get_center_trainers();
                $total_students = $this->get_center_students();
                return view('center.show-students', compact('reservations', 'course', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));
            }
        } else {
            return $this->external_error_page();
        }
    }

    // This Function Returns All Social Media Account That Belongs Th The Center
    public function show_social_media_account()
    {
        if ($this->check_authentication()) {
            $accounts = CenterSocialMedia::where('center_id', Auth::user()->center->id)->get();

            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            return view('center.show-social-media-accounts', compact('accounts', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));

        } else {
            return $this->external_error_page();
        }
    }

    // This Function Returns The Form Of Creating Social Media Account
    public function create_social_media_account()
    {

        if ($this->check_authentication()) {


            $social_accounts = CenterSocialMedia::select('social_media_id')->where('center_id', Auth::user()->center->id)->get();

            if (count($social_accounts) < 1) {

                $accounts = SocialMedia::all();

            } elseif (count($social_accounts) < 4 && count($social_accounts) > 0) {

                $old_data = array();
                $data = array();

                foreach ($social_accounts as $old_account) {
                    array_push($old_data, $old_account->social_media_id);
                }

                for ($i = 0; $i < count($social_accounts); $i++) {

                    for ($x = 1; $x <= 4; $x++) {
                        $result = array_search($x, $old_data, true);
                        if (!is_integer($result)) {
                            if (!in_array($x, $data)) {
                                array_push($data, $x);
                            }
                        }
                    }

                }


                $accounts = SocialMedia::find($data);
            } else {
                return $this->error_page('خطأ', 'تم بلوغ أقصى عدد لحسابات التواصل الإجماعي');
            }


            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_trainers();
            $total_students = $this->get_center_students();

            return view('center.create-social-media-account', compact('accounts', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Handle The Data Of Creating Social Media Account
    public function store_social_media_account(Request $request)
    {

        if ($this->check_authentication()) {

            $social_accounts = CenterSocialMedia::select('social_media_id')->where('center_id', Auth::user()->center->id)->get();

            if (count($social_accounts) == 4) {

                return $this->error_page('خطأ', 'تم بلوغ أقصى عدد لحسابات التواصل الإجماعي');

            } else {

                $request->validate([
                    'social_media' => 'required|integer|exists:social_media,id',
                    'username' => 'required|string|max:20|min:5',
                    'status' => 'required|max:1|min:0',
                ]);


                CenterSocialMedia::create([
                    'username' => $request->username,
                    'center_id' => Auth::user()->center->id,
                    'social_media_id' => $request->social_media,
                    'status' => $request->status,
                ]);

                return redirect()->route('center.social.media.account.show')->with('success', 'تم إضافة الحساب بنجاح');

            }

        } else {
            return $this->external_error_page();
        }
    }

    // This Function Returns The Form Of Editing Social Media Account Of The Center
    public function edit_social_media_account($id)
    {

        if ($this->check_authentication()) {

            $social_accounts = SocialMedia::all();
            $account = CenterSocialMedia::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (empty($account)) {

                return $this->error_page('خطأ', 'الرجاء التاأكد من معرف الحساب المراد تعديله');

            } else {

                $total_courses = $this->get_center_courses();
                $total_trainers = $this->get_center_trainers();
                $total_admins = $this->get_center_trainers();
                $total_students = $this->get_center_students();


                return view('center.edit-social-media-account', compact('social_accounts', 'account', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));

            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Handle The Data Of Editing Social Media Accounts That Belongs ToThe Center
    public function update_social_media_account(Request $request, $id)
    {

        if ($this->check_authentication()) {


            $account = CenterSocialMedia::where('center_id', Auth::user()->center->id)->where('id', $id)->first();


            if (empty($account)) {

                return $this->error_page('خطأ', 'الرجاء التاأكد من معرف الحساب المراد تعديله');

            } else {

                $counter = 0;
                if ($account->username != $request->username) {
                    $request->validate([
                        'username' => 'required|string|max:20|min:5',
                    ]);

                    $account->username = $request->username;
                    $counter++;
                }

                if ($account->social_media_id != $request->social_media) {
                    $request->validate([
                        'social_media' => 'required|integer|exists:social_media,id',
                    ]);

                    $account->social_media_id = $request->social_media;

                    $counter++;
                }

                if ($account->status != $request->status) {

                    $request->validate([
                        'status' => 'required|max:1|min:0',
                    ]);

                    $account->status = $request->status;

                    $counter++;

                }

                if ($counter == 0) {

                    return redirect()->route('center.social.media.account.edit', $id)->withErrors(['قم بتحديث بعض الحثول لكي يتم حفظها']);

                } else {
                    $account->save();

                    return redirect()->route('center.social.media.account.show')->with('success', 'تم تعديل البيانات بنجاح');
                }

            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Handle The Request Of Deleting Social Media Account
    public function delete_social_media_account($id)
    {

        if ($this->check_authentication()) {

            $account = CenterSocialMedia::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (empty($account)) {

                return $this->error_page('خطأ', 'الرجاء التأكد من معرف الحساب المراد حذفه');

            } else {

                $account->delete();

                return redirect()->route('center.social.media.account.show')->with('success', 'تم حذف الحساب بنجاح');

            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns Halalah Account
    public function show_halalah_account()
    {

        if ($this->check_authentication()) {

            $halalah = Halalah::where('center_id', Auth::user()->center->id)->first();

            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_trainers();
            $total_students = $this->get_center_students();

            return view('center.show-halalah-account', compact('halalah', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns The Form Of Creating Halalah Account
    public function create_halalah_account()
    {

        if ($this->check_authentication()) {

            $halalah = Halalah::where('center_id', Auth::user()->center->id)->first();

            if (empty($halalah)) {

                $total_courses = $this->get_center_courses();
                $total_trainers = $this->get_center_trainers();
                $total_admins = $this->get_center_trainers();
                $total_students = $this->get_center_students();
                return view('center.create-halalah-account', compact('total_courses', 'total_trainers', 'total_admins', 'total_students'));

            } else {

                return $this->error_page('خطأ', 'تم بلوغ أقصى عدد لحسابات منصة هللة');
            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Handle The Data Of Creating Halalah Account
    public function store_halalah_account(Request $request)
    {

        if ($this->check_authentication()) {

            $request->validate([
                'account_owner' => 'required|string|max:50|min:10',
                'barcode-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                'status' => 'required|integer|max:1|min:0',
            ]);

            DB::beginTransaction();

            try {

                if ($request->hasFile('barcode-image')) {

                    $file = $request->file('barcode-image')->store('public/halalah-images');
                    $file_name = basename($file);

                }

                Halalah::create([
                    'center_id' => Auth::user()->center->id,
                    'name' => $request->account_owner,
                    'image' => $file_name,
                    'status' => $request->status,
                ]);

                DB::commit();

                return redirect()->route('center.halalah.account.show')->with('success', 'تم إضافة الحساب بنجاح');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('center.halalah.account.create')->withErrors(['هناك خطأ تقني الرجاء التواصل مع إدارة الموقع'])->withInput()->exceptInput('barcode-image');
            }


        } else {
            return $this->external_error_page();
        }


    }

    // This Function Returns The Form Of Editing Halalah Account
    public function edit_halalah_account()
    {

        if ($this->check_authentication()) {

            $halalah = Halalah::where('center_id', Auth::user()->center->id)->first();

            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_trainers();
            $total_students = $this->get_center_students();

            return view('center.edit-halalah-account', compact('halalah', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Handle The Data Of Editing Halalah Account
    public function update_halalah_account(Request $request)
    {

        if ($this->check_authentication()) {

            $halalah = Halalah::where('center_id', Auth::user()->center->id)->first();

            if (empty($halalah)) {

                return $this->error_page('خطأ', 'الرجاء التأكد من وجود حساب مسجل في النظام');

            } else {

                $counter = 0;

                if ($request->hasFile('barcode-image')) {

                    $request->validate([
                        'barcode-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                    ]);

                    if (File::exists('storage/halalah-images/' . $halalah->image)) {
                        if (Storage::delete('public/halalah-images/' . $halalah->image)) {
                            $file = $request->file('barcode-image')->store('public/halalah-images');
                            $file_name = basename($file);
                            $halalah->image = $file_name;
                        }
                    } else {
                        $file = $request->file('barcode-image')->store('public/halalah-images');
                        $file_name = basename($file);
                        $halalah->image = $file_name;
                    }
                    $counter++;
                }

                if ($halalah->name != $request->account_owner) {
                    $request->validate([
                        'account_owner' => 'nullable|string|max:50|min:6',
                    ]);

                    $halalah->name = $request->account_owner;
                    $counter++;
                }

                if ($halalah->status != $request->status) {
                    $request->validate([
                        'status' => 'required|integer|max:1|min:0',
                    ]);

                    $halalah->status = $request->status;
                    $counter++;
                }

                if ($counter == 0) {
                    return redirect()->route('center.halalah.account.edit')->withErrors(['قم بتحديث بعض البيانات لكي يتم حفظها']);
                } else {
                    $halalah->save();
                    return redirect()->route('center.halalah.account.edit')->with('success', 'تم تحديث البيانات بنجاح');
                }

            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Delete Halalah Account
    public function delete_halalah_account()
    {

        if ($this->check_authentication()) {

            $halalah = Halalah::where('center_id', Auth::user()->center->id)->first();

            if (empty($halalah)) {

                return $this->error_page('خطأ', 'الرجاء التأكد من وجود حساب مسجل في النظام');

            } else {

                $halalah->delete();
                return redirect()->route('center.halalah.account.show')->with('success', 'تم حذف الحساب بنجاح');

            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Confirm Student Course Payment
    public function course_payment($identifier)
    {
        if ($this->check_authentication()) {
            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();

            if (empty($course)) {
                return $this->error_page('خطأ', 'الرجاء التأكد من معرف الدورة');
            } else {
                $reservations = Reservation::where('course_id', $course->id)->get();

                $total_courses = $this->get_center_courses();
                $total_trainers = $this->get_center_trainers();
                $total_admins = $this->get_center_admins();
                $total_students = $this->get_center_students();

                return view('center.confirm-payments', compact('reservations', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));
            }
        } else {
            return $this->external_error_page();
        }
    }

    // This Function Handle The Process Of Confirming Course
    public function confirm_course_payment(Request $request, $identifier)
    {
        if ($this->check_authentication()) {

            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();

            if (empty($course)) {
                return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");
            } else {

                $reservations = Reservation::where('course_id', $course->id)->get();


                $students = array();
                $identifiers = array();

                foreach ($reservations as $reservation) {
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
                    $reservation = Reservation::where('student_id', $students[$i])->where('identifier', $identifiers[$i])->first();
                    $reservation->confirmation = $request->payment[$i];
                    $reservation->barcode = $reservation->course->identifier . $reservation->identifier . Str::random(10);
                    $reservation->save();
                    $counter++;
                }

                if ($counter == 0) {
                    return redirect()->route('center.courses.payment', $identifier)->withErrors(['الزجاء قم بتحديث بعض البيانات لكي يتم حفظها']);
                } else {
                    return redirect()->route('center.courses.payment', $identifier)->with('success', 'تم تحديث بيانات التأكيد بنجاح');
                }
            }

        } else {

            return $this->external_error_page();

        }
    }

    // This Function Active And Deactivate Courses
    public function activate_deactivate_courses()
    {
        if ($this->check_authentication()) {

            $courses = Course::where('center_id', Auth::user()->center->id)->get();

            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            return view('center.courses-activation', compact('courses', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));

        } else {
            return $this->external_error_page();
        }
    }

    // This Function Handle The Process Of Activate And Deactivate Courses
    public function activate_deactivate_courses_confirm(Request $request)
    {
        if ($this->check_authentication()) {

            $courses = Course::select('identifier')->where('center_id', Auth::user()->center->id)->get();

            $identifiers = array();

            foreach ($courses as $course) {
                array_push($identifiers, $course->identifier);
            }


            $request->validate([
                'activation' => 'required|array|size:' . count($courses),
                'activation.*' => 'required|integer|max:1|min:0',
                'course' => 'required|array|size:' . count($courses),
                'course.*' => 'required|string|max:10|min:10|' . Rule::in($identifiers),
            ]);

            $counter = 0;

            for ($i = 0; $i < count($courses); $i++) {
                if ($courses[$i]->activation != $request->activation[$i]) {
                    $courses[$i]->activation = $request->activation[$i];
                    $courses[$i]->save();
                    $counter++;
                }
            }

            if ($counter == 0) {
                return redirect()->route('center.courses.activation')->withErrors(['قم بتحديث بعض الحقول لكي يتم حفظها']);
            }
            return redirect()->route('center.courses.activation')->with('success', 'تم تحديث البيانات بنجاح');

        } else {
            return $this->external_error_page();
        }
    }

    // This Function Show Student Course Attendance
    public function course_attendance($identifier)
    {
        if ($this->check_authentication()) {

            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();
            if (empty($course)) {
                return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");
            } else {

                $date1 = date_create($course->start_date);
                $date2 = date_create($course->end_date);
                $diff = date_diff($date1, $date2);
                $days = $diff->format("%a");

                $reservations = Reservation::where('course_id', $course->id)->where('confirmation', 1)->get();
                $total_courses = $this->get_center_courses();
                $total_trainers = $this->get_center_trainers();
                $total_admins = $this->get_center_admins();
                $total_students = $this->get_center_students();

                return view('center.show-course-attendance', compact('course', 'reservations', 'days', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));
            }

        } else {
            return $this->external_error_page();
        }
    }

    // This Function Returns Details Of Student Attendance
    public function student_attendance_details($identifier, $student)
    {
        if ( $this->check_authentication() ){
            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();

            if (empty($course)) {
                return $this->error_page('خطأ', 'الرجاء التأكد من معرف الدورة');
            } else {
                $date1 = date_create($course->start_date);
                $date2 = date_create($course->end_date);
                $diff = date_diff($date1, $date2);
                $days = $diff->format("%a");

                $total_courses = $this->get_center_courses();
                $total_trainers = $this->get_center_trainers();
                $total_admins = $this->get_center_admins();
                $total_students = $this->get_center_students();

                $attendances = Attendance::where('course_id', $course->id)->where('student_id', $student)->get();
                return view('center.student-attendance-details', compact('course', 'attendances', 'total_courses', 'total_trainers', 'total_admins', 'total_students', 'days'));
            }
        }else{
            return $this->external_error_page();
        }
    }

    // This Function Shows All Certificate Of Course
    public function course_certificates($identifier)
    {

        if ($this->check_authentication()) {


            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();

            if (empty($course)) {
                return $this->error_page('خطأ', 'الرجاء التأكد من معرف الدورة');
            } else {

                $date1 = date_create($course->start_date);
                $date2 = date_create($course->end_date);
                $diff = date_diff($date1, $date2);
                $days = $diff->format("%a");

                $certificates = Certificate::where('course_id', $course->id)->get();

                $total_courses = $this->get_center_courses();
                $total_trainers = $this->get_center_trainers();
                $total_admins = $this->get_center_admins();
                $total_students = $this->get_center_students();

                return view('center.show-certificates', compact('certificates', 'total_courses', 'total_trainers', 'total_admins', 'total_students', 'days', 'course'));

            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns All Student Of A Specific Course To Generate Certificate For Them
    public function generate_certificates($identifier)
    {

        if ($this->check_authentication()) {


            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();

            if (empty($course)) {
                return $this->error_page('خطأ', 'الرجاء التأكد من معرف الدورة');
            } else {

                $date1 = date_create($course->start_date);
                $date2 = date_create($course->end_date);
                $diff = date_diff($date1, $date2);
                $days = $diff->format("%a");

                $reservations = Reservation::where('course_id', $course->id)->where('confirmation', 1)->get();

                $total_courses = $this->get_center_courses();
                $total_trainers = $this->get_center_trainers();
                $total_admins = $this->get_center_admins();
                $total_students = $this->get_center_students();

                return view('center.generate-certificate', compact('reservations', 'total_courses', 'total_trainers', 'total_admins', 'total_students', 'days', 'course'));

            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Handle The Process Of Generating New Course
    public function generate_certificates_confirm(Request $request, $identifier)
    {

        if ($this->check_authentication()) {

            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();

            if (empty($course)) {
                return $this->error_page('خطأ', 'الرجاا التأكد من معرف الدورة');
            } else {

                $reservations = Reservation::where('course_id', $course->id)->where('confirmation', 1)->get();
                $students = array();

                foreach ($reservations as $reservation) {
                    array_push($students, $reservation->student->id);
                }
                $request->validate([
                    'student' => 'required|array|size:' . count($students),
                    'student.*' => 'required|integer|' . Rule::in($students),
                    'generation' => 'required|array||size:' . count($students),
                    'generation.*' => 'required|integer|max:1|min:0',
                ]);

                $counter = 0;

                for ($i = 0; $i < count($students); $i++) {
                    $certificate = Certificate::where('course_id', $course->id)->where('student_id', $request->student[$i])->get();

                    if (count($certificate) == 1) {

                        if ($request->generation[$i] == 0) {
                            $certificate->delete();
                            $counter++;
                        }

                    } else {

                        if ($request->generation[$i] == 1) {
                            $reservation = Reservation::where('course_id', $course->id)->where('student_id', $request->student[$i])->where('confirmation', 1)->first();
                            Certificate::create([
                                'date' => date('Y-m-d'),
                                'student_id' => $request->student[$i],
                                'course_id' => $course->id,
                                'admin_id' => 0,
                                'reservation_id' => $reservation->id,
                                'viewed' => 0,
                            ]);
                            $counter++;
                        }

                    }

                }

                if ($counter == 0) {
                    return redirect()->route('center.courses.certificates.generate', $identifier)->withErrors(['قم بإصدار او حذف بعض الشهادات لكي يتم حفظ البيانات الجديدة']);
                } else {
                    return redirect()->route('center.courses.certificates.generate', $identifier)->with('success', 'تم حفظ البيانات بنجاح');
                }

            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Show The Financial Report For All Courses
    public function financial_report()
    {

        if ($this->check_authentication()) {

            $courses = Course::where('center_id', Auth::user()->center->id)->get();

            $months = array();
            $details = array();

            foreach ($courses as $course) {

                $reservation_count = Reservation::where('course_id', $course->id)->where('confirmation', 1)->count();

                // Getting The Courses Count
                if (isset($details[substr($course->start_date, 0, 7)])) {
                    $details[substr($course->start_date, 0, 7)][0] += 1;
                } else {
                    $details[substr($course->start_date, 0, 7)] = array(1);
                }

                // Getting The Student Count
                if (isset($details[substr($course->start_date, 0, 7)][1])) {
                    $details[substr($course->start_date, 0, 7)][1] += $reservation_count;
                } else {
                    array_push($details[substr($course->start_date, 0, 7)], $reservation_count);
                }

                // Getting The Total Expected Money Of All Courses
                if (isset($details[substr($course->start_date, 0, 7)][2])) {
                    $details[substr($course->start_date, 0, 7)][2] += ($course->price * $reservation_count);
                } else {
                    array_push($details[substr($course->start_date, 0, 7)], ($course->price * $reservation_count));
                }

                // Getting The Total Income Money Of All Courses
                if (isset($details[substr($course->start_date, 0, 7)][3])) {
                    $details[substr($course->start_date, 0, 7)][3] += ($course->price * $course->attendance);
                } else {
                    array_push($details[substr($course->start_date, 0, 7)], $course->price * $course->attendance);
                }


                if (!in_array(substr($course->start_date, 0, 7), $months)) {
                    array_push($months, substr($course->start_date, 0, 7));
                }

            }

            $total_courses = $this->get_center_courses();
            $total_trainers = $this->get_center_trainers();
            $total_admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            return view('center.show-financial-reports', compact('courses', 'details', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns The Financial Report For A Specific Mount
    public function month_financial_report($date)
    {

        if ($this->check_authentication()) {

            if (strlen($date) != 7) {
                return $this->error_page('خطأ', 'الرجاء التأكد من صحة التاريخ');
            } else {
                preg_match('/(^20[0-9]{2}+-[0-9]{2})/', $date, $output_array);

                if (empty($output_array)) {
                    return $this->error_page('خطأ', 'الرجاء التأكد من صحة التاريخ');
                } else {
                    $courses = Course::where('center_id', Auth::user()->center->id)->where('start_date', 'like', '%' . $date . '%')->get();
                    $total_courses = $this->get_center_courses();
                    $total_trainers = $this->get_center_trainers();
                    $total_admins = $this->get_center_admins();
                    $total_students = $this->get_center_students();

                    return view('center.show-month-report', compact('courses', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));

                }

            }

        } else {
            return $this->external_error_page();
        }

    }

    // This Function Returns All Course Schedule For Taking Attendance
    public function course_schedule($identifier)
    {
        if ($this->check_authentication()) {

            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();

            if (empty($course)) {
                return $this->error_page("خطأ", "الرجاء التأكد من معرف الدورة");
            } else {

                $date1 = date_create($course->start_date);
                $date2 = date_create($course->end_date);
                $diff = date_diff($date1, $date2);
                $days = $diff->format("%a");

                $total_courses = $this->get_center_courses();
                $total_trainers = $this->get_center_trainers();
                $total_admins = $this->get_center_trainers();
                $total_students = $this->get_center_students();

                return view('center.show-course-schedule', compact('course', 'days', 'total_courses', 'total_trainers', 'total_admins', 'total_students'));
            }

        } else {
            return $this->external_error_page();
        }
    }

    // This Function Returns A View With All Students For A Specific Course For Taking Their Attendance
    public function take_attendance($identifier, $date)
    {
        if ($this->check_authentication()) {

            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();
            if (empty($course)) {
                return $this->error_page('خطأ', 'الرجاا التأكد من معرف الدورة');
            } else {

                $date1 = date_create($course->start_date);
                $date2 = date_create($course->end_date);
                $diff = date_diff($date1, $date2);
                $days = $diff->format("%a");

                $attendances = Attendance::where('course_id', $course->id)->where('date', $date)->get();

                $total_courses = $this->get_center_courses();
                $total_trainers = $this->get_center_trainers();
                $total_admins = $this->get_center_trainers();
                $total_students = $this->get_center_students();
                return view('center.take-attendance', compact('attendances', 'course', 'date', 'total_courses', 'total_trainers', 'total_admins', 'total_students', 'days'));

            }
        } else {
            return $this->external_error_page();
        }
    }

    // This Function Handle The Process Of Taking Attendance
    public function take_attendance_confirm(Request $request, $identifier, $date)
    {

        if ( $this->check_authentication() ){
            $course = Course::where('identifier', $identifier)->where('center_id', Auth::user()->center->id)->first();

            if (empty($course)) {
                return $this->error_page('خطأ', 'الرجاا التأكد من معرف الدورة');
            } else {
                $reservations = Reservation::where('course_id', $course->id)->where('confirmation', 1)->get();
                $students = array();

                foreach ($reservations as $reservation) {
                    array_push($students, $reservation->student->id);
                }

                $request->validate([
                    'attendance' => 'required|array|size:' . count($students),
                    'attendance.*' => 'required|integer|max:1|min:0',
                    'student' => 'required|array|size:' . count($students),
                    'student.*' => 'required|integer|' . Rule::in($students),
                ]);

                $counter = 0;
                $attendances = Attendance::where('course_id', $course->id)->where('date', $date)->get();

                if (count($attendances) < 1) {

                    for ($i = 0; $i < count($students); $i++) {
                        $reservation = Reservation::where('course_id', $course->id)->where('student_id', $request->student[$i])->where('confirmation', 1)->first();


                        Attendance::create([
                            'date' => $date,
                            'student_id' => $request->student[$i],
                            'course_id' => $course->id,
                            'admin_id' => 0,
                            'reservation_id' => $reservation->id,
                            'status' => $request->attendance[$i],
                        ]);
                        $counter++;
                    }

                } else {

                    for ($i = 0; $i < count($students); $i++) {
                        $attendance = Attendance::where('course_id', $course->id)->where('date', $date)->where('student_id', $request->student[$i])->first();
                        if ($attendance->status != $request->attendance[$i]) {
                            $attendance->status = $request->attendance[$i];
                            $attendance->save();
                            $counter++;
                        }
                    }
                }


                if ($counter == 0) {
                    return redirect()->route('center.student.attendance.take', [$identifier, $date])->withErrors(['قم بتحضير او إلغاء تحضير بعض الطلاب لكي يتم حفظ البيانات الجديدة']);
                } else {
                    return redirect()->route('center.student.attendance.take', [$identifier, $date])->with('success', 'تم حفظ البيانات بنجاح');
                }
            }
        }else{
            return $this->external_error_page();
        }
    }

}
