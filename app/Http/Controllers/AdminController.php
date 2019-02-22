<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Course;
use App\CourseAdmin;
use App\Reservation;
use App\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // To Show The Main Page Of The Admin
    public function index($admin)
    {


        if ($admin == Auth::user()->username) {

            $courses = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();


            $course_admin = array();
            $course_attender = array();

            $courses_data = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();

            for ($i = 0; $i < count($courses_data); $i++) {

                $course_admin_data = CourseAdmin::where('admin_id', Auth::user()->admin->id)->where('course_id', $courses_data[$i]->id)->first();

                if ( count($course_admin_data) > 0 ){

                    if ($course_admin_data->role_id == 1) {
                        array_push($course_admin, $course_admin_data->course_id);
                    } else {
                        array_push($course_attender, $course_admin_data->course_id);
                    }

                }

            }

            $course_admin = count($course_admin);
            $course_attender = count($course_attender);
            return view('admin.index', compact('courses', 'course_admin', 'course_attender'));
        } else {
            return abort(404);
        }


//        return view('admin.index', compact('courses'));
    }

    public function payment_confirmation($identifier)
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

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
