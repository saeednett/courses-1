@extends('admin.layouts.master')

@section('content')
    <!-- Main content -->
    <style>
        .warning-color {
            color: #fff466;
        }

        .pt-17 {
            padding-top: 17px !important;
        }
    </style>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">


    @if(session()->has('success'))
        <div class="" id="note"
             style="width: 100%; height: 100%; z-index: 1500; background: #bbb4b491; position: fixed; top: 0; left: 0; right: 0; margin: 0; padding: 0;">
            <div class="col-lg-4 text-center"
                 style="height: 150px; position: absolute; background: #a5a5a5; border-radius: 10px; margin: auto; top: 0; left: 0; right: 0; bottom: 0; padding: 20px;">
                <h2>ملاحظة</h2>
                <p>** سوف يتم إيقاف التسجيل في الدورة إلى ان يتم إعادة تفعيلها **</p>
                <button class="btn btn-success" id="agree">موافق</button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right mb-0 rtl">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-success animated fadeInUp">
                    <ul class="text-right mb-0 rtl">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">تعليق الدورات وتفعيلها</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <form method="post"
                                  action="{{ route('admin.courses.activation.confirm') }}">
                                {{ csrf_field() }}
                                <thead>
                                <tr>
                                    @if(count($courseAdmin) > 0)
                                        <th class="text-center" colspan="6"><h4> في حال تم تعليق الدورة فان الطلاب لن
                                                يتمكنوا من التسجيل حتى يتم إعادة تفعيلها </h4></th>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-block" id="save">حفظ</button>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <th class="text-center">الدورة</th>
                                    <th class="text-center">تاريخ الدورة</th>
                                    <th class="text-center">التصنيف</th>
                                    <th class="text-center">المقاعد</th>
                                    <th class="text-center">الطلاب</th>
                                    <th class="text-center">الحضور</th>
                                    <th class="text-center">خيارات</th>
                                </tr>
                                </thead>
                                <tbody class="text-center">
                                @if(count($courseAdmin) > 0)
                                    @foreach($courseAdmin as $admin)
                                        <tr class="gradeX">
                                            <td class="pt-17">
                                                {{ $admin->course->title }}
                                            </td>
                                            <td class="pt-17 ltr">{{ date( 'Y-M-D h:i' ,strtotime($admin->course->created_at)) }}</td>
                                            <td class="pt-17">{{ $admin->course->category->name }}</td>
                                            <td class="pt-17">{{ $admin->course->attendance }}</td>
                                            <td class="pt-17">{{ count($admin->course->reservation) }}</td>
                                            <td class="pt-17">
                                                @if($admin->course->gender == 1)
                                                    رجال
                                                @elseif($admin->course->gender == 2)
                                                    نساء
                                                @else
                                                    رجال ونساء
                                                @endif
                                            </td>
                                            <td>
                                                @if($admin->course->activation == 1)
                                                    <input type="checkbox" data-toggle="toggle"
                                                           class="activation-toggle" checked>
                                                @else
                                                    <input type="checkbox" data-toggle="toggle"
                                                           class="activation-toggle">
                                                @endif
                                                <input type="hidden" name="activation[]" value="{{ $admin->course->activation }}" required>
                                                <input type="hidden" name="course[]"
                                                       value="{{ $admin->course->identifier }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="gradeX">
                                        <td class="text-danger" colspan="8">
                                            <h3 style="margin-top: 15px">لايوجد توجد دورات يمكن تعليقها</h3>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                                @if(count($courseAdmin) > 0)
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">الدورة</th>
                                        <th class="text-center">تاريخ الدورة</th>
                                        <th class="text-center">التصنيف</th>
                                        <th class="text-center">المقاعد</th>
                                        <th class="text-center">الطلاب</th>
                                        <th class="text-center">الحضور</th>
                                        <th class="text-center">خيارات</th>
                                        </th>
                                    </tr>
                                    </tfoot>
                                @endif
                            </form>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main content -->
@endsection

@section('script-file')
    <script src="{{ asset('js/admin/courses-activation-toggle.js') }}"></script>
    <script>
        $(document).ready(function () {

            $('.activation-toggle').on('change', function () {
                let value = $(this).prop('checked');
                if (value) {
                    $(this).parent().next().val(1);
                } else {
                    $(this).parent().next().val(0);
                }
            });

            $('#agree').on('click', function () {
                $('#note').fadeOut('slow', function () {
                    $(this).remove();
                });
            });
        });
    </script>
@endsection