@extends('administrator.layouts.master-statistics')

@section('title', 'شهادات الدورات')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/show-centers-for-certificates.css') }}">
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
                    <h3 class="panel-title">الجهات الخاصة بالشهادات</h3>
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
                                <th class="text-center">اسم الجهة</th>
                                <th class="text-center">الهاتف</th>
                                <th class="text-center">البريد الإلكتروني</th>
                                <th class="text-center">التصنيف</th>
                                <th class="text-center">الدورات</th>
                                <th class="text-center">تاريخ اتسجيل</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($centers) > 0)
                                @foreach($centers as $center)
                                    <tr class="gradeX">
                                        <td>
                                            {{ $center->name }}
                                        </td>
                                        <td class="ltr">{{ $center->user->phone }}</td>
                                        <td>{{ $center->user->email }}</td>
                                        @if($center->type == 1)
                                            <td>ربحية</td>
                                        @else
                                            <td>غير ربحية</td>
                                        @endif
                                        <td>{{ count($center->course) }}</td>
                                        <td class="ltr">{{ date("Y-m-d", strtotime($center->created_at)) }}</td>
                                        <td>
                                            <a href="{{ route('administrator.courses.certificates.show', $center->user->username) }}">عرض الدورات</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="6">
                                        <h3 class="mt-15">لاتوجد جهات مسجلة في النظام</h3>
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