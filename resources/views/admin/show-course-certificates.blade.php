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
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات الطلاب الذين تم إصدار شهاتهم في الدورة</h3>
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
                                <th class="text-center pt-15" colspan="8"><h4>{{ $course->title }}</h4></th>
                            </tr>


                            <tr>
                                <th class="text-center">اسم الطالب</th>
                                <th class="text-center">رقم الهاتف</th>
                                <th class="text-center">البريد الإلكتروني</th>
                                <th class="text-center">المدينة</th>
                                <th class="text-center">الجنس</th>
                                <th class="text-center">التاريخ</th>
                                <th class="text-center">مصدر الشهادة</th>
                                <th class="text-center">أيام الحضور</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($certificates) > 0)
                                @foreach($certificates as $certificate)

                                    <?php $counter = 0; ?>
                                    @if($certificate->admin == \Illuminate\Support\Facades\Auth::user()->admin->id)
                                        <tr class="gradeX">
                                            <td>
                                                {{ $certificate->student->first_name." ".$certificate->student->second_name." ".$certificate->student->third_name }}
                                            </td>
                                            <td style="direction: ltr;">{{ $certificate->student->user->phone }}</td>
                                            <td style="direction: ltr;">{{ $certificate->student->user->email }}</td>
                                            <td>{{ $certificate->student->city->name }}</td>
                                            <td>{{ $certificate->student->gender->name }}</td>
                                            <td>{{ $certificate->date }}</td>
                                            <td>{{ $certificate->admin->name }}</td>
                                            @if($days == count($certificate->reservation->attendance))
                                                <td class="bg-success text-success">{{ count($certificate->reservation->attendance) }}</td>
                                            @else
                                                <td class="bg-danger text-danger">{{ count($certificate->reservation->attendance) }}</td>
                                            @endif
                                        </tr>
                                        <?php $counter++; ?>
                                    @endif

                                @endforeach

                                @if($counter == 0)
                                    <tr class="gradeX">
                                        <td class="text-danger" colspan="8">
                                            <h3 class="mt-15">لم يتم إصدار اي شهادة لهذه الدورة بإستخدام هذا الحساب</h3>
                                        </td>
                                    </tr>
                                @endif

                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="8">
                                        <h3 class="mt-15">لم يتم إصدار اي شهادة لهذه الدورة</h3>
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