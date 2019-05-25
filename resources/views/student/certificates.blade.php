@extends('student.layouts.master-v-1-1')

@section('title', 'شهاداتي')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/student/certificates.css') }}">
@endsection

@section('script-file')
    <script src="{{ asset('js/student/certificates.js') }}"></script>
@endsection

@section('content')
    <div class="wrap">
        <div class="container">
            <div class="row justify-content-center mt-3">
                <div class="col-lg-10 col-md-12 col-sm-12 col-12">
                    <div class="row justify-content-end">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                            <div class="row justify-content-center mt-4">
                                <div class="col-lg-12 col-md-12 col-sm-10 col-10">
                                    <h1 class="text-lg-right text-md-right text-center d-lg-block d-md-block d-none">
                                        شهاداتي</h1>
                                    <h3 class="text-right d-lg-none d-md-none d-block">شهاداتي</h3>
                                </div>
                            </div>
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

                            <div class="row">
                                <div class="col-4 offset-4">
                                    <div class=""
                                         >
                                        <input type="text" class="form-control text-center mt-2" name="key"
                                               placeholder="البحث بإسم الدورة">
                                        <p class="text-center text-danger mb-0 mt-2" id="serch_error"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-lg-end justify-content-md-end justify-content-sm-center justify-content-center mb-4 mt-4"
                                 id="viewHolder">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">عرض</th>
                                                {{--<th class="text-center">المسؤول</th>--}}
                                                <th class="text-center">التاريخ</th>
                                                <th class="text-center">الجهة</th>
                                                <th class="text-center">الدورة</th>


                                            </tr>
                                            </thead>

                                            <tbody id="tbody">
                                            @foreach($all_certificates as $certificate)
                                                <tr>
                                                    @if($certificate->viewed == 0)
                                                        <td class="text-center"><a class="text-success certificate-link"
                                                                                   data-state="0"
                                                                                   href="{{ route('account.certificate.show', $certificate->course->identifier) }}"><span
                                                                        class="rounded-circle count-certificates w-35 h-35 pt-10">عرض</span></a>
                                                        </td>
                                                        {{--<td class="text-center pt-4">{{ $certificate->admin->name }}</td>--}}
                                                        <td class="text-center certificate-date pt-4">{{ $certificate->date }}</td>
                                                        <td class="text-center center-name pt-4">{{ $certificate->course->center->name }}</td>
                                                        <td class="text-center course-name pt-4">{{ $certificate->course->title }}</td>
                                                    @else
                                                        <td class="text-center"><a data-state="1"
                                                                                   href="{{ route('account.certificate.show', $certificate->course->identifier) }}">عرض</a>
                                                        </td>
                                                        <td class="text-center">{{ $certificate->date }}</td>
                                                        <td class="text-center">{{ $certificate->course->center->name }}</td>
                                                        <td class="text-center course-name">{{ $certificate->course->title }}</td>
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
    </div>
@endsection