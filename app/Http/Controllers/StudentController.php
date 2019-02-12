<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Bank;
use App\Center;
use App\CenterAccount;
use App\City;
use App\Coupon;
use App\Course;
use App\Reservation;
use App\User;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class StudentController extends Controller
{
    public function index()
    {
        $courses = Course::where('visible', 1)->get();
        return view('student.index', compact('courses'));
    }

    public function create()
    {
        return view('student.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|min:10',
            'email' => 'required|email|max:100|unique:users,email',
            'username' => 'required|string|max:20|min:5|unique:users,username',
            'phone' => 'required|max:10|min:9|unique:users,phone',
            'gender' => 'required|max:99|min:1|exists:genders,id',
            'password' => 'required|string|max:32|min:8|confirmed'
        ]);
        $student = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => "+966" . $request->phone,
            'role_id' => 3,
            'password' => Hash::make($request->password),
        ]);

        Student::create([
            'user_id' => $student->id,
            'gender_id' => $request->gender,
            'city_id' => 0,
            'status' => 1
        ]);

        auth()->login($student);
        return redirect()->route('account.index');
    }

    public function show($id)
    {
        //
    }

    public function show_course($center, $identifier)
    {
        $center = User::where('username', $center)->first();
        if ( count($center) == 0 ){
            return abort(404);
        }

        $course = Course::where('identifier', $identifier)->first();
        if ( count($course) == 0 ){
            return abort(404);
        }

        return view('student.show-course-details', compact('course'));
    }

    public function book_course_form(Request $request, $identifier) {
        $request->validate([
            'date' => 'required|array|max:100',
            'date.*' => 'integer|distinct',
        ]);

        $course = Course::where('identifier', $identifier)->first();

        if ( count($course) == 0 ){
            abort(404);
        }else{
            $appointments = Appointment::find($request->date);
            if ( count($appointments) == 0 ){
                abort(404);
            }else{
                $banks_data = array();
                $banks_id = CenterAccount::select('id')->where('center_id', $course->center->id)->get();

                foreach ($banks_id as $id){
                    array_push($banks_data, $id->id);
                }

                $banks = Bank::find($banks_data);
                $date = $request->date;
                $unique_id = $course->identifier;
                return view('student.book-course', compact('course', 'appointments', 'banks', 'unique_id', 'date'));
            }
        }

    }

    public function book_course_reservation(Request $request)
    {
        $course = Course::where('identifier', $request->identifier)->first();

        if ( count($course) <= 0 ){
            abort(404);
        }

        $date = array();

        foreach ($course->appointment as $appointment){
            array_push($date, $appointment->id);
        }

        $request->validate([
            'date' => 'required|array|max:'.count($course->appointment),
            'date.*' => 'integer|distinct|'.Rule::in($date),
            'coupon_code' => 'nullable|string|min:3|max:30',
        ]);


        for ($i = 0; $i < count($request->date); $i++){
            $coupon = Coupon::where('coupon_code', $request->coupon_code)->where('course_id', $course->id)->first();
            if ( count($coupon) <= 0 ){
                Reservation::create([
                    'student_id' => Auth::user()->student->id,
                    'course_id' => $course->id,
                    'appointment_id' => $request->date[$i],
                ]);
            }else {
                Reservation::create([
                    'student_id' => Auth::user()->student->id,
                    'course_id' => $course->id,
                    'coupon_id' => $coupon->id,
                    'appointment_id' => $request->date[$i],
                ]);
            }
        }

        return redirect()->route('account.index')->with('success', 'تم حجز دورة '.$course->title.' بنجاح قم بتسديد المبلغ لكي يتم إصدار البطاقة');

    }

    public function edit()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        $cities = City::all();
        return view('student.edit-account', compact('user', 'cities'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'phone' => 'required|starts_with:+966|string|max:13|min:9|' . Rule::unique('users')->ignore(Auth()->user()->id),
            'email' => 'required|string|max:100|' . Rule::unique('users')->ignore(Auth()->user()->id),
            'username' => 'required|string|max:20:min:5|' . Rule::unique('users')->ignore(Auth()->user()->id),
            'city' => 'required|integer|max:99|min:1|exists:cities,id',
            'gender' => 'required|integer|max:99|exists:genders,id',
            'profile-image' => 'sometimes|image|mimetypes:image/png,image/jpg,image/jpeg||max:500'
        ]);

        $id = Auth::user()->id;
        $student = Student::where('user_id', $id)->first();

        if ($student->user->name != $request->name) {
            $student->user->name = $request->name;
        }

        if ($student->user->phone != $request->phone) {
            $student->user->phone = $request->phone;
        }

        if ($student->user->email != $request->email) {
            $student->user->email = $request->email;
        }

        if ($student->user->username != $request->username) {
            $student->user->username = $request->username;
        }

        if ($student->gender_id != $request->gender) {
            $student->gender_id = $request->gender;
        }

        if ($request->hasFile('profile-image')) {
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

        $student->save();
        $student->user->save();
        return redirect()->route('account.edit')->with('success', 'تم تحديث البيانات بنجاح');

    }

    public function destroy($id)
    {
        //
    }

    public function create_sign_in()
    {
        return view('student.login');
    }

    public function tickets()
    {
        $reservations = Reservation::where('student_id', Auth::user()->student->id)->get();
        return view('student.tickets', compact('reservations'));
    }

    public function create_reset_password()
    {
        return view('student.account-reset-password');
    }

    public function reset_password(Request $request)
    {

        $user = User::find(Auth::user()->id);

        if (Hash::check($request->old_password, $user->password)) {

            $request->validate([
                'password' => 'required|string|max:32|min:8|confirmed',
            ]);

            if (Hash::check($request->password, $user->password)) {
                return redirect()->route('account.password')->withErrors('لا يمكن استخدام نفس كلمة المرور القديمة');
            } else {
                $user->password = Hash::make($request->password);
                $user->save();
                return redirect()->route('account.password')->with('success', 'تم تغير كلمة المرور بنجاح');
            }
        } else {
            dd($user->password . "-------" . Hash::make($request->old_password));
            return redirect()->route('account.password')->withErrors('كلمة المرور القديمة غير صحصيحة');
        }
    }
}
