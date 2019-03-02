@extends('admin.layouts.master')

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
                    <h3 class="panel-title">بيانات سجل الحضور للدورة</h3>
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
                            $date1 = date_create($course->start_date);
                            $date2 = date_create($course->finish_date);
                            $diff = date_diff($date1, $date2);
                            $days = $diff->format("%a");
                            ?>
                            <tr>
                                <th class="text-center" colspan="{{ $days+2 }}"><h4>{{ $course->title }}</h4></th>
                            </tr>
                            <tr>
                                <th class="text-center">اسم الطالب</th>
                                <th class="text-center">رقم الهاتف</th>
                                @for($i = 0; $i < $days; $i++)
                                    @switch($i)
                                        @case(0)
                                        <th class="text-center">اليوم الأول</th>
                                        @break

                                        @case(1)
                                        <th class="text-center">اليوم الثاني</th>
                                        @break

                                        @case(2)
                                        <th class="text-center">اليوم الثالث</th>
                                        @break

                                        @case(3)
                                        <th class="text-center">اليوم الرابع</th>
                                        @break

                                        @case(4)
                                        <th class="text-center">اليوم الخامس</th>
                                        @break

                                        @case(5)
                                        <th class="text-center">اليوم السادس</th>
                                        @break
                                        @case(6)
                                        <th class="text-center">اليوم السابع</th>
                                        @break

                                        @case(7)
                                        <th class="text-center">اليوم الثامن</th>
                                        @break

                                        @case(8)
                                        <th class="text-center">اليوم التاسع</th>
                                        @break

                                        @case(9)
                                        <th class="text-center">اليوم العاشر</th>
                                        @break

                                    @endswitch
                                @endfor
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($course->reservation) > 0)
                                @foreach($course->reservation as $reservation)
                                    @if($reservation->confirmation == 1)
                                        <tr class="gradeX">
                                            <td>{{ $reservation->student->user->name }}</td>
                                            <td style="direction: ltr;">{{ $reservation->student->user->phone }}</td>
                                            @for($i = 0; $i < $days; $i++)




                                                {{--// $course->id == $reservation->student->attendance[$i]->course_id--}}
                                                @if(isset($reservation->student->attendance[$i]))
                                                    @if($reservation->student->attendance[$i]->status > 0)
                                                        <td>
                                                            <i class="fa fa-check-circle-o text-success bg-success"></i>
                                                        </td>
                                                    @else
                                                        <td><i class="fa fa-times-circle text-danger bg-danger"></i>
                                                        </td>
                                                    @endif


                                                @else
                                                    <td>
                                                        <i class="fa fa-question-circle text-warning bg-warning"></i>
                                                    </td>
                                                @endif

                                            @endfor
                                        </tr>
                                    @else
                                        <td class="text-danger" colspan="{{ $days+2 }}">
                                            <h3 style="margin-top: 15px">لم يتم تأكيد التسجيل لأي طالب</h3>
                                        </td>
                                    @endif
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="{{ $days+2 }}">
                                        <h3 style="margin-top: 15px">لايوجد طلاب مسجلين في الدورة</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            @if(count($course->reservation) > 0)
                                @if($reservation->confirmation == 1)
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">اسم الطالب</th>
                                        <th class="text-center">رقم الهاتف</th>
                                        @for($i = 0; $i < $days; $i++)
                                            @switch($i)
                                                @case(0)
                                                <th class="text-center">اليوم الأول</th>
                                                @break

                                                @case(1)
                                                <th class="text-center">اليوم الثاني</th>
                                                @break

                                                @case(2)
                                                <th class="text-center">اليوم الثالث</th>
                                                @break

                                                @case(3)
                                                <th class="text-center">اليوم الرابع</th>
                                                @break

                                                @case(4)
                                                <th class="text-center">اليوم الخامس</th>
                                                @break

                                                @case(5)
                                                <th class="text-center">اليوم السادس</th>
                                                @break
                                                @case(6)
                                                <th class="text-center">اليوم السابع</th>
                                                @break

                                                @case(7)
                                                <th class="text-center">اليوم الثامن</th>
                                                @break

                                                @case(8)
                                                <th class="text-center">اليوم التاسع</th>
                                                @break

                                                @case(9)
                                                <th class="text-center">اليوم العاشر</th>
                                                @break
                                            @endswitch
                                        @endfor
                                    </tr>
                                    </tfoot>
                                @endif
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main content -->
@endsection