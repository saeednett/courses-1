@extends('center.layouts.master-v-1-1')

@section('content')
    <!-- Main content -->
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
                        <?php $counter = 0; ?>
                        @foreach($course->reservation as $reservation)
                            @if($reservation->confirmation == 1)
                                <?php $counter++; ?>
                            @endif
                        @endforeach
                        <span><mark>{{ $counter }}</mark></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">الشهادات المصدرة</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="search" href="#"><i class="icon-search"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>

                <div class="panel-body mt-15">
                    <div class="table-responsive">
                        <table class="table DataTable table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">اسم الطالب</th>
                                <th class="text-center">رقم الهاتف</th>
                                <th class="text-center">البريد الإلكتروني</th>
                                <th class="text-center">المدينة</th>
                                <th class="text-center">الجنس</th>
                                <th class="text-center">تاريخ الإصدار</th>
                                <th class="text-center">مصدر الشهادة</th>
                                <th class="text-center">أيام الحضور</th>
                                <th class="text-center select-all pointer">تحديد الكل</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($certificates) > 0)
                                @foreach($certificates as $certificate)
                                    <tr class="gradeX">
                                        <td class="student-name">
                                            {{ $certificate->student->first_name." ".$certificate->student->second_name." ".$certificate->student->third_name }}
                                            <input type="hidden" name="reservation[]" value="{{ $certificate->reservation->identifier }}">
                                        </td>
                                        <td class="student-phone ltr">{{ $certificate->student->user->phone }}</td>
                                        <td class="student-email ltr">{{ $certificate->student->user->email }}</td>
                                        <td class="student-city">{{ $certificate->student->city->name }}</td>
                                        <td class="student-gender">{{ $certificate->student->gender->name }}</td>
                                        <td class="issue-date">{{ $certificate->date  }}</td>
                                        <td class="admin-name">{{ $certificate->admin->name  }}</td>

                                        @if($days == count($certificate->reservation->attendance))
                                            <td class="student-attendance bg-success text-success">{{ count($certificate->reservation->attendance) }}</td>
                                            <input type="hidden" name="days" value="{{ $days }}">
                                        @else
                                            <td class="student-attendance bg-danger text-danger p-17">{{ count($certificate->reservation->attendance) }}</td>
                                            <input type="hidden" name="days" value="{{ $days }}">
                                        @endif

                                        <td class="download-state">
                                            <input type="checkbox" class="download-state" name="certificate[]" value="0">
                                        </td>
                                    </tr>

                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="9">
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
    <script src="{{ asset('js/center/show-certificates.js') }}"></script>
@endsection