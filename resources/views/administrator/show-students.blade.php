@extends('administrator.layouts.master-statistics')

@section('title', 'الطلاب')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/show-students.css') }}">
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
                    <h3 class="panel-title">الطلاب المسجلين في النظام</h3>
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
                                <th class="text-center">الهاتف</th>
                                <th class="text-center">البريد الإلكتروني</th>
                                <th class="text-center">الجنس</th>
                                <th class="text-center">تاريخ التسجيل</th>
                                <th class="text-center">الدورات المسجل فيها</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($students) > 0)
                                @foreach($students as $student)
                                    <tr class="gradeX">
                                        <td>{{ $student->first_name." ".$student->second_name." ".$student->third_name." ".$student->forth_name }}</td>
                                        <td class="ltr">{{ $student->user->phone }}</td>
                                        <td>{{ $student->user->email }}</td>
                                        <td>{{ $student->gender->name }}</td>
                                        <td class="ltr">{{ date("Y-m-d", strtotime($student->created_at)) }}</td>
                                        <td>{{ count($student->reservation) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5">
                                        <h3 class="mt-15">لايوجد طلاب مسجلين في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="animatedParent animateOnce z-index-50">
                <div class="animated fadeInUp">
                    {{ $students->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- /main content -->
@endsection

@section('script-file')
    
@endsection