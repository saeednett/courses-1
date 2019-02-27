@extends('center.master-v-1-1')

@section('title', "عرض المدربين")
@section('main-title', "عرض المدربين")

@section('page-links')
    <li><a href="{{ route('center.index', Auth::user()->username) }}"><i class="fa fa-users"></i>المدربين</a></li>
    <li class="active"><a href="{{ route('center.trainer.show') }}"><i class="fa fa-user"></i>عرض المدربين</a></li>
@endsection


@section('content')
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
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">اسم المدرب</th>
                                <th class="text-center">تاريخ الإضافة</th>
                                <th class="text-center">عدد الدورات</th>
                                <th class="text-center">اللقب</th>
                                <th class="text-center">الجنسية</th>
                                <th class="text-center">خيارات</th>
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
                                        <td class="size-80 text-center">
                                            <div class="dropdown">
                                                <a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>
                                                        <a href="">
                                                            <span>حذف</span>
                                                            <i class="icon-trash pull-right text-danger"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('center.trainer.edit', $trainer->id) }}">
                                                            <span>تعديل</span>
                                                            <i class="fa fa-pencil-square pull-right text-success"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="center-block">
                                                            <span> تجميد المدرب</span>
                                                            <i class="icon-minus-circled pull-right text-warning"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5"><h3>لا يوجد مدربين مسجلين في النظام</h3></td>
                                </tr>
                            @endif
                            </tbody>
                            @if(count($trainers) < 0)
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
@endsection