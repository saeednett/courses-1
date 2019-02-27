@extends('center.master-v-1-1')

@section('title', 'المعلومات البنكية')

@section('script-file')
    <script>
        $(document).ready(function () {

            let counter = 2;
            $(document).on('click', '.add-account', function () {
                $('#accounts').append("<div class='row form-group' id='new-row'> <div class='col-lg-5'> <label class='col-form-label required-field' for='account_owner_" + counter + "' >اسم صاحب الحساب</label> <input type='account_owner' id='account_owner_" + counter + "' class='form-control custom-input' name='account_owner[]' placeholder='اسم صاحب الحساب' autocomplete='off' required> </div> </div>");
                $('#new-row').append("<div class='col-lg-3'> <label class='col-form-label required-field' for='account_number_" + counter + "' >رقم الحساب</label> <input type='text' id='account_number_" + counter + "' class='form-control custom-input' name='account_number[]' placeholder='رقم الحساب' autocomplete='off' required> </div>");
                $('#new-row').append("<div class='col-lg-3'> <label class='col-form-label required-field' for='bank_" + counter + "'>البنك</label>  <select id='new-account' class='form-control custom-input' name='bank[]' required>  </select>  </div>");


                for (let i = 0; i < $('#main-bank').children().length; i++) {
                    let text = $('#main-bank').children().eq(i).text();
                    let value = $('#main-bank').children().eq(i).attr('value');
                    $('#new-account').append("<option value='" + value + "'>" + text + "</option>");
                }
                $('#new-row').append("<div class='col-lg-1 text-center'> <label class='col-form-label opacity-0' for='bank'>المزيد</label> <span class='btn-danger text-center fa fa-remove remove-account'></span> </div>");
                counter++;
                $("#new-row").removeAttr('id');
                $('#new-account').removeAttr("id");
            });

            $(document).on('click', '.remove-account', function () {
                $(this).parent().parent().remove();
            });
        });
    </script>
@endsection

@section('style-file')

@endsection

@section('content')
    <style>

        select {
            direction: rtl;
            width: 100%;
            text-align: center !important;
            text-align-last: center !important;
        }

        .custom-input {
            height: 50px;
            font-size: 16px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid rgba(34, 36, 38, .15);
        }

        .custom-input:hover {
            border: 2px solid #1bc3a1;
        }

        .custom-input:focus {
            box-shadow: none !important;
            border: 2px solid #1bc3a1;
        }

        .required-field:after {
            color: #ff6771;
            content: " *";
            text-align: right;
        }

        .custom-btn {
            height: 60px;
            border-radius: 30px;
            background-image: linear-gradient(to right, #1bc3a1 0%, #6fcf8f);
            display: block;
            border: none;
            font-size: 18px;
            color: #fff;
        }

        .custom-btn:hover {
            box-shadow: 0 4px 10px 0 rgba(11, 121, 99, 0.31);
        }

        .invalid-feedback {
            color: #ab1717;
            width: 100% !important;
            display: block !important;
            direction: rtl !important;
            text-align: center !important;
        }

        .add-account {
            padding-top: 13px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-top: 8px;
            cursor: pointer;
        }

        .remove-account {
            padding-top: 13px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-top: 8px;
            cursor: pointer;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .opacity-0 {
            opacity: 0;
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
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">تعديل المعلومات البنكية</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-plus"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="container-fluid">
                            <form method="post" action="{{ route('center.bank.account.update') }}" id="form">
                                {{ csrf_field() }}
                                <?php $counter = 1; ?>
                                @foreach($accounts as $account)
                                    @if($counter == 1)
                                        <div class="row form-group">
                                            <div class="col-lg-5">
                                                <label class="col-form-label required-field" for="account_owner">اسم
                                                    صاحب
                                                    الحساب</label>
                                                <input type="account_owner" id="account_owner"
                                                       class="form-control custom-input"
                                                       name="account_owner[]" value="{{ $account->account_owner }}"
                                                       placeholder="اسم صاحب الحساب" autocomplete="off" required>
                                            </div>

                                            <div class="col-lg-3">
                                                <label class="col-form-label required-field" for="account_number">رقم
                                                    الحساب</label>
                                                <input type="text" id="account_number" class="form-control custom-input"
                                                       name="account_number[]" value="{{ $account->account_number }}"
                                                       placeholder="رقم الحساب" autocomplete="off" required>
                                            </div>

                                            <div class="col-lg-3">
                                                <label class="col-form-label required-field"
                                                       for="main-bank">البنك</label>
                                                <select id="main-bank"
                                                        class="form-control {{ $errors->has('bank') ? 'is-invalid' : '' }} custom-input"
                                                        name="bank[]" required>
                                                    @foreach($banks as $bank)
                                                        @if($bank->id == $account->bank_id)
                                                            <option value="{{ $bank->id }}"
                                                                    selected>{{ $bank->name }}</option>
                                                        @else
                                                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-xl-1 col-lg-1 col-md-12 col-sm-12 col-xs-4 col-lg-offset-0 col-xs-offset-4 text-center">
                                                <label class="col-form-label opacity-0" for="bank">المزيد</label>
                                                <span class="btn-success text-center fa fa-plus add-account"></span>
                                            </div>
                                            <?php $counter++; ?>
                                        </div>
                                    @else
                                        <div class="row form-group">

                                            <div class="col-lg-5">
                                                <label class="col-form-label required-field" for="account_owner">اسم
                                                    صاحب
                                                    الحساب</label>
                                                <input type="account_owner" id="account_owner"
                                                       class="form-control custom-input"
                                                       name="account_owner[]" value="{{ $account->account_owner }}"
                                                       placeholder="اسم صاحب الحساب" autocomplete="off" required>
                                            </div>

                                            <div class="col-lg-3">
                                                <label class="col-form-label required-field" for="account_number">رقم
                                                    الحساب</label>
                                                <input type="text" id="account_number" class="form-control custom-input"
                                                       name="account_number[]" value="{{ $account->account_number }}"
                                                       placeholder="رقم الحساب" autocomplete="off" required>
                                            </div>

                                            <div class="col-lg-3">
                                                <label class="col-form-label required-field"
                                                       for="main-bank">البنك</label>
                                                <select id="main-bank"
                                                        class="form-control {{ $errors->has('bank') ? 'is-invalid' : '' }} custom-input"
                                                        name="bank[]" required>
                                                    @foreach($banks as $bank)
                                                        @if($bank->id == $account->bank_id)
                                                            <option value="{{ $bank->id }}"
                                                                    selected>{{ $bank->name }}</option>
                                                        @else
                                                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-lg-1 text-center">
                                                <label class="col-form-label opacity-0" for="bank">المزيد</label>
                                                <span class="btn-danger text-center fa fa-trash remove-account"></span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div id="accounts">

                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-4 col-lg-offset-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-block custom-btn">حفظ</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection