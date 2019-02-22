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

            $courses = Course::where('center_id', Auth::user()->admin->center->id)->get();
            $trainers = Trainer::where('center_id', Auth::user()->admin->center->id)->get();
            $admins = Admin::where('center_id', Auth::user()->admin->center->id)->get();

            $course_id = Course::select('id')->where('center_id', Auth::user()->admin->center->id)->get();
            $students = Reservation::find($course_id);

            $course_admin = CourseAdmin::where('course_id', 3)->first();

            $total_students = array();

            for ($i = 0; $i < count($students); $i ++){
                if ( $i == 0 ){
                    array_push($total_students, $students[$i]->student_id);
                }else{
                    if( !in_array($students[$i]->student_id, $total_students) ){
                        array_push($total_students, $students[$i]->student_id);
                    }
                }
            }
            $total_students = count($total_students);
            $admin_courses = CourseAdmin::where('admin_id', auth()->user()->admin->id)->get();
            return view('admin.index', compact('admin_courses','courses', 'trainers', 'admins', 'students','total_students'));
        } else {
//            return abort(404);
        }


//        return view('admin.index', compact('courses'));
    }

    public function payment_confirmation($identifier){
        $course = Course::where('identifier', $identifier)->first();
        if ( count($identifier) <= 0 ){
            abort(404);
        }
        $courses  = 1;
        $trainers = 2;
        return view('admin.confirm-payment', compact('course', 'courses', 'trainers'));
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
