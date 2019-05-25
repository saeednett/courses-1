@extends('center.layouts.master-v-1-1')

@section('title', 'إصدار شهادة دورة')

@section('content')

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
                        @foreach($reservations as $reservation)
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
        <div class="modal fade" id="warning-model" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header text-right">
                        <h4 class="modal-title text-danger close" data-dismiss="modal" style="float: right;">تنبيه!</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p class="text-danger">هل انت متأكد من إصدار الشهادات للطلاب</p>
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
                    <h3 class="panel-title">إصدار شهادات دورة</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="search" href="#"><i class="icon-search"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table DataTable table-striped table-bordered table-hover">
                            <form method="post"
                                  action="{{ route('center.courses.certificate.generate.confirm', $course->identifier) }}" id="generation-form">
                                {{ csrf_field() }}
                                <thead>
                                <tr>
                                    <th class="text-center">اسم الطالب</th>
                                    <th class="text-center">رقم الهاتف</th>
                                    <th class="text-center">البريد الإلكتروني</th>
                                    <th class="text-center">المدينة</th>
                                    <th class="text-center">الجنس</th>
                                    <th class="text-center">أيام الحضور</th>
                                    <th class="text-center select-all pointer">تحديد الكل</th>
                                </tr>
                                </thead>
                                <tbody class="text-center">
                                @if(count($reservations) > 0)
                                    @foreach($reservations as $reservation)
                                        <tr class="gradeX">
                                            <td class="pt-17">
                                                {{ $reservation->student->first_name." ".$reservation->student->second_name." ".$reservation->student->third_name }}
                                                <input type="hidden" name="student[]" value="{{ $reservation->student->id }}" form="generation-form">
                                            </td>
                                            <td class="pt-17 ltr">{{ $reservation->student->user->phone }}</td>
                                            <td class="pt-17 ltr">{{ $reservation->student->user->email }}</td>
                                            <td class="pt-17">{{ $reservation->student->city->name }}</td>
                                            <td class="pt-17">{{ $reservation->student->gender->name }}</td>

                                            @if($days == count($reservation->attendance))
                                                <td class="pt-17 bg-success text-success">{{ count($reservation->attendance) }}</td>
                                                <input type="hidden" name="days" value="{{ $days }}">
                                            @else
                                                <td class="pt-17 bg-danger text-danger">{{ count($reservation->attendance) }}</td>
                                                <input type="hidden" name="days" value="{{ $days }}">
                                            @endif

                                            @if(is_null($reservation->certificate))
                                                <td>
                                                    <input type="checkbox" data-toggle="toggle"
                                                           class="toggle-input">
                                                    <input type="hidden" name="generation[]" value="0" form="generation-form">
                                                </td>
                                            @else
                                                <td>
                                                    <input type="checkbox" data-toggle="toggle"
                                                           class="toggle-input" checked>
                                                    <input type="hidden" name="generation[]" value="1" form="generation-form">

                                                </td>
                                            @endif
                                        </tr>

                                    @endforeach
                                @else
                                    <tr class="gradeX">
                                        <td class="text-danger" colspan="8">
                                            <h3 class="mt-15">لايوجد طلاب مسجلين لهذه الدورة</h3>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
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
    <script src="{{ asset('js/main/toggle-button.js') }}"></script>
    <script src="{{ asset('js/center/generate-certificate.js') }}"></script>
@endsection