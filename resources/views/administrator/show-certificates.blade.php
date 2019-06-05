@extends('administrator.layouts.master-statistics')

@section('title', $course->name.'شهادات دورة ')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/show-certificates.css') }}">
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
                    <h3 class="panel-title">شهادات دورة  {{ $course->name }}</h3>
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
                                <th class="text-center">اسم الطالب</th>
                                <th class="text-center">الأيام</th>
                                <th class="text-center">تاريخ الإصدار</th>
                                <th class="text-center">اسم المصدر</th>
                                <th class="text-center" colspan="2">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($certificates) > 0)
                                @foreach($certificates as $certificate)
                                    <tr class="gradeX">
                                        <td>{{ $certificate->student->first_name." ".$certificate->student->second_name." ".$certificate->student->third_name." ".$certificate->student->forth_name }}</td>
                                        <td class="ltr">{{ $days }}</td>
                                        <td class="ltr">{{ date("Y-m-d", strtotime($certificate->date)) }}</td>

                                        @if($certificate->admin == 0)
                                            <td>حساب الجهة</td>
                                        @else
                                            <td>{{ $certificate->admin->name }}</td>
                                        @endif

                                        <td>
                                            <a href="#">عرض الشهادة</a>
                                        </td>
                                        <td>
                                            <a href="#">حفظ الشهادة</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="6">
                                        <h3 class="mt-15">لاتوجد شهادات مصدرة لهذه الدورة</h3>
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