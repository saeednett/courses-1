@extends('center.layouts.master-v-1-1')

@section('title', 'تحضير الطلاب')

@section('style-file')

@endsection

@section('content')
    <!-- Main content -->
    @if($errors->any())
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
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
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-success animated fadeInUp">
                    <ul class="text-right rtl">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="modal fade" id="warning-model" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header text-right">
                        <h4 class="modal-title text-danger close" data-dismiss="modal" style="float: right;">تنبيه!</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p class="text-danger">هل تريد إتمام عملية التحضير ؟</p>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success" id="agree-warning">موافق</button>
                        <button class="btn btn-danger" id="cancel-warning">إلغاء</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

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
                        <?php $counter = 0; ?>
                        @foreach($course->reservation as $reservation)
                            @if($reservation->confirmation == 1)
                                <?php $counter++; ?>
                            @endif
                        @endforeach
                        <span><mark>{{ $counter }}</mark></span>
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
                        <table class="table DataTable table-striped table-bordered table-hover">
                            <form method="post" action="{{ route('center.student.take.attendance.confirm', [$course->identifier, $date]) }}" id="attendance-form">
                                {{ csrf_field() }}
                                <thead>
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
                                @if(count($attendances) > 0)
                                    @foreach($attendances as $attendance)

                                            <tr class="gradeX">
                                                <td class="pt-17">{{ $attendance->student->first_name." ".$attendance->student->second_name." ".$attendance->student->third_name }}</td>
                                                <td class="pt-17 ltr">{{ $attendance->student->user->phone }}</td>
                                                <td class="pt-17">{{ $attendance->student->user->email }}</td>
                                                <td class="pt-17">{{ $attendance->student->gender->name }}</td>
                                                <td class="pt-17">{{ $attendance->student->city->name }}</td>
                                                <td>
                                                    @if($attendance->status == 1)
                                                        <input type="checkbox" data-toggle="toggle" class="toggle-input" checked>
                                                    @else
                                                        <input type="checkbox" data-toggle="toggle" class="toggle-input">
                                                    @endif

                                                    <input type="hidden" name="attendance[]" value="{{ $attendance->status }}" form="attendance-form">
                                                    <input type="hidden" name="student[]" value="{{ $attendance->student->id }}" form="attendance-form">
                                                </td>
                                            </tr>

                                    @endforeach
                                @else
                                    @foreach($course->reservation as $reservation)
                                        @if($reservation->confirmation == 1)
                                            <tr class="gradeX">
                                                <td class="pt-17">{{ $reservation->student->first_name." ".$reservation->student->second_name." ".$reservation->student->third_name }}</td>
                                                <td class="pt-17 ltr">{{ $reservation->student->user->phone }}</td>
                                                <td class="pt-17">{{ $reservation->student->user->email }}</td>
                                                <td class="pt-17">{{ $reservation->student->gender->name }}</td>
                                                <td class="pt-17">{{ $reservation->student->city->name }}</td>
                                                <td>
                                                    <input type="checkbox" data-toggle="toggle" class="toggle-input">
                                                    <input type="hidden" name="attendance[]" value="0" form="attendance-form">
                                                    <input type="hidden" name="student[]" value="{{ $reservation->student->id }}" form="attendance-form">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                                </tbody>
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
    <script src="{{ asset('js/main/toggle-button.js') }}"></script>
    <script src="{{ asset('js/center/take-attendance.js') }}"></script>
@endsection