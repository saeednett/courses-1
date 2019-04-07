@extends('administrator.layouts.master-statistics')

@section('title', 'المدربين')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/show-trainers.css') }}">
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
                    <h3 class="panel-title">معلومات المدربين المسجلين في النظام</h3>
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
                                <th class="text-center">الهاتف</th>
                                <th class="text-center">البريد الإلكتروني</th>
                                <th class="text-center">الجهة</th>
                                <th class="text-center">تاريخ التسجيل</th>
                                <th class="text-center">الدورات المسجل فيها</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($trainers) > 0)
                                @foreach($trainers as $trainer)
                                    <tr class="gradeX">
                                        <td>{{ $trainer->name }}</td>
                                        <td class="ltr">{{ $trainer->user->phone }}</td>
                                        <td>{{ $trainer->user->email }}</td>
                                        <td>{{ $trainer->center->name }}</td>
                                        <td class="ltr">{{ date("Y-m-d", strtotime($trainer->created_at)) }}</td>
                                        <td>{{ count($trainer->course) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="6">
                                        <h3 class="mt-15">لايوجد مدربين مسجلين في النظام</h3>
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

@section('script-file')

@endsection