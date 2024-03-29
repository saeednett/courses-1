@extends('admin.layouts.master-statistics')

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
                                <th class="text-center">عدد المقاعد</th>
                                <th class="text-center">عدد الطلاب</th>
                                <th class="text-center">الصلاحيات</th>
                                <th class="text-center" colspan="2">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($courseAdmin) > 0)
                                @foreach($courseAdmin as $admin)
                                    <tr class="gradeX">
                                        <td>{{ $admin->course->title }}</td>
                                        <td class="ltr">{{ date( 'Y-M-D h:i' ,strtotime($admin->course->created_at)) }}</td>
                                        <td>{{ $admin->course->attendance }}</td>
                                        <td>{{ count($admin->course->reservation) }}</td>
                                        @if($admin->role_id == 1)
                                            <td>مسؤول الدور</td>
                                        @else
                                            <td>محضر الدور</td>
                                        @endif

                                        @if($admin->role_id == 1)
                                            <td>
                                                <a href="{{ route('admin.courses.payment', $admin->course->identifier) }}">تأكيد الدفع</a>
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.courses.certificate.create') }}">منح الشهادات</a>
                                            </td>
                                        @else
                                            <td colspan="2">
                                                <a href="{{ route('admin.courses.take.attendance') }}">تحضير الطلاب</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5">
                                        <h3 class="mt-15">لاتوجد دورات مسجلة في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            @if(count($courseAdmin) > 0)
                                <tfoot>
                                <tr>
                                    <th class="text-center">اسم الدورة</th>
                                    <th class="text-center">تاريخ الدورة</th>
                                    <th class="text-center">عدد المقاعد</th>
                                    <th class="text-center">عدد الطلاب</th>
                                    <th class="text-center">الصلاحيات</th>
                                    <th class="text-center" colspan="2">خيارات</th>
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