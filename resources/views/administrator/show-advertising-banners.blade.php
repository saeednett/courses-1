@extends('administrator.layouts.master-statistics')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/index.css') }}">
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
                        <p class="text-danger">سوف يتم حذف الإعلان من الصفحة الرئيسية</p>
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
                    <h3 class="panel-title">الإعلانات في الصفحة الرئيسية</h3>
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
                                <th class="text-center">العنوان</th>
                                <th class="text-center">الوصف</th>
                                <th class="text-center">رابط التوجيه</th>
                                <th class="text-center">البانر</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center" colspan="2">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($banners) > 0)
                                @foreach($banners as $banner)
                                    <tr class="gradeX">
                                        <td>{{ $banner->title }}</td>
                                        <td>{{ $banner->description }}</td>
                                        <td><a href="{{ $banner->link }}" target="_blank">{{ $banner->link }}</a></td>
                                        <td><a href="#" class="show-banner" data-banner-link="/storage/banner-images/{{ $banner->banner }}">عرض</a></td>

                                        @if($banner->status == 1)
                                            <td class="text-success">مفعل</td>
                                        @else
                                            <td class="text-danger">غير مفعل</td>
                                        @endif

                                        <td><a href="{{ route('administrator.advertising.banner.edit', $banner->id) }}">تعديل</a></td>
                                        <td><a href="{{ route('administrator.advertising.banner.delete', $banner->id) }}" class="text-danger delete-banner">حذف</a> </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5">
                                        <h3 class="mt-15">لاتوجد إعلانات مسجلة في النظام</h3>
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
    <script src="{{ asset('js/administrator/show-banners.js') }}"></script>
@endsection