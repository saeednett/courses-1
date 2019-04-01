@extends('admin.layouts.master')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/admin/take-attendance.css') }}"/>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('content')
    <!-- Main content -->
    @if($errors->any())
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-danger">
                    <ul class="text-right rtl">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success">
                    <ul class="text-right rtl">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="block animated fadeInUp">
                <ul class="custom-rules text-right">
                    <li>
                        <span class="fa fa-book text-custom"></span>
                        <span>الدورة:</span>
                        <span><mark>{{ $course->title }}</mark></span>
                    </li>

                    <li>
                        <span class="fa fa-calendar text-custom"></span>
                        <span>التاريخ:</span>
                        <span><mark>{{ date('Y-m-d') }}</mark></span>
                    </li>

                    <li>
                        <span class="fa fa-check-circle text-custom"></span>
                        <span>المقاعد:</span>
                        <span><mark>{{ $course->attendance }}</mark></span>
                    </li>

                    <li>
                        <span class="fa fa-clock-o text-custom"></span>
                        <span>المدة:</span>
                        <span><mark>{{ $days }}</mark></span>
                    </li>

                    <li>
                        <span class="fa fa-users text-custom"></span>
                        <span>الطلاب:</span>
                        <span><mark>{{ $students }}</mark></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">تحضير الطلاب</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <form method="post" action="{{ route('admin.course.take.attendance.confirm', [$course->identifier, date('Y-m-d')]) }}">
                                {{ csrf_field() }}
                                <thead>
                                <tr>
                                    <th class="text-center" colspan="5"><h3>لا تقم بتغير الخيار إذا كنت لا تريد تحضير
                                            الطالب</h3></th>
                                    <th>
                                        <button class="btn btn-block btn-success">حفظ</button>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-center">اسم الطالب</th>
                                    <th class="text-center">رقم الهاتف</th>
                                    <th class="text-center">البريد الإلكتروني</th>
                                    <th class="text-center">الجنس</th>
                                    <th class="text-center">المدينة</th>
                                    <th class="text-center">التحضير</th>
                                </tr>
                                </thead>
                                <tbody class="text-center d-none">
                                @if(count($course->reservation) > 0)
                                    @foreach($course->reservation as $reservation)
                                        @if($reservation->confirmation == 1)
                                            <tr class="gradeX">
                                                <td class="pt-17">{{ $reservation->student->first_name." ".$reservation->student->second_name." ".$reservation->student->third_name }}</td>
                                                <td class="pt-17 ltr">{{ $reservation->student->user->phone }}</td>
                                                <td class="pt-17">{{ $reservation->student->user->email }}</td>
                                                <td class="pt-17">{{ $reservation->student->gender->name }}</td>
                                                <td class="pt-17">{{ $reservation->student->city->name }}</td>
                                                <td>
                                                    @if(isset($reservation->student->attendance[0]))

                                                        @foreach($reservation->student->attendance as $attendance)
                                                            @if( $attendance->course_id == $reservation->course->id && $attendance->date == date('Y-m-d') )
                                                                @if($attendance->status == 1)
                                                                    <input type="checkbox" data-toggle="toggle" class="attendance-toggle" checked>
                                                                    <input type="hidden" name="attendance[]" value="{{ $attendance->status }}">
                                                                    <input type="hidden" name="student[]" value="{{ $reservation->student->id }}">
                                                                @else
                                                                    <input type="checkbox" data-toggle="toggle" class="attendance-toggle">
                                                                    <input type="hidden" name="attendance[]" value="0">
                                                                    <input type="hidden" name="student[]" value="{{ $reservation->student->id }}">
                                                                @endif
                                                            @else
                                                                <input type="checkbox" data-toggle="toggle" class="attendance-toggle">
                                                                <input type="hidden" name="attendance[]" value="0">
                                                                <input type="hidden" name="student[]" value="{{ $reservation->student->id }}">
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" class="attendance-toggle">
                                                        <input type="hidden" name="attendance[]" value="0">
                                                        <input type="hidden" name="student[]" value="{{ $reservation->student->id }}">
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr class="gradeX">
                                        <td class="text-danger" colspan="5">
                                            <h3 style="margin-top: 15px">لايوجد طلاب مسجلين في الدورة</h3>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                                @if(count($course->reservation) > 0)
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">اسم الطالب</th>
                                        <th class="text-center">رقم الهاتف</th>
                                        <th class="text-center">البريد الإلكتروني</th>
                                        <th class="text-center">الجنس</th>
                                        <th class="text-center">المدينة</th>
                                        <th class="text-center">التحضير</th>
                                    </tr>
                                    </tfoot>
                                @endif
                            </form>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main content -->
@endsection

@section('script-file')
    <script src="{{ asset('js/admin/take-attendance-toggle.js') }}"></script>
    <script src="{{ asset('js/admin/take-attendance.js') }}"></script>
@endsection