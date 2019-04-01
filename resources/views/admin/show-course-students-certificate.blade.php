@extends('admin.layouts.master')

@section('content')
    <!-- Main content -->
    <style>
        .warning-color {
            color: #fff466;
        }

        .mb-0 {
            margin-bottom: 0 !important;
        }

        .pt-15 {
            padding-top: 15px !important;
        }

        .block {
            color: black;
            background: #FFF;
            border: 1px solid #ccc;
            font-weight: 400;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 3px;
            box-shadow: 2px 1px 5px rgba(0, 0, 0, 0.25);
        }
    </style>

    @if($errors->any())
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right rtl mb-0">
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
                    <ul class="text-right rtl mb-0">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif





    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="block animated fadeInUp">
                <ul class="custom-rules text-right">
                    <li>
                        <span class="fa fa-book text-custom"></span>
                        <span>الدورة:</span>
                        <span><mark>{{ $course->title }}</mark></span>
                    </li>

                    <li>
                        <span class="fa fa-calendar text-custom"></span>
                        <span>التاريخ:</span>
                        <span><mark>{{ date('Y-m-d') }}</mark></span>
                    </li>

                    <li>
                        <span class="fa fa-check-circle text-custom"></span>
                        <span>المقاعد:</span>
                        <span><mark>{{ $course->attendance }}</mark></span>
                    </li>

                    <li>
                        <span class="fa fa-clock-o text-custom"></span>
                        <span>المدة:</span>
                        <span><mark>{{ $days }}</mark></span>
                    </li>

                    <li>
                        <span class="fa fa-users text-custom"></span>
                        <span>الطلاب:</span>
                        <span><mark>{{ $students }}</mark></span>
                    </li>


                    <li>
                        <span class="fa fa-newspaper-o text-custom"></span>
                        <span>ملاحظة:</span>
                        <span><mark>لن يتم إظهار الطلاب الذين لم يتم تحضيرهم في جميع ايام الدورة</mark></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات الطلاب المسجلين في الدورة</h3>
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
                                <th class="text-center pt-15" colspan="5"><h4>{{ $course->title }}</h4></th>
                                <td class="text-center">
                                    <form method="post" class="mb-0"
                                          action="{{ route('admin.courses.certificate.confirm', $course->identifier) }}"
                                          id="form">
                                        {{ csrf_field() }}
                                        <button class="btn btn-success btn-block">إصدار الشهادة</button>
                                    </form>
                                </td>
                                <td class="text-center pt-15"><a class="select-all" href="#" data-type="true">تحديد
                                        الكل </a>
                                </td>
                            </tr>


                            <tr>
                                <th class="text-center">اسم الطالب</th>
                                <th class="text-center">رقم الهاتف</th>
                                <th class="text-center">البريد الإلكتروني</th>
                                <th class="text-center">تاريخ الميلاد</th>
                                <th class="text-center">المدينة</th>
                                <th class="text-center">الجنس</th>
                                <th class="text-center">الشهادة</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($reservations) > 0)
                                <?php $counter = 0; ?>
                                @foreach($reservations as $reservation)
                                    @if( count($reservation->attendance) ==  $days)
                                        <?php $counter++; ?>
                                        <tr class="gradeX">
                                            <td>
                                                {{ $reservation->student->first_name." ".$reservation->student->second_name." ".$reservation->student->third_name }}
                                                <input type="hidden" name="students[]"
                                                       value="{{ $reservation->student->id }}" form="form">
                                            </td>
                                            <td style="direction: ltr;">{{ $reservation->student->user->phone }}</td>
                                            <td style="direction: ltr;">{{ $reservation->student->user->email }}</td>
                                            <td>{{ $reservation->student->year.'-'.$reservation->student->month.'-'.$reservation->student->day }}</td>
                                            <td>{{ $reservation->student->city->name }}</td>
                                            <td>{{ $reservation->student->gender->name }}</td>
                                            <td><input type="checkbox" name="certificates[]" value="0" form="form"></td>
                                        </tr>

                                    @endif
                                @endforeach

                                @if($counter == 0)
                                    <tr class="gradeX">
                                        <td class="text-danger" colspan="7">
                                            <h3 style="margin-top: 15px">لم يتم إتمام تحضير جميع الطلاب لذلك لن يتم
                                                إصدار اي الشهادة</h3>
                                        </td>
                                    </tr>
                                @endif

                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="7">
                                        <h3 style="margin-top: 15px">لايوجد طلاب مسجلين في الدورة</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            @if(count($reservations) > 0)
                                <tfoot>
                                <tr>
                                    <th class="text-center">اسم الطالب</th>
                                    <th class="text-center">رقم الهاتف</th>
                                    <th class="text-center">البريد الإلكتروني</th>
                                    <th class="text-center">تاريخ الميلاد</th>
                                    <th class="text-center">المدينة</th>
                                    <th class="text-center">الجنس</th>
                                    <th class="text-center">حالة التسجيل</th>
                                </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main content -->
@endsection

@section('script-file')
    <script>
        $(".select-all").click(function (e) {
            e.preventDefault();

            let type = $(this).attr("data-type");

            if (type == "true") {

                $("input[name='certificates[]']").prop('checked', true);
                $(this).text("إلغاء التحديد");
                $(this).attr("data-type", "false");

            } else {

                $("input[name='certificates[]']").prop('checked', false);
                $(this).text("تحديد الكل");
                $(this).attr("data-type", "true");

            }

        });

        $("input[name='certificates[]']").on('change', function () {
            let type = $(this).prop('checked');
            if (type == true) {
                $(this).val(1);
            } else {
                $(this).val(0);
            }
        });
    </script>
@endsection