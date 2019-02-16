<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Bank;
use App\Center;
use App\CenterAccount;
use App\City;
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
    // To Show All Courses That Are Visible To Public
    public function index()
    {
        // Get All Reservations To Filter It
        $reservations = Reservation::where('student_id', Auth::user()->student->id)->get();
        // To Filter The Reservation That Is Not Confirmed
        $tickets_data = array();
        foreach ($reservations as $reservation){
            if ( $reservation->appointment->start_date > date('Y-m-d') && $reservation->confirmation == 0 && is_null($reservation->payment) ){
                array_push($tickets_data, $reservation->id);
            }
        }
        // Save The Total Count
        $tickets = count($tickets_data);
        // Getting The Visible Courses
        $courses = Course::where('visible', 1)->get();
        return view('student.index', compact('courses', 'tickets'));
    }
    // To Show The Form Of Registering Of The Student
    public function create()
    {
        return view('student.register');
    }
    // The Registering Data Goes Here
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
    // Unused Function
    public function show($id)
    {
        //
    }
    // To Show Course Details Before Reserving It
    public function show_course($center, $identifier)
    {
        // Checking The Name Of The Center
        $center = User::where('username', $center)->first();
        // If The Name Is Wrong
        if (count($center) == 0) {
            return abort(404);
        }
        // Checking The Course Unique Identifier
        $course = Course::where('identifier', $identifier)->first();
        // If The Identifier Is Wrong
        if (count($course) == 0) {
            return abort(404);
        }
        // Get All Reservations To Filter It
        $reservations = Reservation::where('student_id', Auth::user()->student->id)->get();
        // To Filter The Reservation That Is Not Confirmed
        $tickets_data = array();
        foreach ($reservations as $reservation){
            if ( $reservation->appointment->start_date > date('Y-m-d') && $reservation->confirmation == 0 && is_null($reservation->payment) ){
                array_push($tickets_data, $reservation->id);
            }
        }
        // Save The Total Count
        $tickets = count($tickets_data);
        // Return The View Of The Details
        return view('student.show-course-details', compact('course', 'tickets'));
    }
    // To Show Final Step Before Reserving The Course
    public function book_course_form(Request $request, $identifier)
    {
        // Checking The Course Unique Identifier
        $course = Course::where('identifier', $identifier)->first();
        // If The Identifier Is Wrong
        if (count($course) == 0) {
            abort(404);
        } else {
            // Getting All Center Bank Accounts
            $accounts = CenterAccount::where('center_id', $course->center->id)->get();


            // Get All Reservations To Filter It
            $reservations = Reservation::where('student_id', Auth::user()->student->id)->get();
            // To Filter The Reservation That Is Not Confirmed
            $tickets_data = array();
            foreach ($reservations as $reservation){
                if ( $reservation->course->appointment->start_date > date('Y-m-d') && $reservation->confirmation == 0 && is_null($reservation->payment) ){
                    array_push($tickets_data, $reservation->id);
                }
            }
            // Save The Total Count
            $tickets = count($tickets_data);


            return view('student.book-course', compact('course', 'accounts', 'tickets'));
        }

    }

    public function book_course_reservation(Request $request, $identifier)
    {
        // Getting The Course Information
        $course = Course::where('identifier', $identifier)->first();
        // Making Sure The Course Is Exist
        if (count($course) <= 0) {
            abort(404);
        }
        // Validating The Request Data
//        $request->validate([
//            'coupon_code' => 'nullable|string|min:3|max:30',
//        ]);
        // Getting The Coupons Of The Course
        $coupon = Coupon::where('coupon_code', $request->coupon_code)->where('course_id', $course->id)->first();
        // Check If The User Coupon Is Exist
        if (count($coupon) <= 0) {
            Reservation::create([
                'student_id' => Auth::user()->student->id,
                'course_id' => $course->id,
                'identifier' => Str::random(10),
                'appointment_id' => $course->appointment->id,
            ]);
        } else {
            Reservation::create([
                'student_id' => Auth::user()->student->id,
                'course_id' => $course->id,
                'coupon_id' => $coupon->id,
                'identifier' => Str::random(10),
                'appointment_id' => $course->appointment->id,
            ]);
        }
        return redirect()->route('account.tickets')->with('success', 'تم حجز دورة ' . $course->title . ' بنجاح قم بتسديد المبلغ لكي يتم إصدار البطاقة');
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
        $tickets_data = array();
        foreach ($reservations as $reservation){
            if ( $reservation->appointment->start_date > date('Y-m-d') && $reservation->confirmation == 0 && is_null($reservation->payment) ){
                array_push($tickets_data, $reservation->id);
            }
        }
        $tickets = count($tickets_data);
        return view('student.tickets', compact('reservations', 'tickets'));
    }

    public function payment_confirmation(Request $request, $identifier)
    {
        $reservations = Reservation::where('student_id', Auth::user()->student->id)->get();
        $reservation = Reservation::where('identifier', $identifier)->first();
        if (count($reservation) <= 0) {
            abort(404);
        }
        $tickets_data = array();
        foreach ($reservations as $reservation){
            if ( $reservation->appointment->start_date > date('Y-m-d') && $reservation->confirmation == 0 && is_null($reservation->payment) ){
                array_push($tickets_data, $reservation->id);
            }
        }
        $tickets = count($tickets_data);
        return view('student.payment-confirmation', compact('reservation', 'tickets'));
    }

    public function confirm(Request $request, $identifier)
    {
        $reservation = Reservation::where('identifier', $identifier)->first();

        $request->validate([
            'account_owner' => 'required|string|max:50|min:10',
            'account_number' => 'required|max:30|min:10',
            'receipt-image' => 'required|image|mimetypes:image/png,image/jpg,image/jpeg||max:500',
        ]);

        $file = $request->file('receipt-image')->store('public/receipt-images');
        $file_name = basename($file);

        PaymentConfirmation::create([
            'account_owner' => $request->account_owner,
            'account_number' => $request->account_number,
            'image' => $file_name,
            'reservation_id' => $reservation->id,
            'status' => 1,
        ]);
        return redirect()->route('account.ticket')->with('success', 'تم إضافة معلومات الدفع سيتم اصدار التذكرة بعد التأكدة من صحة معلومات الدفع');
    }

    public function edit_payment_confirmation_form($identifier){
        $reservations = Reservation::where('student_id', Auth::user()->student->id)->get();
        $reservation = Reservation::where('identifier', $identifier)->first();
        if (count($reservation) <= 0) {
            abort(404);
        }
        $tickets_data = array();
        foreach ($reservations as $reservation){
            if ( $reservation->course->appointment->start_date > date('Y-m-d') && $reservation->confirmation == 0 && is_null($reservation->payment) ){
                array_push($tickets_data, $reservation->id);
            }
        }
        $tickets = count($tickets_data);
        return view('student.edit-payment-confirmation', compact('reservation', 'tickets'));
    }

    public function update_payment_confirmation_form(Request $request, $identifier){
        $request->validate([
            'account_owner' => 'string|max:50|min:10',
            'account_number' => 'max:30|min:10',
            'receipt-image' => 'image|mimetypes:image/png,image/jpg,image/jpeg||max:500',
        ]);

        $reservation = Reservation::where('identifier', $identifier)->first();
        $payment = PaymentConfirmation::where('reservation_id', $reservation->id)->first();
        if ( $request->hasFile('receipt-image') ){
            $file = $request->file('receipt-image')->store('public/receipt-images');
            $file_name = basename($file);
        }else{

        }

        $counter = 0;
        $file_name = null;

        if ( $request->account_owner != $payment->account_owner){
            $payment->account_owner = $request->account_owner;
            $counter++;
        }

        if ( $request->account_number != $payment->account_number){
            $payment->account_number = $request->account_number;
            $counter++;
        }

        if ( $file_name != null){
            $payment->image = $file_name;
            $counter++;
        }

        if ( $counter > 0 ){
            $payment->update();
            return redirect()->route('account.ticket')->with('success', 'تم إضافة معلومات الدفع سيتم اصدار التذكرة بعد التأكدة من صحة معلومات الدفع');
        }

        return redirect()->route('student.payment.confirmation.edit', $reservation->identifier)->withErrors(['لم يتم تعديل المعلومات']);

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
            return redirect()->route('account.password')->withErrors('كلمة المرور القديمة غير صحصيحة');
        }
    }
}
