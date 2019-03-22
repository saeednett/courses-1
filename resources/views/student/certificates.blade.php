@extends('student.master-v-1-1')

@section('title', 'شهاداتي')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/student/tickets.css') }}"/>
@endsection

@section('script-file')
    <script src="{{ asset('js/student/tickets.js') }}"></script>
@endsection

@section('content')
    <div class="wrap">
        <div class="container">
            <div class="row justify-content-center mt-3">
                <div class="col-lg-10 col-md-12 col-sm-12 col-12">
                    <div class="row justify-content-end">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12 col-sm-10 col-10">
                                    <h1 class="text-lg-right text-md-right text-center d-lg-block d-md-block d-none">
                                        شهاداتي</h1>
                                    <h3 class="text-right d-lg-none d-md-none d-block">شهاداتي</h3>
                                </div>
                            </div>

                            {{--<div class="row justify-content-end">--}}
                            {{--<div class="col-12 text-right d-lg-block d-md-block d-none rtl">--}}
                            {{--<input type="hidden" name="token" value="{{ csrf_token() }}">--}}
                            {{--<button class="btn filter-tabs custom-active" data-filter="all">الجميع</button>--}}
                            {{--<button class="btn filter-tabs" data-filter="finished">المنتهية</button>--}}
                            {{--<button class="btn filter-tabs" data-filter="confirmed">المؤكدة</button>--}}
                            {{--<button class="btn filter-tabs" data-filter="unconfirmed">المعلقة</button>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="row justify-content-center mt-2">--}}
                            {{--<div class="col-10 text-center d-lg-none d-md-none d-sm-block d-block">--}}
                            {{--<select class="custom-select" name="filter-type"--}}
                            {{--onchange="alert($('select[name=filter-type]').val())">--}}
                            {{--<optgroup label="تصنيف العرض">--}}
                            {{--<option value="1" selected>الجميع</option>--}}
                            {{--<option value="2">المنتهية</option>--}}
                            {{--<option value="3">المؤكدة</option>--}}
                            {{--<option value="4">المعلقة</option>--}}
                            {{--</optgroup>--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            {{--</div>--}}

                            @if(session()->has('success'))
                                <div class="row mt-4">
                                    <div class="col-lg-12 col-md-12 col-10">
                                        <div class="alert alert-success">
                                            <ul class="text-right mb-0 rtl">
                                                <li>{{ session('success') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="row mt-4">
                                    <div class="col-lg-12 col-md-12 col-10">
                                        <div class="alert alert-danger">
                                            <ul class="text-right mb-0 rtl">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="row justify-content-lg-end justify-content-md-end justify-content-sm-center justify-content-center mb-4"
                                 id="viewHolder">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th class="text-center">عرض</th>
                                            <th class="text-center">المسؤول</th>
                                            <th class="text-center">التاريخ</th>
                                            <th class="text-center">الجهة</th>
                                            <th class="text-center">الدورة</th>


                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($all_certificates as $certificate)
                                            <tr>

                                                @if($certificate->viewed == 0)
                                                    <td class="text-center"><a class="text-success" href="{{ route('account.certificate.show', $certificate->course->identifier) }}"><span class="rounded-circle count-certificates" style="height: 35px; width: 35px; padding-top: 10px;">عرض</span></a></td>
                                                    <td class="text-center pt-4">{{ $certificate->admin }}</td>
                                                    <td class="text-center pt-4">{{ $certificate->date }}</td>
                                                    <td class="text-center pt-4">{{ $certificate->course->center->name }}</td>
                                                    <td class="text-center pt-4">{{ $certificate->course->title }}</td>
                                                @else
                                                    <td class="text-center"><a href="{{ route('account.certificate.show', $certificate->course->identifier) }}">عرض</a></td>
                                                    <td class="text-center">{{ $certificate->admin }}</td>
                                                    <td class="text-center">{{ $certificate->date }}</td>
                                                    <td class="text-center">{{ $certificate->course->center->name }}</td>
                                                    <td class="text-center">{{ $certificate->course->title }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection