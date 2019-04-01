@extends('center.master-v-1-1')

@section('title', "عرض حسابات منصة هللة")
@section('main-title', "عرض حسابات منصة هللة")

@section('page-links')
    <li><a href="{{ route('center.index', Auth::user()->username) }}"><i class="fa fa-users"></i>الملف الشخصي</a></li>
    <li class="active"><a href="{{ route('center.halalah.account.show') }}"><i class="fa fa-user"></i>بيانات منصة
            هللة</a>
    </li>
@endsection

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/center/show-halalah-account.css') }}"/>
@endsection

@section('script-file')
    <script src="{{ asset('js/center/show-halalah-account.js') }}"></script>
@endsection

@section('content')

    <div class="body-cover">
        <div class="barcode-holder">
            <img src="" id="barcode-image" alt="Barcode Image">
        </div>
    </div>
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
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات حساب منصة هللة</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                        <li><a href="{{ route('center.halalah.account.create') }}"><i class="icon-plus"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">الموقع</th>
                                <th class="text-center">اسم المستخدم</th>
                                <th class="text-center">صورة الباركود</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($halalah) > 0)

                                <tr class="gradeX">
                                    <td>منصة هللة</td>
                                    <td>{{ $halalah->name }}</td>
                                    <td>  <a class="show-barcode" href="" data-link="/storage/halalah-images/{{$halalah->image}}">عرض</a> </td>
                                    @if($halalah->status == 1)

                                        <td class="bg-success text-success">فعال</td>

                                    @else

                                        <td class="bg-danger text-danger">غير فعال</td>

                                    @endif


                                    <td class="size-80 text-center">
                                        <div class="dropdown">
                                            <a class="more-link" data-toggle="dropdown" href="#/"><i
                                                        class="icon-dot-3 ellipsis-icon"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li>
                                                    <a href="{{ route('center.halalah.account.delete') }}">
                                                        <span>حذف</span>
                                                        <i class="icon-trash pull-right text-danger"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('center.halalah.account.edit') }}">
                                                        <span>تعديل</span>
                                                        <i class="fa fa-pencil-square pull-right text-success"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5"><h3>لا يوجد حساب منصة هللة مسجل في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            @if(count($halalah) < 0)
                                <tfoot>
                                <tr>
                                    <th class="text-center">الموقع</th>
                                    <th class="text-center">اسم المستخدم</th>
                                    <th class="text-center">صورة الباركود</th>
                                    <th class="text-center">الحالة</th>
                                    <th class="text-center">خيارات</th>
                                </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection