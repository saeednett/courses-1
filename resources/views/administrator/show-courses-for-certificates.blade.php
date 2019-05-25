@extends('administrator.layouts.master-statistics')

@section('title', 'شهادات الدورات')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/show-courses-for-certificates.css') }}">
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
                    <h3 class="panel-title">شهادات الدورات المسجلة في النظام</h3>
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
                                <th class="text-center">المدينة</th>
                                <th class="text-center">عدد المقاعد</th>
                                <th class="text-center">عدد الطلاب</th>
                                <th class="text-center">الجنس</th>
                                <th class="text-center">المدربين</th>
                                <th class="text-center">المسؤولين</th>
                                <th class="text-center">الشهادات</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($courses) > 0)
                                @foreach($courses as $course)
                                    <tr class="gradeX">
                                        <td>
                                            {{ $course->title }}
                                        </td>
                                        <td class="ltr">{{ date( 'Y-M-D h:i' ,strtotime($course->created_at)) }}</td>
                                        <td>{{ $course->city->name }}</td>
                                        <td>{{ $course->attendance }}</td>
                                        <td>{{ count($course->reservation) }}</td>

                                        @if($course->gender == 1)
                                            <td>رجال</td>
                                        @elseif($course->gender == 2)
                                            <td>نساء</td>
                                        @else
                                            <td>رجال ونساء</td>
                                        @endif


                                        <td>{{ count($course->trainer) }}</td>
                                        <td>{{ count($course->admin) }}</td>
                                        <td>{{ count($course->certificate) }}</td>

                                        <td>
                                            <a href="{{ route('administrator.certificates.show', $course->identifier) }}">عرض الشهادات</a>
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="6">
                                        <h3 class="mt-15">لاتوجد دورات مسجلة في النظام</h3>
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