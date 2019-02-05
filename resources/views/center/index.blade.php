@extends('center.master-v-1-1')

@section('content')

    <!-- Main content -->

    <style>
        .warning-color {
            color: #fff466;
        }
    </style>

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات الدورات المسجلة في النظام</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">اسم الدورة</th>
                                <th class="text-center">تاريخ الدورة</th>
                                <th class="text-center">عدد المدربين</th>
                                <th class="text-center">عدد الطلاب</th>
                                <th class="text-center">الحالة</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($courses) > 0)
                                @foreach($courses as $course)
                                    @foreach($course->appointment as $appointment)
                                        <tr class="gradeX">

                                            <td class="ltr">
                                                {{ $course->title }}
                                            </td>

                                            @if($appointment->date > date('Y-m-d'))
                                                <td class="ltr">
                                                    <i class="icon-check icon-larger green-color" title="بقي لها"></i>
                                                    {{ date( 'Y-M-d h:i' ,strtotime($appointment->date." ".$appointment->time)) }}
                                                </td>
                                            @elseif($appointment->date == date('Y-m-d'))
                                                <td class="ltr">
                                                    <i class="icon-check icon-larger warning-color" title="اليوم"></i>
                                                    {{ date( 'Y-M-d h:i' ,strtotime($appointment->date." ".$appointment->time)) }}
                                                </td>
                                            @else
                                                <td class="ltr">
                                                    <i class="icon-cancel icon-larger red-color" title="منهية"></i>
                                                    {{ date( 'Y-M-d h:i' ,strtotime($appointment->date." ".$appointment->time)) }}
                                                </td>
                                            @endif
                                            <td>{{ count($appointment->course->trainer) }}</td>
                                            <td>{{ count($appointment->reservation) }}</td>

                                            @if($appointment->course->validation == 1)
                                                <td>
                                                    <span>مؤكدة</span>
                                                    <i class="icon-check icon-larger green-color" title="مؤكدة"></i>
                                                </td>
                                            @else
                                                <td>
                                                    <span>غير مؤكدة</span>
                                                    <i class="icon-cancel icon-larger red-color" title="غير مؤكدة"></i>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5"><h3 style="margin-top: 15px">لا توجد دورات مسجلة في النظام</h3></td>
                                </tr>
                            @endif
                            </tbody>
                            @if(count($courses) > 0)
                                <tfoot>
                                <tr>
                                    <th class="text-center">اسم الكورس</th>
                                    <th class="text-center">التاريخ</th>
                                    <th class="text-center">عدد المدربين</th>
                                    <th class="text-center">عدد الطلاب</th>
                                    <th class="text-center">الحالة</th>
                                </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات المسؤولين المسجلة في النظام</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">اسم المسؤول</th>
                                <th class="text-center">تاريخ الإضافة</th>
                                <th class="text-center">عدد الدورات</th>
                                <th class="text-center">محضر دورة</th>
                                <th class="text-center">مسؤول دورة</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            <?php
                                    $course_admin = 0;
                                    $course_attendance = 0;
                            ?>
                            @if(count($admins) > 0)
                                @foreach($admins as $admin)
                                    <tr class="gradeX">
                                        <td>{{ $admin->user->name }}</td>
                                        <td class="ltr">{{ date( 'Y-M-D h:i' ,strtotime($admin->user->created_at)) }}</td>
                                        <td>{{ count($admin->user->course) }}</td>
                                        @if(count($admin->course) > 0)
                                            @foreach($admin->course as $course_details)
                                                @if ($course_details->role_id == 1)
                                                    <?php $course_admin++; ?>
                                                @else
                                                    <?php $course_attendance++; ?>
                                                @endif
                                            @endforeach
                                            <td>{{ $course_admin }}</td>
                                            <td>{{ $course_attendance }}</td>
                                        @else
                                            <td>0</td>
                                            <td>0</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5">
                                        <h3 style="margin-top: 15px">لا يوجد مسؤولين مسجلين في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            @if(count($admins) > 0)
                                <tfoot>
                                <tr>
                                    <th class="text-center">اسم المسؤول</th>
                                    <th class="text-center">تاريخ الإضافة</th>
                                    <th class="text-center">عدد الدورات</th>
                                    <th class="text-center">محضر دورة</th>
                                    <th class="text-center">مسؤول دورة</th>
                                </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات المدربين المسجلة في النظام</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">اسم المدرب</th>
                                <th class="text-center">تاريخ الإضافة</th>
                                <th class="text-center">عدد الدورات</th>
                                <th class="text-center">اللقب</th>
                                <th class="text-center">الجنسية</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($trainers) > 0)
                                @foreach($trainers as $trainer)
                                    <tr class="gradeX">
                                        <td>{{ $trainer->user->name }}</td>
                                        <td class="ltr">{{ date( 'Y-M-D h:i' ,strtotime($trainer->user->created_at)) }}</td>
                                        <td>{{ count($trainer->course) }}</td>
                                        <td>{{ $trainer->title->name }}</td>
                                        <td>{{ $trainer->nationality->name }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5"><h3 style="margin-top: 15px">لا يوجد مدربين مسجلين في النظام</h3></td>
                                </tr>
                            @endif
                            </tbody>
                            @if(count($trainers) > 0)
                                <tfoot>
                                <tr>
                                    <th class="text-center">اسم المدرب</th>
                                    <th class="text-center">تاريخ الإضافة</th>
                                    <th class="text-center">عدد الدورات</th>
                                    <th class="text-center">اللقب</th>
                                    <th class="text-center">الجنسية</th>
                                </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /main content -->


@endsection