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
                                <th class="text-center">عدد الطلاب</th>
                                <th class="text-center">الصلاحيات</th>
                                <th class="text-center" colspan="3">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($admin_courses) > 0)
                                @foreach($admin_courses as $course)
                                    <tr class="gradeX">
                                        <td>{{ $course->course->title }}</td>
                                        <td class="ltr">{{ date( 'Y-M-D h:i' ,strtotime($course->course->created_at)) }}</td>
                                        <td>{{ count($course->course->appointment->reservation) }}</td>
                                        @if($course->role_id == 1)
                                            <td>مسؤول الدور</td>
                                            {{--<td class="size-80 text-center">--}}
                                                {{--<div class="dropdown">--}}
                                                    {{--<a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>--}}
                                                    {{--<ul class="dropdown-menu dropdown-menu-right">--}}
                                                        {{--<li>--}}
                                                            {{--<a href="">--}}
                                                                {{--<span>تأكيد الدفع</span>--}}
                                                                {{--<i class="icon-thumbs-up pull-right text-success"></i>--}}
                                                            {{--</a>--}}
                                                        {{--</li>--}}
                                                        {{--<li>--}}
                                                            {{--<a href="#">--}}
                                                                {{--<span>تعديل الدورة</span>--}}
                                                                {{--<i class="fa fa-pencil-square pull-right text-primary"></i>--}}
                                                            {{--</a>--}}
                                                        {{--</li>--}}
                                                        {{--<li>--}}
                                                            {{--<a href="#" class="center-block">--}}
                                                                {{--<span>منح الشهادات</span>--}}
                                                                {{--<i class="icon-minus-circled pull-right text-warning"></i>--}}
                                                            {{--</a>--}}
                                                        {{--</li>--}}
                                                    {{--</ul>--}}
                                                {{--</div>--}}
                                            {{--</td>--}}
                                        @else
                                            <td>محضر الدور</td>
                                            {{--<td class="size-80 text-center">--}}
                                                {{--<div class="dropdown">--}}
                                                    {{--<a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>--}}
                                                    {{--<ul class="dropdown-menu dropdown-menu-right">--}}
                                                        {{--<li>--}}
                                                            {{--<a href="">--}}
                                                                {{--<span>تحضير الطلاب</span>--}}
                                                                {{--<i class="icon-check pull-right text-success"></i>--}}
                                                            {{--</a>--}}
                                                        {{--</li>--}}
                                                    {{--</ul>--}}
                                                {{--</div>--}}
                                            {{--</td>--}}
                                        @endif
                                        <td>
                                            <a href="#">تعديل</a>
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.courses.payment', $course->course->identifier) }}">تأكيد الدفع</a>
                                        </td>

                                        <td>
                                            <a href="#">منح الشهادات</a>
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5">
                                        <h3 style="margin-top: 15px">لاتوجد دورات مسجلة في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            @if(count($admin_courses) > 2)
                                <tfoot>
                                <tr>
                                    <th class="text-center">اسم الكورس</th>
                                    <th class="text-center">التاريخ</th>
                                    <th class="text-center">عدد المدربين</th>
                                    <th class="text-center">عدد الطلاب</th>
                                    <th class="text-center" colspan="3">الحالة</th>
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