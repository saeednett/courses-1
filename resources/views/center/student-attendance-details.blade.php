@extends('center.layouts.master-v-1-1')

@section('content')
    <!-- Main content -->

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="block animated fadeInUp">
                <ul class="custom-rules text-right">
                    <li>
                        <span class="fa fa-user text-custom"></span>
                        <span>الطالب:</span>
                        <span><mark>{{ $attendances[0]->student->first_name." ".$attendances[0]->student->second_name." ".$attendances[0]->student->third_name }}</mark></span>
                    </li>

                    <li>
                        <span class="fa fa-phone text-custom"></span>
                        <span>الهاتف:</span>
                        <span><mark>{{ $attendances[0]->student->user->phone }}</mark></span>
                    </li>

                    <li>
                        <span class="fa fa-envelope text-custom"></span>
                        <span>البريد الاإلكتروني:</span>
                        <span><mark>{{ $attendances[0]->student->user->email }}</mark></span>
                    </li>

                    <li>
                        <span class="fa fa-location-arrow text-custom"></span>
                        <span>المدينة:</span>
                        <span><mark>{{ $attendances[0]->student->city->name }}</mark></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات سجل حضور الطالب</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <?php

                            ?>
                            <tr>
                                <th class="text-center" colspan="3"><h4>{{ $course->title }}</h4></th>
                            </tr>
                            <tr>
                                <th class="text-center">التاريخ</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">المحضر</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($attendances) > 0)
                                @foreach($attendances as $attendance)

                                    {{--                                            <td>{{ $reservation->student->first_name." ".$reservation->student->second_name." ".$reservation->student->third_name }}</td>--}}
                                    {{--                                            <td class="ltr">{{ $reservation->student->user->phone }}</td>--}}

                                    <tr class="gradeX">

                                        <td class="text-center ltr">{{ $attendance->date }}</td>
                                        @if($attendance->status == 1)
                                            <td class="text-center text-success">حاضر</td>
                                        @else
                                            <td class="text-center text-danger">غائب</td>
                                        @endif


                                        <td class="text-center ltr">{{ $attendance->admin->name }}</td>
                                    </tr>

                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="{{ $days+2 }}">
                                        <h3 class="mt-15">لم بتم تحضير الطالب في اي يوم من ايام الدورة</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main content -->
@endsection