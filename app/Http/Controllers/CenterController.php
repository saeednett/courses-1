<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Bank;
use App\Category;
use App\Center;
use App\CenterAccount;
use App\CenterSocialMedia;
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

    public function banks(Request $request)
    {
        if ($request->ajax()) {

            $banks = Bank::all();
            $data['data'] = array();
            foreach ($banks as $bank) {
                $array = array('id' => $bank->id, 'name' => $bank->name);
                array_push($data['data'], $array);
            }

            return response()->json($data);

        } else {
            return response(400)->json($data['data'] = array('Error'));
        }
    }


    // This Function Returns An Error Page
    private function error_page($title, $message)
    {
        $courses = $this->get_center_courses();
        $trainers = $this->get_center_trainers();
        $admins = $this->get_center_admins();
        $total_students = $this->get_center_students();

        return view("center.error-description", compact('courses', 'trainers', 'admins', 'total_students'))->withErrors(['title' => $title, 'error' => $message]);
    }

    // This Function Returns The Amount Of Trainers Of One Course
    private function get_center_trainers()
    {
        if (Auth::check() && Auth::user()->role_id == 2) {
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
        if (Auth::check() && Auth::user()->role_id == 2) {
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
        if (Auth::check() && Auth::user()->role_id == 2) {
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
        if (Auth::check() && Auth::user()->role_id == 2) {
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

        $coupon = Coupon::where('code', $coupon)->where('course_id', $course->id)->first();

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
            return response(400)->json($data['data'] = array('Error'));
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
            $response['response'] = ['id' => $bank->id, 'name' => $bank->name, 'logo' => $bank->image, 'account_owner' => $account->account_owner, 'account_number' => $account->account_number];
        }

        return response()->json($response);
    }

    // To Show The Index Of The Center After Login
    public function index($center)
    {

        if ($center == Auth::user()->username && Auth::user()->role_id == 2) {

            $courses = $this->get_center_courses();
            $trainers = $this->get_center_trainers();
            $admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            $all_courses = Course::where('center_id', Auth::user()->center->id)->get();
            $all_admins = Admin::where('center_id', Auth::user()->center->id)->get();
            $all_trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
            return view('center.index', compact('all_courses', 'all_admins', 'all_trainers', 'courses', 'trainers', 'admins', 'total_students'));
        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // To Show The Form Of Creating A New Center
    public function register()
    {
        if (Auth::guest()) {

            $banks = Bank::all();
            $countries = Country::all();
            $cities = City::where('country_id', 1)->get();
            return view('center.register', compact('countries', 'banks', 'cities'));

        } else {

            return redirect()->route('center.register');

        }

    }

    // The Data Of Creating Or Registering For The Center Goes Here And The Process Happens Here
    public function store(Request $request)
    {
        if (Auth::guest()) {

            if ($request->center_type == 1) {

                $request->validate([
                    'name' => 'required|string|max:50|min:10|unique:centers,name',
                    'center_type' => 'required|integer|max:1|min:0',
                    'verification_code' => 'required|string|max:10|min:4|unique:centers,verification_code',
                    'verification_authority' => 'required|string|max:50|min:10',
                    'country' => 'required|integer|max:99|min:1|exists:countries,id',
                    'city' => 'required|integer|max:99|min:1|exists:cities,id',
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|digits_between:9,20|unique:users,phone|',
                    'username' => 'required|string|unique:users,username',
                    'password' => 'required|string|max:32|min:8|confirmed',
                    'about' => 'required|string|max:150',
                    'bank' => 'required|integer|min:1|exists:banks,id',
                    'account_owner' => 'required|string|max:50|min:10',
                    'account_number' => 'required|digits:20|unique:center_accounts,account_number',
                    'website' => 'nullable|string|max:50|min:10',
                    'profile-logo' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                ]);

            } else if ($request->center_type == 0) {

                $request->validate([
                    'name' => 'required|string|max:50|min:10|unique:centers,name',
                    'center_type' => 'required|integer|max:1|min:0',
                    'country' => 'required|integer|max:99|min:1|exists:countries,id',
                    'city' => 'required|integer|max:99|min:1|exists:cities,id',
                    'email' => 'required|email|unique:users,email',
                    'phone' => 'required|digits_between:9,20|unique:users,phone|',
                    'username' => 'required|string|unique:users,username',
                    'password' => 'required|string|max:32|min:8|confirmed',
                    'about' => 'required|string|max:150',
                    'website' => 'nullable|string|max:50|min:10',
                    'profile-logo' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                ]);

            } else {
                return redirect()->route('center.register')->withErrors(['الرجاء اختيار تصنيف المركز']);
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


                $file = $request->file('profile-logo')->store('public/center-images');
                $file_name = basename($file);
                $logo = $file_name;


                $center = Center::create([
                    'name' => $request->name,
                    'user_id' => $user->id,
                    'verification_code' => $request->verification_code,
                    'verification_authority' => $request->verification_authority,
                    'website' => $request->website,
                    'city_id' => $request->city,
                    'about' => $request->about,
                    'type' => $request->center_type,
                    'logo' => $logo,
                ]);

                if ($request->center_type == 1) {

                    CenterAccount::create([
                        'account_owner' => $request->account_owner,
                        'account_number' => $request->account_number,
                        'bank_id' => $request->bank,
                        'center_id' => $center->id,
                    ]);

                }

                DB::commit();

                auth()->login($user);
                return redirect()->route('center.index', $request->username);

            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('center.register')->withErrors(['هناك خطأ تقني الرجاء التواصل مع إدارة الموقع'])->withInput()->exceptInput('profile-logo');
                // something went wrong
            }

        } else {
            return redirect()->route('center.login');
        }
    }


    public function show_admin_details($username)
    {

    }

    // To Show The Form Of Editing Center Information
    public function edit()
    {
        if (Auth::check() && Auth::user()->role_id == 2) {

            // The Center That Will Be Edited
            $user = User::find(Auth::user()->center->user_id);

            // Get All Banks
            $banks = Bank::all();
            // Get All Countries
            $countries = Country::all();
            // All Cities
            $cities = City::where('country_id', $user->center->city->country_id)->get();

            $courses = $this->get_center_courses();
            $trainers = $this->get_center_trainers();
            $admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            return view('center.edit-center', compact('user', 'banks', 'countries', 'cities', 'courses', 'trainers', 'admins', 'total_students'));

        } else {

            if (Auth::check() && Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::check() && Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول لهذه الصفحة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول لهذه الصفحة']);
            }

        }
    }

    // The Data Of Updating A Center Goes Here And The Process Happens Here
    public function update(Request $request)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {
            $counter = 0;

            $center = User::find(Auth::user()->center->user_id);

            if ($center->name != $request->name) {
                $request->validate([
                    'name' => 'required|string|max:50|min:10',
                ]);

                $center->center->name = $request->name;
                $counter++;
            }

            if ($center->center->verification_code != $request->verification_code) {
                $request->validate([
                    'verification_code' => 'required|string|max:10|min:4|',
                ]);

                $center->center->verification_code = $request->verification_code;
                $counter++;
            }

            if ($center->center->verification_authority != $request->verification_authority) {
                $request->validate([
                    'verification_authority' => 'required|string|max:50|min:10',
                ]);

                $center->center->verification_authority = $request->verification_authority;
                $counter++;
            }

            if ($center->center->city_id != $request->city) {
                $request->validate([
                    'city' => 'required|integer|max:99|min:1|exists:cities,id',
                ]);

                $center->center->city_id = $request->city;
                $counter++;
            }

            if ($center->email != $request->email) {
                $request->validate([
                    'email' => 'required|email|max:50',
                ]);

                $center->email = $request->email;
                $counter++;
            }

            if ($center->phone != $request->phone) {
                $request->validate([
                    'phone' => 'required|string|max:15|starts_with:+966',
                ]);

                $center->phone = $request->phone;
                $counter++;
            }

            if ($center->username != $request->username) {
                $request->validate([
                    'username' => 'required|string|unique:users,email',
                ]);

                $center->username = $request->username;
                $counter++;
            }

            if ($center->center->website != $request->website) {
                $request->validate([
                    'website' => 'required|string|max:50|min:10|',
                ]);

                $center->center->website = $request->website;
                $counter++;
            }


            if ($request->hasFile('profile-cover')) {

                $request->validate([
                    'profile-cover' => 'sometimes|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                ]);

                $counter++;
                if (File::exists('storage/center-images/' . $center->center->cover)) {
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

                $request->validate([
                    'profile-logo' => 'sometimes|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                ]);

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

                $request->validate([
                    'about' => 'required|string|',
                ]);

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

        } else {

            if (Auth::check() && Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::check() && Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول لهذه الصفحة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول لهذه الصفحة']);
            }

        }

    }

    // Remove Course Function
    public function destroy($id)
    {

    }

    // To Show The Form Of Signing in For The Center
    public function login()
    {
        return view('center.login');
    }

    // To Show The Form Of Creating New Trainer
    public function create_trainer()
    {
        if (Auth::check() && Auth::user()->role_id == 2) {

            $nationalities = Nationality::all();
            $titles = Title::all();

            $courses = $this->get_center_courses();
            $trainers = $this->get_center_trainers();
            $admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            return view('center.create-trainer', compact('nationalities', 'titles', 'courses', 'trainers', 'admins', 'total_students'));

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // The Data Of Storing New Trainer Goes Here And The Process Happens Here
    public function store_trainer(Request $request)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $request->validate([
                'name' => 'required|string|max:50|min:6|unique:trainers,name',
                'username' => 'required|string|max:20|:min:5|unique:users,username',
                'phone' => 'required|starts_with:+|max:15|min:9|unique:users,phone',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|max:32|min:6|confirmed',
                'status' => 'required|integer|max:1|min:0',
                'title' => 'required|integer|max:99|min:1|exists:titles,id',
                'nationality' => 'required|integer|max:99|min:1|exists:nationalities,id',
                'profile-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
            ]);

            DB::beginTransaction();

            try {

                $user = User::create([
                    'email' => $request->email,
                    'username' => $request->username,
                    'phone' => $request->phone,
                    'role_id' => 4,
                    'status' => $request->status,
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
                return redirect()->route('center.trainer.create')->with('success', 'تم إضافة المدرب بنجاح');

            } catch (Exception $e) {
                DB::rollback();
                return redirect()->route('center.trainer.create')->withErrors(['هناك خطأ تقني الرجاء التواصل مع إدارة الموقع']);
            }

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // To Show The Form Of Editing A Trainer
    public function edit_trainer($id)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            // The Trainer That Will Be Edited
            $trainer = Trainer::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (count($trainer) < 1) {

                return $this->error_page('لايوجد مدربيين في النظام', 'من فضلك قم بالتأكد من معرف المدرب المراد تعديل بياناته');

            } else {

                // Get All Titles To Chose One Of Them
                $titles = Title::all();
                // Get All Nationalities To Chose One Of Them
                $nationalities = Nationality::all();
                // All Admins Who Belongs To The Center
                $admins = $this->get_center_admins();
                // All Courses Which Belongs To The Center
                $courses = $this->get_center_courses();
                // All Trainers Who Belongs To The Center
                $trainers = $this->get_center_trainers();
                // All Students Who Reserved A Course Of The Center
                $total_students = $this->get_center_students();

                return view('center.edit-trainer', compact('trainer', 'titles', 'nationalities', 'trainers', 'courses', 'admins', 'total_students'));

            }

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // The Data Of Updating A Trainer Goes Here And The Process Happens Here
    public function update_trainer(Request $request, $id)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $trainer = Trainer::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (count($trainer) < 1) {

                return redirect()->route('center.admin.edit', $id)->withErrors(['لايوجد مدربيين في النظام', 'الرجاء قم بالتأكد من وجود مدربيين مسجلين في النظام']);

            } else {

                $counter = 0;

                if ($trainer->user->name != $request->name) {
                    $request->validate([
                        'name' => 'required|string|max:50|min:10|unique:users,name',
                    ]);

                    $trainer->user->name = $request->name;
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
                        'phone' => 'required|string|starts_with:+966|max:13|min:13||unique:users,phone',
                    ]);

                    $trainer->user->phone = $request->phone;
                    $counter++;
                }

                if ($trainer->user->email != $request->email) {
                    $request->validate([
                        'email' => 'required|string|email|unique:users,email',
                    ]);

                    $trainer->user->email = $request->email;
                    $counter++;
                }

                if ($trainer->user->status != $request->status) {
                    $request->validate([
                        'status' => 'required|integer|max:1|min:0',
                    ]);
                }

                $request->validate([
                    'title' => 'required|integer|max:99|min:1|exists:titles,id',
                    'nationality' => 'required|integer|max:99|min:1|exists:nationalities,id',
                ]);


                if ($trainer->title_id != $request->title) {

                    $request->validate([
                        'title' => 'required|integer|max:99|min:1|exists:titles,id',
                    ]);

                    $trainer->title_id = $request->title;
                    $counter++;
                }

                if ($trainer->nationality_id != $request->nationality) {

                    $request->validate([
                        'nationality' => 'required|integer|max:99|min:1|exists:nationalities,id',
                    ]);

                    $trainer->nationality_id = $request->nationality;
                    $counter++;
                }

                if ($request->hasFile('profile-image')) {

                    $request->validate([
                        'profile-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                    ]);

                    if (File::exists('storage/trainer-images/' . $trainer->image)) {
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
                }

                $trainer->save();
                $trainer->user->save();
                return redirect()->route('center.trainer.edit', $trainer->id)->with('success', 'تم تعديل البيانات بنجاح');

            }

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // To Show All Trainers Who Belongs To The Center
    public function show_trainers()
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $courses = $this->get_center_courses();
            $trainers = $this->get_center_trainers();
            $admins = $this->get_center_admins();
            $total_students = $this->get_center_students();
            $all_trainers = Trainer::where('center_id', Auth::user()->center->id)->get();


            return view('center.show-trainers', compact('all_trainers', 'courses', 'trainers', 'admins', 'total_students'));

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // To Show The Form Of Creating New Course
    public function create_course()
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            // All Courses Which Belongs To The Center
            $courses = $this->get_center_courses();
            // All Trainers Who Belongs To The Center
            $trainers = $this->get_center_trainers();
            // All Admins Who Belongs To The Center
            $admins = $this->get_center_admins();
            // All Students Who Reserved A Course Of The Center
            $total_students = $this->get_center_students();


            if ($trainers < 1) {
                (['title' => 'لاتوجد دورات في النظام', 'error' => 'من فضلك قم بإضافة بعض الدورات لكي تتمكن من تعيين مدربين لها',]);
                return view("center.error-description", compact('courses', 'trainers', 'admins', 'total_students'))->withErrors(['title' => 'لايوجد مدربين في النظام', 'error' => 'من فضلك قم بإضافة بعض المدربين لكي تتمكن من إضافة الدورات']);
            }

            // Get The First Cities The The Rest With Ajax Rexuest
            $cities = City::where('country_id', 1)->get();
            // Get All Countries
            $countries = Country::all();
            // Get All Categories
            $categories = Category::all();

            $all_trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
            return view('center.create-course', compact('all_trainers', 'countries', 'cities', 'categories', 'trainers', 'admins', 'courses', 'total_students'));

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // The Data Of Storing New Course Goes Here And The Process Happens Here
    public function store_course(Request $request)
    {
        if (Auth::check() && Auth::user()->role_id == 2) {

            // Getting Center Main Information
            $center = Center::find(Auth::user()->id);
            // Trainers Array That Will Hold Ids Of The Trainers Who Belong To The Center
            $trainers_data = array();
            // Getting Trainers Information
            $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();

            // Making Sure That The Center Has Trainers
            if (count($trainers) < 1) {
                abort(404);
            }
            // Fetching Trainers Data Into The Array
            foreach ($center->trainer as $trainer) {
                array_push($trainers_data, $trainer->id);
            }

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
                'course-poster-1' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg|max:400',
                'course-poster-2' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg|max:400',
                // The Description Of The Course
                'description' => 'required|string|max:200|min:50',


                //The Trainers Array Of The Course
                'trainer' => 'required|array|max:' . count($center->trainer),
                // The Trainers Array Data
                'trainer.*' => 'required|integer|distinct|' . Rule::in($trainers_data),


                // The Type Of Course Payed Or Free
                'type' => 'required|integer|max:2|min:1',
                //The Coupons Indicator Of The Coupons
                'coupon' => 'required_if:type,2|integer|max:1|min:0',
                //The Coupons Array Data
                'coupon_code' => 'required_if:coupon,2|array',
                'coupon_code.*' => 'required|string|distinct',
                'coupon_discount' => 'required_if:coupon,2|array|size:' . count($request->coupon_code),
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
                // Attendance Amount Base On Gender
                'men_amount' => 'required_if:gender,3|integer|max:1000|min:1',
                'women_amount' => 'required_if:gender,3|integer|max:1000|min:1',

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
                if ($request->hasFile('course-poster-1') && $request->hasFile('course-poster-2')) {

                    $file = $request->file('course-poster-1')->store('public/course-images');
                    $file_name = basename($file);

                    $file_2 = $request->file('course-poster-2')->store('public/course-images');
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

                return redirect()->route('center.course.create')->with('success', 'تم إضافة الدورة بنجاح');
            } catch (\Exception $e) {
                // Don't Save The Changes If The Is Errors
                DB::rollBack();
                return redirect()->route('center.course.create')->withErrors(['هناك خطأ تقني الرجاء التواصل مع إدارة الموقع'])->withInput();

            }


        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

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

        if (Auth::check() && Auth::user()->role_id == 2) {

            $courses = Course::where('center_id', Auth::user()->center->id)->get();
            $trainers = Trainer::where('center_id', Auth::user()->center->id)->get();
            $admins = Admin::where('center_id', Auth::user()->center->id)->get();
            $course_id = Course::select('id')->where('center_id', Auth::user()->center->id)->get();
            $students = Reservation::find($course_id)->count();

            return view('center.show-courses', compact('courses', 'trainers', 'admins', 'students'));

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username);
            } else {
                return redirect()->route('account.index');
            }

        }
    }

    // To Show The Form Of Creating New Admin
    public function create_admin()
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $courses = $this->get_center_courses();
            $trainers = $this->get_center_trainers();
            $admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            return view('center.create-admin', compact('courses', 'trainers', 'admins', 'total_students'));

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username);
            } else {
                return redirect()->route('account.index');
            }

        }

    }

    // The Data Of Storing New Admin Goes Here And The Process Happens Here
    public function store_admin(Request $request)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $request->validate([
                'name' => 'required|string|max:50|min:6|unique:admins,name',
                'username' => 'required|string|max:20|:min:5|unique:users,username',
                'phone' => 'required|starts_with:+|max:15|min:9|unique:users,phone',
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

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username);
            } else {
                return redirect()->route('account.index');
            }

        }

    }

    // To Show The Form Editing Admin
    public function edit_admin($id)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {


            // The Data Of The Admin That Will Be Edited
            $admin = Admin::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            // All Courses Which Belongs To The Center
            $courses = $this->get_center_courses();
            // All Admins Who Belongs To The Center
            $admins = $this->get_center_admins();
            // All Trainers Who Belongs To The Center
            $trainers = $this->get_center_trainers();
            // All Students Who Reserved A Course Of The Center
            $total_students = $this->get_center_students();

            if (count($admin) < 1) {
                return $this->error_page('لايوجد مسؤول مسجل في النظام', 'من فضلك قم بالتأكد من معرف المسؤول المراد تعديل بياناته');
            } else {
                return view('center.edit-admin', compact('admin', 'courses', 'trainers', 'admins', 'total_students'));
            }


        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // The Data Of Updating Admin Goes Here And The Process Happens Here
    public function update_admin(Request $request, $id)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $admin = Admin::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (count($admin) < 1) {

                return $this->error_page('لايوجد مسؤول مسجل في النظام', 'الرجاء قم بالتأكد من وجود مسؤولين مسجلين في النظام');

            } else {

                $counter = 0;
                if ($admin->user->name != $request->name) {
                    $request->validate([
                        'name' => 'required|string|max:50|min:6|unique:admins,name',
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

                    if (File::exists('storage/trainer-images/' . $admin->image)) {
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
                }

                $admin->save();
                $admin->user->save();
                return redirect()->route('center.admin.edit', $id)->with('success', 'تم تعديل البيانات بنجاح');

            }

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // To Show All Admins Who Belongs To The Center
    public function show_admins()
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            // All Admins Who Belongs To The Center
            $admins = $this->get_center_admins();
            // All Courses Which Belongs To The Center
            $courses = $this->get_center_courses();
            // All Trainers Who Belongs To The Center
            $trainers = $this->get_center_trainers();
            // To Hold The Count Of The Array And Pass It As String
            $total_students = $this->get_center_students();
            // Get All Admins
            $all_admins = Admin::where('center_id', Auth::user()->center->user_id)->get();
            // Returns View
            return view('center.show-admins', compact('all_admins', 'admins', 'courses', 'trainers', 'students', 'total_students'));

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // To Show The Form Of Assigning Course Admin
    public function assign_course_admin()
    {
        if (Auth::check() && Auth::user()->role_id == 2) {

            $all_courses = Course::where('center_id', Auth::user()->center->id)->get();
            $all_admins = Admin::where('center_id', Auth::user()->center->id)->get();

            $courses = $this->get_center_courses();
            $trainers = $this->get_center_trainers();
            $admins = $this->get_center_admins();
            $total_students = $this->get_center_students();


            if (count($all_courses) < 1) {
                return view("center.error-description", compact('courses', 'trainers', 'admins', 'total_students'))->withErrors(['title' => 'لاتوجد دورات في النظام', 'error' => 'من فضلك قم بإضافة بعض الدورات لكي تتمكن من تعيين مدربين لها',]);
            } elseif (count($all_admins) < 1) {
                return view("center.error-description", compact('courses', 'trainers', 'admins', 'total_students'))->withErrors(['title' => 'لايوجد مدراء في النظام', 'error' => 'من فضلك قم بإضافة بعض المدراء لكي تتمكن من تعيينهم مدربين للدورات',]);
            }

            return view('center.assign-course-admin', compact('all_courses', 'all_admins', 'courses', 'trainers', 'admins', 'total_students'));
        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }
    }

    // The Data Of Assigning Course Admin Goes Here And The Process Happens Here
    public function store_course_admin(Request $request)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $courses = Course::select('id')->where('center_id', Auth::user()->center->id)->get();

            if (count($courses) < 1) {
                return redirect()->route('center.course.admin.assign')->withErrors(['ليست لديك دورات حتى تقوم بتعيين مسؤولينن لها']);
            }

            $course_data = array();

            foreach ($courses as $course) {
                array_push($course_data, $course->id);
            }

            $admins = Admin::where('center_id', Auth::user()->center->id)->get();

            $admin_data = array();

            foreach ($admins as $admin) {
                array_push($admin_data, $admin->id);
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

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // To Show The Form Of Resetting Password
    public function reset_password()
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $courses = $this->get_center_courses();
            $trainers = $this->get_center_trainers();
            $admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            return view('center.reset-password', compact('courses', 'trainers', 'admins', 'total_students'));

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // The Data Of Resetting Password Goes Here And The Process Happens Here
    public function reset_password_confirm(Request $request)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

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

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // This Function Returns All Bank Account Of The Account
    public function show_bank_account()
    {
        if (Auth::check() && Auth::user()->role_id == 2) {

            $accounts = CenterAccount::where('center_id', Auth::user()->center->id)->get();
            $courses = $this->get_center_courses();
            $trainers = $this->get_center_trainers();
            $admins = $this->get_center_trainers();
            $total_students = $this->get_center_students();
            return view('center.show-banks-accounts', compact('accounts', 'courses', 'trainers', 'admins', 'total_students'));

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }
    }

    // To Show The Form Of Creating Bank Account
    public function create_bank_account()
    {
        $banks = Bank::all();
        $courses = $this->get_center_courses();
        $trainers = $this->get_center_trainers();
        $admins = $this->get_center_admins();
        $total_students = $this->get_center_students();
        return view('center.create-bank-account', compact('banks', 'courses', 'trainers', 'admins', 'total_students'));
    }

    // The Data Of Creating Bank Account Goes Here And The Process Happens Here
    public function store_bank_account(Request $request)
    {
        if (Auth::check() && Auth::user()->role_id == 2) {

            $request->validate([
                'bank' => 'required|integer|exists:banks,id',
                'account_owner' => 'required|string|max:50|min:10',
                'account_number' => 'required|digits_between:15,25',
            ]);

            try {

                DB::beginTransaction();
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

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }
    }

    // To Show The Form Of Editing And Adding Bank Account
    public function edit_bank_account($id)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $account = CenterAccount::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (count($account) < 1) {

                return $this->error_page('خطأ', 'الرجاء التأكد من معرف الحساب المراد تعديله');

            } else {

                $courses = $this->get_center_courses();
                $trainers = $this->get_center_trainers();
                $admins = $this->get_center_admins();
                $total_students = $this->get_center_students();

                $banks = Bank::all();

                return view('center.edit-bank-account', compact('account', 'banks', 'courses', 'trainers', 'admins', 'total_students'));

            }

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // The Data Of Updating The Banks Accounts
    public function update_bank_account(Request $request, $id)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {


            $account = CenterAccount::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (count($account) < 1) {

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
                        'account_number' => 'required|digits_between:15,25',
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

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // This Function Delete A Bank Account Of The Center
    public function delete_bank_account($id)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $account = CenterAccount::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (count($account) < 1) {

                return $this->error_page('خطأ', 'الرجاء التأكد من معرف الحساب المراد تعديله');

            } else {

                $account->delete();
                return redirect()->route('center.bank.account.show')->with('success', 'تم حذف الحساب البنكي بنجاح');

            }

        } else {
            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }
        }

    }

    // This Function Returns All Social Media Account That Belongs Th The Center
    public function show_social_media_account()
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $accounts = CenterSocialMedia::where('center_id', Auth::user()->center->id)->get();

            $courses = $this->get_center_courses();
            $trainers = $this->get_center_trainers();
            $admins = $this->get_center_admins();
            $total_students = $this->get_center_students();

            return view('center.show-social-media-accounts', compact('accounts', 'courses', 'trainers', 'admins', 'total_students'));

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // This Function Returns The Form Of Creating Social Media Account
    public function create_social_media_account()
    {

        if (Auth::check() && Auth::user()->role_id == 2) {



            $social_accounts = CenterSocialMedia::select('social_media_id')->where('center_id', Auth::user()->center->id)->get();

            if (count($social_accounts) < 1) {

                $accounts = SocialMedia::all();

            } elseif (count($social_accounts) < 4 && count($social_accounts) > 0) {

                $old_data = array();
                $data = array();

                foreach ($social_accounts as $old_account){
                    array_push($old_data, $old_account->social_media_id);
                }

                for ($i = 0; $i < count($social_accounts); $i++) {

                    for ($x = 1; $x <= 4; $x++){
                        $result = array_search($x, $old_data, true);
                        if ( !is_integer($result) ){
                            if ( !in_array($x, $data) ) {
                                array_push($data, $x);
                            }
                        }
                    }

                }


                $accounts = SocialMedia::find($data);
            }else{
                return $this->error_page('خطأ', 'تم بلوغ أقصى عدد لحسابات التواصل الإجماعي');
            }


            $courses = $this->get_center_courses();
            $trainers = $this->get_center_trainers();
            $admins = $this->get_center_trainers();
            $total_students = $this->get_center_students();

            return view('center.create-social-media-account', compact('accounts', 'courses', 'trainers', 'admins', 'total_students'));

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // This Function Handle The Data Of Creating Social Media Account
    public function store_social_media_account(Request $request)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $social_accounts = CenterSocialMedia::select('social_media_id')->where('center_id', Auth::user()->center->id)->get();

            if (count($social_accounts) == 4 ) {

                return $this->error_page('خطأ', 'تم بلوغ أقصى عدد لحسابات التواصل الإجماعي');

            }else{

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

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }


    }

    // This Function Returns The Form Of Editing Social Media Account Of The Center
    public function edit_social_media_account($id)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $social_accounts = SocialMedia::all();
            $account = CenterSocialMedia::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (count($account) < 1) {

                return $this->error_page('خطأ', 'الرجاء التاأكد من معرف الحساب المراد تعديله');

            } else {

                $courses = $this->get_center_courses();
                $trainers = $this->get_center_trainers();
                $admins = $this->get_center_trainers();
                $total_students = $this->get_center_students();


                return view('center.edit-social-media-account', compact('social_accounts', 'account', 'courses', 'trainers', 'admins', 'total_students'));

            }

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // This Function Handle The Data Of Editing Social Media Accounts That Belongs ToThe Center
    public function update_social_media_account(Request $request, $id)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {


            $account = CenterSocialMedia::where('center_id', Auth::user()->center->id)->where('id', $id)->first();


            if (count($account) < 1) {

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

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // This Function Handle The Request Of Deleting Social Media Account
    public function delete_social_media_account($id)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $account = CenterSocialMedia::where('center_id', Auth::user()->center->id)->where('id', $id)->first();

            if (count($account) < 1) {

                return $this->error_page('خطأ', 'الرجاء التأكد من معرف الحساب المراد حذفه');

            } else {

                $account->delete();

                return redirect()->route('center.social.media.account.show')->with('success', 'تم حذف الحساب بنجاح');

            }

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }


    // This Function Returns Halalah Account
    public function show_halalah_account(){

        if ( Auth::check() && Auth::user()->role_id == 2 ){

            $halalah = Halalah::where('center_id', Auth::user()->center->id)->first();
            $courses = $this->get_center_courses();
            $trainers = $this->get_center_trainers();
            $admins = $this->get_center_trainers();
            $total_students = $this->get_center_students();
            return view('center.show-halalah-account', compact('halalah', 'courses', 'trainers', 'admins', 'total_students'));

        }else{

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // This Function Returns The Form Of Creating Halalah Account
    public function create_halalah_account(){

        if ( Auth::check() && Auth::user()->role_id == 2 ){

            $halalah = Halalah::where('center_id', Auth::user()->center->id)->first();

            if ( count($halalah) < 1 ){

                $courses = $this->get_center_courses();
                $trainers = $this->get_center_trainers();
                $admins = $this->get_center_trainers();
                $total_students = $this->get_center_students();
                return view('center.create-halalah-account', compact( 'courses', 'trainers', 'admins', 'total_students'));

            }else{

                return $this->error_page('خطأ', 'تم بلوغ أقصى عدد لحسابات منصة هللة');
            }

        }else{

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // This Function Handle The Data Of Creating Halalah Account
    public function store_halalah_account(Request $request){

        if ( Auth::check() && Auth::user()->role_id == 2 ){

            $request->validate([
                'account_owner' => 'required|string|max:50|min:10',
                'barcode-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:400',
                'status' => 'required|integer|max:1|min:0',
            ]);

            try{

                DB::beginTransaction();

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

            }catch (\Exception $e){

                DB::rollBack();
                return redirect()->route('center.halalah.account.create')->withErrors(['هناك خطأ تقني الرجاء التواصل مع إدارة الموقع'])->withInput()->exceptInput('barcode-image');

            }


        }else{

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }


    }

    // This Function Returns The Form Of Editing Halalah Account
    public function edit_halalah_account()
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $halalah = Halalah::where('center_id', Auth::user()->center->id)->first();

            $courses = $this->get_center_courses();
            $trainers = $this->get_center_trainers();
            $admins = $this->get_center_trainers();
            $total_students = $this->get_center_students();

            return view('center.edit-halalah-account', compact('halalah', 'courses', 'trainers', 'admins', 'total_students'));

        } else {

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // This Function Handle The Data Of Editing Halalah Account
    public function update_halalah_account(Request $request)
    {

        if (Auth::check() && Auth::user()->role_id == 2) {

            $halalah = Halalah::where('center_id', Auth::user()->center->id)->first();


            if ( count($halalah) < 1 ){

                return $this->error_page('خطأ', 'الرجاء التأكد من وجود حساب مسجل في النظام');

            }else{

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

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }

    // This Function Delete Halalah Account
    public function delete_halalah_account(){

        if ( Auth::check() && Auth::user()->role_id == 2 ){

            $halalah = Halalah::where('center_id', Auth::user()->center->id)->first();

            if ( count($halalah) < 1 ){

                return $this->error_page('خطأ', 'الرجاء التأكد من وجود حساب مسجل في النظام');

            }else{

                $halalah->delete();
                return redirect()->route('center.halalah.account.show')->with('success', 'تم حذف الحساب بنجاح');

            }

        }else{

            if (Auth::user()->role_id == 1) {
                dd("Fuck Off");
            } elseif (Auth::user()->role_id == 3) {
                return redirect()->route('admin.index', Auth::user()->username)->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            } else {
                return redirect()->route('account.index')->withErrors(['صلاحياتك لاتسمح لك بالدخول للصفحة المطلوبة']);
            }

        }

    }


}
