<?php

namespace App\Http\Controllers;

use App\Course;
use App\CourseAdmin;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminAPIController extends Controller
{
    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $response = array(
        'status' => array(),
        'errors' => array(),
        'response' => array(),
    );
    // This Variable For Holding The Data That Going To Be Send Back To The Application
    private $data = array();

    // This Function Retrieve The Payments Information Of One Course And The Students Information
    public function get_payment_information(Request $request)
    {

        $course = Course::where('identifier', $request->identifier)->first();
        if (count($course) < 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'الرجاء التأكد من معرف الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        $course_admin = CourseAdmin::where('admin_id', auth('api')->user()->admin->id)->where('course_id', $course->id)->where('role_id', 1)->first();
        if (count($course_admin) < 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'ليست لديك صلاحيات المسؤول في هذه الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        $reservations = Reservation::where('course_id', $course->id)->where('confirmation', 0)->get();

        if (count($reservations) < 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'تم تأكيد الدفع لجميع طلاب هذه الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        foreach ($reservations as $reservation) {
            if ($reservation->coupon == 1) {
                $coupon = $reservation->coupon->discount;
                $amount = ($course->price * $coupon) / 100;
            } else {
                $coupon = "لايوجد";
                $amount = $course->price;
            }
            if (count($reservation->payment) > 0) {
                $subData = array(
                    'student' => $reservation->student->first_name . " " . $reservation->student->second_name,
                    'account_owner' => $reservation->payment->account_owner,
                    'account_number' => $reservation->payment->account_number,
                    'coupon' => $coupon,
                    'amount' => $amount,
                );

                array_push($this->data, $subData);
            }
        }

        array_push($this->response['status'], 'success');
        array_push($this->response['errors'], null);
        array_push($this->response['response'], $this->data);

        return response()->json($this->response);

    }

    // This Function For Confirming Payments For One Course
    public function confirm_payment(Request $request)
    {

        $course = Course::where('identifier', $request->identifier)->first();
        if (count($course) < 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'الرجاء التأكد من معرف الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        $course_admin = CourseAdmin::where('admin_id', auth('api')->user()->admin->id)->where('course_id', $course->id)->where('role_id', 1)->first();
        if (count($course_admin) < 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'لست لديك صلاحيات المسؤول في هذه الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }


        $students_data = Reservation::where('course_id', $course->id)->where('confirmation', 0)->get();

        if (count($students_data) < 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'تم تأكيد الدفع لجميع طلاب هذه الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        $students = array();
        foreach ($students_data as $student) {
            array_push($students, $student->id);
        }

        $request->validate([
            'identifier' => 'required|string|max:10|min:10|exists:courses,identifier',
            'student' => 'required|integer|' . Rule::in($students),
            'confirmation' => 'required|integer|max:1|min:0',
        ]);


        $reservation = Reservation::where('student_id', $request->student)->where('course_id', $course->id)->first();

        if (count($reservation) < 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'لايوجد حجز لهذا الطالب');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }


        if ($reservation->confirmation == 1) {

            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], null);
            array_push($this->response['response'], 'تم تأكيد الحجز مسبقا');

            return response()->json($this->response);
        } else {
            $reservation->confirmation = 1;
            $reservation->save();

            array_push($this->response['status'], 'success');
            array_push($this->response['errors'], null);
            array_push($this->response['response'], 'تم تأكيد الحجز');

            return response()->json($this->response);
        }

    }

    // This Function For Showing The Details Of Confirming The Payments
    public function show_payment_confirmation(Request $request)
    {

        $request->validate([
            'identifier' => 'required|string|max:10|min:10',
        ]);

        $course = Course::where('identifier', $request->identifier)->first();

        if (count($course) < 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'الرجاء التأكد من معرف الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        $courses_data = CourseAdmin::where('admin_id', auth('api')->user()->admin->id)->where('role_id', 1)->get();
        if (count($courses_data) < 1) {
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'ليست لديك صلاحيات المسؤول في هذه الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        $reservations = Reservation::where('course_id', $course->id)->get();

        foreach ($reservations as $reservation) {
            if ($reservation->coupon == 1) {
                $coupon = $reservation->coupon->discount;
                $amount = ($course->price * $coupon) / 100;
            } else {
                $coupon = "لايوجد";
                $amount = $course->price;
            }
            if (count($reservation->payment) > 0) {
                $subData = array(
                    'student_id' => $reservation->student->id,
                    'student' => $reservation->student->first_name . " " . $reservation->student->second_name,
                    'account_owner' => $reservation->payment->account_owner,
                    'account_number' => $reservation->payment->account_number,
                    'coupon' => $coupon,
                    'amount' => $amount,
                );

                array_push($this->data, $subData);
            }
        }


        array_push($this->response['status'], 'success');
        array_push($this->response['errors'], null);
        array_push($this->response['response'], $this->data);

        return response()->json($this->response);


    }

    // This Function Lets You Active Or Deactivate A Course That Your Have Admin Privilege On
    public function active_deactivate_course(Request $request){
        $request->validate([
            'identifier' => 'required|string|max:10|min:10',
            'activation' => 'required|integer|max:1|min:0',
        ]);

        $course = Course::where('identifier', $request->identifier)->first();

        if ( count($course) < 1 ){
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'الرجاء التأكد من معرف الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        $course_admin = CourseAdmin::where('admin_id', auth('api')->user()->admin->id)->where('course_id', $course->id)->where('role_id', 1)->first();

        if ( count($course_admin) < 1 ){
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'ليست لديك صلاحيات المسؤول في هذه الدورة');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        if ( $course->activation == 0 && $request->activation == 0 ){
            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'الدورة غير مفعلة مسبقا');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        if ( $course->activation == 1 && $request->activation == 0 ){

            $course->activation = 0;
            $course->save();

            array_push($this->response['status'], 'success');
            array_push($this->response['errors'], null);
            array_push($this->response['response'], 'تم إلغاء تفعيل الدورة بنجاح');

            return response()->json($this->response);
        }

        if ( $course->activation == 1 && $request->activation == 1 ){

            $course->activation = 0;
            $course->save();

            array_push($this->response['status'], 'failed');
            array_push($this->response['errors'], 'الدورة مفعلة مسبقا');
            array_push($this->response['response'], null);

            return response()->json($this->response);
        }

        if ( $course->activation == 0 && $request->activation == 1 ){

            $course->activation = 0;
            $course->save();

            array_push($this->response['status'], 'success');
            array_push($this->response['errors'], null);
            array_push($this->response['response'], 'تم تفعيل الدورة بنجاح');

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

        }

        array_push($this->response['status'], 'success');
        array_push($this->response['errors'], null);
        array_push($this->response['response'], $this->data);

        return response()->json($this->response);
    }

    // This Function For Logout
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'successfully logged out']);
    }

    // This Function For Refreshing The Old Token And Replace It With A New One
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
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
