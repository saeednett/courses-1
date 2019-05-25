@extends('center.layouts.master-v-1-1')

@section('title', "عرض المسؤولين")
@section('main-title', "عرض المسؤولين")

@section('page-links')
    <li><a href="{{ route('center.index', Auth::user()->username) }}"><i class="fa fa-users"></i>المسؤولين</a></li>
    <li class="active"><a href="{{ route('center.admin.show') }}"><i class="fa fa-user"></i>عرض المسؤولين</a></li>
@endsection


@section('content')
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
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">اسم المسؤول</th>
                                <th class="text-center">تاريخ الإضافة</th>
                                <th class="text-center">عدد الدورات</th>
                                <th class="text-center">محضر دورة</th>
                                <th class="text-center">مسؤول دورة</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            <?php
                                $course_admin = 0;
                                $course_attendance = 0;
                            ?>
                            @if(count($all_admins) > 0)
                                @foreach($all_admins as $admin)
                                    <tr class="gradeX">
                                        <td>{{ $admin->name }}</td>
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
                                            <td class="size-80 text-center">
                                                <div class="dropdown">
                                                    <a class="more-link" data-toggle="dropdown" href="#/"><i
                                                                class="icon-dot-3 ellipsis-icon"></i></a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <li>
                                                            <a href="">
                                                                <span>حذف</span>
                                                                <i class="icon-trash pull-right text-danger"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('center.admin.edit', $admin->id) }}">
                                                                <span>تعديل</span>
                                                                <i class="fa fa-pencil-square pull-right text-success"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        @else
                                            <td>0</td>
                                            <td>0</td>
                                            <td class="size-80 text-center">
                                                <div class="dropdown">
                                                    <a class="more-link" data-toggle="dropdown" href="#/"><i
                                                                class="icon-dot-3 ellipsis-icon"></i></a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <li>
                                                            <a href="">
                                                                <span>حذف</span>
                                                                <i class="icon-trash pull-right text-danger"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('center.admin.edit', $admin->id) }}">
                                                                <span>تعديل</span>
                                                                <i class="fa fa-pencil-square pull-right text-success"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="6"><h3>لا يوجد مسؤولين مسجلين في النظام</h3></td>
                                </tr>
                            @endif
                            </tbody>
                            @if(count($all_admins) < 0)
                                <tfoot>
                                <tr>
                                    <th class="text-center">اسم المسؤول</th>
                                    <th class="text-center">تاريخ الإضافة</th>
                                    <th class="text-center">عدد الدورات</th>
                                    <th class="text-center">محضر دورة</th>
                                    <th class="text-center">مسؤول دورة</th>
                                    <th class="text-center">خيارات</th>
                                </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection