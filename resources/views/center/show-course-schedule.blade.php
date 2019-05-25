@extends('center.layouts.master-v-1-1')

@section('content')
    <!-- Main content -->
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

                            <tr class="text-center">
                                <th class="text-center">التاريخ</th>
                                <th class="text-center">التحضير</th>
                            </tr>
                            </thead>
                            <tbody class="text-center d-none">
                            @if($days > 0)
                                @for($i = 0; $i < $days; $i++)
                                    <tr class="gradeX">


                                        @if(date("Y-m-d", strtotime($course->start_date." +$i Day")) == date('Y-m-d'))
                                            <td class="text-center bg-success"><a class="text-success"
                                                                                  href="{{ route('center.student.attendance.take', [$course->identifier, date("Y-m-d", strtotime($course->start_date." +$i Day"))]) }}">{{ date("Y-m-d", strtotime($course->start_date." +$i Day")) }}</a>
                                            </td>
                                        @elseif(date("Y-m-d", strtotime($course->start_date." +$i Day")) < date('Y-m-d'))
                                            <td class="text-center bg-danger"><a class="text-danger"
                                                                                 href="{{ route('center.student.attendance.take', [$course->identifier, date("Y-m-d", strtotime($course->start_date." +$i Day"))]) }}">{{ date("Y-m-d", strtotime($course->start_date." +$i Day")) }}</a>
                                            </td>
                                        @elseif(date("Y-m-d", strtotime($course->start_date." +$i Day")) > date('Y-m-d'))
                                            <td class="text-center bg-warning"><a class="text-warning"
                                                                                  href="{{ route('center.student.attendance.take', [$course->identifier, date("Y-m-d", strtotime($course->start_date." +$i Day"))]) }}">{{ date("Y-m-d", strtotime($course->start_date." +$i Day")) }}</a>
                                            </td>
                                        @endif


                                        <td class="text-center">
                                            <a href="{{ route('center.student.attendance.take', [$course->identifier, date("Y-m-d", strtotime($course->start_date." +$i Day"))]) }}">تحضير
                                                الطلاب</a>
                                        </td>

                                    </tr>
                                @endfor
                            @else

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