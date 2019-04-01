@extends('admin.layouts.master')

@section('content')
    <!-- Main content -->
    <style>
        .warning-color {
            color: #fff466;
        }

        .pt-17 {
            padding-top: 17px;
        }
    </style>
    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">جدول مواعيد الدورة</h3>
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
                                <th class="text-center" colspan="{{ $days }}"><h3
                                            class="pt-17">{{ $course->title }}</h3></th>
                            </tr>
                            <tr>
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

                                        @case(10)
                                        <th class="text-center">اليوم الحادي عشر</th>
                                        @break

                                        @case(11)
                                        <th class="text-center">اليوم الثاني عشر</th>
                                        @break

                                        @case(12)
                                        <th class="text-center">اليوم الثالث عشر</th>
                                        @break

                                        @case(13)
                                        <th class="text-center">اليوم الرابع عشر</th>
                                        @break

                                        @case(14)
                                        <th class="text-center">اليوم الخامس عشر</th>
                                        @break

                                        @case(15)
                                        <th class="text-center">اليوم السادس عشر</th>
                                        @break

                                        @case(16)
                                        <th class="text-center">اليوم السابع عشر</th>
                                        @break

                                        @case(17)
                                        <th class="text-center">اليوم الثامن عشر</th>
                                        @break

                                        @case(18)
                                        <th class="text-center">اليوم التاسع عشر</th>
                                        @break

                                        @case(19)
                                        <th class="text-center">اليوم العشرون</th>
                                        @break

                                        @case(20)
                                        <th class="text-center">اليوم الحادي والعشرون</th>
                                        @break

                                        @case(21)
                                        <th class="text-center">اليوم الثاني والعشرون</th>
                                        @break

                                        @case(22)
                                        <th class="text-center">اليوم الثالث والعشرون</th>
                                        @break

                                        @case(23)
                                        <th class="text-center">اليوم الرايع والعشرون</th>
                                        @break

                                        @case(24)
                                        <th class="text-center">اليوم الخامس والعشرون</th>
                                        @break

                                        @case(25)
                                        <th class="text-center">اليوم السادس والعشرون</th>
                                        @break

                                        @case(26)
                                        <th class="text-center">اليوم السايع والعشرون</th>
                                        @break

                                        @case(27)
                                        <th class="text-center">اليوم الثامن والعشرون</th>
                                        @break



                                    @endswitch
                                @endfor
                            </tr>
                            </thead>
                            <tbody class="text-center d-none">
                            @if($days > 0)
                                <tr class="gradeX">
                                    @for($i = 0; $i < $days; $i++)

                                        @if($i == 0 && $course->start_date == date("Y-m-d"))

                                            <td class="text-center bg-success"><a class="text-success"
                                                                                  href="{{ route('admin.course.take.attendance', [$course->identifier, date("Y-m-d")]) }}">{{ date("Y-m-d", strtotime($course->start_date)) }}</a>
                                            </td>

                                        @else

                                            @if(date("Y-m-d", strtotime($course->start_date." +$i Day")) == date('Y-m-d'))
                                                <td class="text-center bg-success"><a class="text-success"
                                                                                      href="{{ route('admin.course.take.attendance', [$course->identifier, date("Y-m-d", strtotime($course->start_date." +$i Day"))]) }}">{{ date("Y-m-d", strtotime($course->start_date." +$i Day")) }}</a>
                                                </td>
                                            @elseif(date("Y-m-d", strtotime($course->start_date." +$i Day")) < date('Y-m-d'))
                                                <td class="text-center bg-danger"><a class="text-danger"
                                                                                     href="{{ route('admin.course.take.attendance', [$course->identifier, date("Y-m-d", strtotime($course->start_date." +$i Day"))]) }}">{{ date("Y-m-d", strtotime($course->start_date." +$i Day")) }}</a>
                                                </td>
                                            @elseif(date("Y-m-d", strtotime($course->start_date." +$i Day")) > date('Y-m-d'))
                                                <td class="text-center bg-warning"><a class="text-warning"
                                                                                      href="{{ route('admin.course.take.attendance', [$course->identifier, date("Y-m-d", strtotime($course->start_date." +$i Day"))]) }}">{{ date("Y-m-d", strtotime($course->start_date." +$i Day")) }}</a>
                                                </td>
                                            @endif

                                        @endif


                                    @endfor
                                </tr>
                            @else

                            @endif
                            </tbody>
                            @if($days > 0)
                                <tfoot>
                                <tr>
                                    @for($i = 0; $i < $days; $i++)
                                        <?php $class = ""; ?>


                                            @if($i == 0 && $course->start_date == date("Y-m-d"))

                                                <?php $class = "text-success"; ?>
                                                <th class="text-center {{ $class }}"><span
                                                            class="fa fa-check-circle-o"></span></th>

                                            @else

                                                @if(date("Y-m-d", strtotime($course->start_date." +$i Day")) < date('Y-m-d'))
                                                    <?php $class = "text-danger"; ?>
                                                    <th class="text-center {{ $class }}"><span
                                                                class="fa fa-check-circle-o"></span></th>
                                                @elseif(date("Y-m-d", strtotime($course->start_date." +$i Day")) > date('Y-m-d'))
                                                    <?php $class = "text-warning"; ?>
                                                    <th class="text-center {{ $class }}"><span
                                                                class="fa fa-question-circle"></span></th>
                                                @else
                                                    <?php $class = "text-success"; ?>
                                                    <th class="text-center {{ $class }}"><span
                                                                class="fa fa-check-circle-o"></span></th>
                                                @endif

                                            @endif

                                    @endfor
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