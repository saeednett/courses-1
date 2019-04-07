@extends('administrator.layouts.master-statistics')

@section('title', 'رسائل التواصل')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/show-contact-us.css') }}">
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
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">رسائل التواصل</h3>
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
                                <th class="text-center">الإسم</th>
                                <th class="text-center">الموضوع</th>
                                <th class="text-center">البريد الإلكتروني</th>
                                <th class="text-center">رقم الهاتف</th>
                                <th class="text-center">التاريخ</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">الرسالة</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($contact_us) > 0)
                                @foreach($contact_us as $message)
                                    <tr class="gradeX">
                                        <td>{{ $message->name }}</td>
                                        <td>{{ $message->subject }}</td>
                                        <td>{{ $message->email }}</td>
                                        <td class="ltr">{{ $message->phone }}</td>
                                        <td>{{ $message->created_at }}</td>
                                        @if($message->registered == 1)
                                            <td class="text-success">مسجل</td>
                                        @else
                                            <td class="text-danger">زائر</td>
                                        @endif
                                        <td><a href="#" class="show-message" data-message="{{ $message->message }}" data-name="{{ $message->name }}" data-phone="{{ $message->phone }}" data-email="{{ $message->email }}">عرض</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="7">
                                        <h3 class="mt-15">لاتوجد رسائل تواصل مسجلة في النظام</h3>
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
    <script src="{{ asset('js/administrator/show-contact-us.js') }}"></script>
@endsection