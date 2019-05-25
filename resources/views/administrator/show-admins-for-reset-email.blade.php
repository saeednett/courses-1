@extends('administrator.layouts.master-statistics')

@section('title', 'المسؤولين')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/show-admins-for-reset-email.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    @if(session()->has('success'))
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-success animated fadeInUp">
                    <ul class="rtl mb-0 text-success text-right">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="rtl mb-0 text-danger text-right">
                        <li>{{ $errors->first() }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">إعادة تعيين بريد إستعادة كلمة المرور للمسؤولين</h3>
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
                                <th class="text-center">الهاتف</th>
                                <th class="text-center">البريد الإلكتروني</th>
                                <th class="text-center">الجهة</th>
                                <th class="text-center">تاريخ التسجيل</th>
                                <th class="text-center">الدورات المسجل فيها</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($admins) > 0)
                                @foreach($admins as $admin)
                                    <tr class="gradeX">
                                        <td>{{ $admin->name }}</td>
                                        <td class="ltr">{{ $admin->user->phone }}</td>
                                        <td>{{ $admin->user->email }}</td>
                                        <td>{{ $admin->center->name }}</td>
                                        <td class="ltr">{{ date("Y-m-d", strtotime($admin->created_at)) }}</td>
                                        <td>{{ count($admin->course) }}</td>
                                        <td>
                                            <a href="{{ route('administrator.admin.reset.email.edit', $admin->user->username) }}">اعادة تعيين</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5">
                                        <h3 class="mt-15">لايوجد مسوولين مسجلين في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    {{--<div class="animatedParent animateOnce z-index-50">--}}
                        {{--<div class="animated fadeInUp">--}}
                            {{--{{ $admins->links() }}--}}
                        {{--</div>--}}
                    {{--</div>--}}

                </div>
            </div>

        </div>
    </div>

    <!-- /main content -->
@endsection

@section('script-file')

@endsection