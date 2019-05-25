@extends('center.layouts.master-v-1-1')

@section('title', "عرض الحسابات البنكية")
@section('main-title', "عرض الحسابات البنكية")

@section('page-links')
    <li><a href="{{ route('center.index', Auth::user()->username) }}"><i class="fa fa-users"></i>الملف الشخصي</a></li>
    <li class="active"><a href="{{ route('center.bank.account.show') }}"><i class="fa fa-user"></i>بياناتي البنكية</a>
    </li>
@endsection


@section('content')

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
                    <h3 class="panel-title">البيانات البنكية المسجلة</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                        <li><a href="{{ route('center.bank.account.create') }}"><i class="icon-plus"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">اسم البنك</th>
                                <th class="text-center">اسم الحساب</th>
                                <th class="text-center">رقم الحساب</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($accounts) > 0)
                                @foreach($accounts as $account)
                                    <tr class="gradeX">
                                        <td>{{ $account->bank->name }}</td>
                                        <td class="ltr">{{ $account->account_owner }}</td>
                                        <td>{{ $account->account_number }}</td>
                                        <td class="size-80 text-center">
                                            <div class="dropdown">
                                                <a class="more-link" data-toggle="dropdown" href="#/"><i
                                                            class="icon-dot-3 ellipsis-icon"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li>
                                                        <a href="{{ route('center.bank.account.delete', $account->id) }}">
                                                            <span>حذف</span>
                                                            <i class="icon-trash pull-right text-danger"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('center.bank.account.edit', $account->id) }}">
                                                            <span>تعديل</span>
                                                            <i class="fa fa-pencil-square pull-right text-success"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5"><h3>لا يوجد حسابات بنكية مسجلة في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            @if(count($accounts) < 0)
                                <tfoot>
                                <tr>
                                    <th class="text-center">اسم البنك</th>
                                    <th class="text-center">اسم الحساب</th>
                                    <th class="text-center">رقم الحساب</th>
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