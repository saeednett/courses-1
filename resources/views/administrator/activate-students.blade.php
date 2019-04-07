@extends('administrator.layouts.master-statistics')

@section('title', 'تفعيل الطلاب')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/activate-students.css') }}">
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
        <div class="modal fade" id="warning-model" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header text-right">
                        <h4 class="modal-title text-danger close" data-dismiss="modal" style="float: right;">تنبيه!</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p class="text-danger">عند إلغاء تفعيل الطالب سوف يتم منعه من تسجيل الدخول إلى أن يتم إعادة تفعيله</p>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success" id="agree-warning">موافق</button>
                        <button class="btn btn-danger" id="cancel-warning">إلغاء</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

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
                                <th class="text-center">تاريخ التسجيل</th>
                                <th class="text-center">المدينة</th>
                                <th class="text-center">الجنس</th>
                                <th class="text-center">الدورات المسجل فيها</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($students) > 0)
                                @foreach($students as $student)
                                    <tr class="gradeX">
                                        <td class="pt-18">
                                            {{ $student->first_name." ".$student->second_name." ".$student->third_name." ".$student->forth_name }}
                                            <input type="hidden" name="students[]" value="{{ $student->id }}"
                                                   form="activation-form">
                                        </td>
                                        <td class="ltr pt-18">{{ $student->user->phone }}</td>
                                        <td class="pt-18">{{ $student->user->email }}</td>
                                        <td class="ltr pt-18">{{ date("Y-m-d", strtotime($student->created_at)) }}</td>
                                        <td class="pt-18">{{ $student->city->name }}</td>
                                        <td class="pt-18">{{ $student->gender->name }}</td>
                                        <td class="pt-18">{{ count($student->reservation) }}</td>
                                        <td>

                                            @if($student->user->status == 1)
                                                <input type="checkbox" class="toggle" data-toggle="toggle" checked>

                                                <input type="hidden" name="activations[]" value="1"
                                                       form="activation-form">
                                            @else
                                                <input type="checkbox" class="toggle" data-toggle="toggle">

                                                <input type="hidden" name="activations[]" value="0"
                                                       form="activation-form">
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="8">
                                        <h3 class="mt-15">لايوجد طلاب مسجلين في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    @if(count($students) > 0)
                        <form method="post" action="{{ route('administrator.students.activation.deactivation.confirm') }}"
                              id="activation-form">
                            {{ csrf_field() }}
                            <button class="btn btn-success col-lg-2" id="activation-form-save-changes">
                                موافق
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- /main content -->
@endsection

@section('script-file')
    <script src="{{ asset('js/main/toggle-button.js') }}"></script>
    <script src="{{ asset('js/administrator/activate-students.js') }}"></script>
@endsection