@extends('student.master-v-1-1')

@section('title', 'تعديل مستخدم')

@section('content')
    <div class="wrap">
        <div class="container">
            <div class="row justify-content-center mt-3">

                <div class="col-lg-4 col-md-4 col-sm-12 col-12 order-lg-first order-md-first order-sm-last order-last mt-lg-5 mt-md-5 mt-0 mb-4 align-self-start sticky-top">
                    <div class="block rounded text-right">
                        <p class="rtl">فريق خدمة العملاء جاهز دائماً للمساعدة.</p>
                        <p class="rtl"> اتصل بنا: <b>0592970476</b></p>
                        <p class="rtl"> او راسلنا: <b>soao_d@hotmail.com</b></p>
                    </div>

                    <div class="block rounded text-right">
                        <p>تابعنا في الشبكات الاجتماعية</p>
                        <div class="profile-social-media-accounts">
                            <ul class="nav profile-social-media p-0 rtl">
                                <li>
                                    <a class="social social-twitter" href=href="http://twitter.com/breakoutksa"
                                       style="background-image: url('https://lammt.com/resource/img/icon_tw.png'); background-size: 100%;"></a>
                                </li>
                                <li>
                                    <a class="social social-twitter" href=href="http://twitter.com/breakoutksa"
                                       style="background-image: url('https://lammt.com/resource/img/icon_fb.png'); background-size: 100%;"></a>
                                </li>
                                <li>
                                    <a class="social social-twitter" href=href="http://twitter.com/breakoutksa"
                                       style="background-image: url('https://lammt.com/resource/img/icon_snap.png'); background-size: 100%;"></a>
                                </li>
                                <li>
                                    <a class="social social-twitter" href=href="http://twitter.com/breakoutksa"
                                       style="background-image: url('https://lammt.com/resource/img/icon_instagram.png'); background-size: 100%;"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-8 col-sm-12 col-12">
                    <h1 class="text-lg-right text-md-right text-center d-lg-block d-md-block d-none">إدارة الملف
                        الشخصي</h1>
                    <h3 class="text-lg-right text-md-right mt-md-4 mt-4 text-center d-lg-none d-md-none d-block">إدارة
                        الملف الشخصي</h3>
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            <ul class="text-right mb-0 rtl">
                                <li>{{ session('success') }}</li>
                            </ul>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="text-right mb-0 rtl">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="block rounded mb-lg-5 mb-md-5 mb-0">
                        <form method="post" action="{{ route('account.update') }}" enctype="multipart/form-data"
                              class="mb-0">
                            <input type="hidden" name="_method" value="PUT">
                            {{ csrf_field() }}

                            <div class="well text-lg-right text-center rtl">
                                هنا معلوماتك الشخصية يمكنك تحديثها في أي وقت.
                            </div>

                            <div class="row">
                                <div class="col-lg-12 text-lg-left order-first order-lg-first text-center">
                                    @if($user->student->image == 'account-profile.png')
                                        <img src="{{ asset('img/student/'.$user->student->image) }}" class="img-thumbnail"
                                             style="height: 30%; width: 100%;">
                                    @else
                                        <img src="/storage/account-images/{{ $user->student->image }}"
                                             class="img-thumbnail" style="height: 30%; width: 100%;">
                                    @endif
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group text-center p-0 mt-2">
                                        <label for="account-profile">الصورة شخصية</label>
                                        <input type="file" class="form-control-file mt-2" name="profile-image"
                                               id="account-profile"
                                               style="margin: auto; width: 200px;"
                                               accept="image/png, image/jpg, image/jpeg">
                                    </div>

                                    <label class="text-center rtl mt-2">(الحد الأعلى للصورة الشخصية 500 ك.ب. بالامتدادات
                                        التالية: . JPG, PNG.)</label>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="form-group row mt-4">
                                    <div class="col-lg-8">
                                        <input type="text"
                                               class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }} text-center form-control-sm"
                                               name="name"
                                               value="{{ $user->name }}" required autocomplete="off">
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 text-right rtl order-lg-last order-md-last order-sm-first order-first">
                                        <label class="col-form-label required-field">الاسم الكامل</label>
                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-lg-8">
                                        <input type="text"
                                               class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }} text-center form-control-sm"
                                               name="username" value="{{ $user->username }}" required
                                               autocomplete="off">
                                        @if ($errors->has('username'))
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 text-right rtl order-lg-last order-md-last order-sm-first order-first">
                                        <label class="col-form-label required-field">اسم المستخدم</label>
                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-lg-8">
                                        <input type="text"
                                               class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }} text-center form-control-sm"
                                               name="phone"
                                               value="{{ $user->phone }}" maxlength="13" minlength="9" required
                                               autocomplete="off">
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 text-right rtl order-lg-last order-md-last order-sm-first order-first">
                                        <label class="col-form-label required-field">رقم الهاتف</label>
                                    </div>
                                </div>


                                <div class="form-group row mt-4">
                                    <div class="col-lg-8">
                                        <input type="text"
                                               class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }} text-center form-control-sm"
                                               name="email" value="{{ $user->email }}" required autocomplete="off">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 text-right rtl order-lg-last order-md-last order-sm-first order-first">
                                        <label class="col-form-label required-field">البريد الإلمتروني</label>
                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-lg-8">
                                        <select class="form-control {{ $errors->has('country') ? ' is-invalid' : '' }} form-control-sm"
                                                name="country">
                                            <?php $counter = 1; ?>
                                            @foreach($countries as $country)
                                                @if($country->id == $user->student->city->country->id)
                                                    <option value="{{ $country->id }}"
                                                            selected>{{ $country->name }}</option>
                                                @else
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('country'))
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('country') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 text-right rtl order-lg-last order-md-last order-sm-first order-first">
                                        <label class="col-form-label required-field">الدولة</label>
                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-lg-8">
                                        <select class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }} form-control-sm"
                                                name="city">
                                            @foreach($cities as $city)
                                                @if($user->student->city_id == $city->id)
                                                    <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                                                @else
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('city'))
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 text-right rtl order-lg-last order-md-last order-sm-first order-first">
                                        <label class="col-form-label required-field">المدينة</label>
                                    </div>
                                </div>

                                <div class="form-group row mt-4">

                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                                <select class="form-control {{ $errors->has('year') ? ' is-invalid' : '' }} form-control-sm"
                                                        name="year">
                                                    <?php $counter = 1; ?>
                                                    @if(old('year'))
                                                        @for($i = 0; $i <= 49; $i++)
                                                            @if($counter == 1)
                                                                @if(old('year') == date('Y'))
                                                                    <option value="{{ old('year') }}"
                                                                            selected>{{ old('year') }}</option>
                                                                @else
                                                                    <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                                                @endif
                                                                <?php $counter++; ?>
                                                            @else
                                                                @if(old('year') == date('Y', strtotime('-'.$i.' year')))
                                                                    <option value="{{ old('year') }}"
                                                                            selected>{{ old('year') }}</option>
                                                                @else
                                                                    <option value="{{ date('Y', strtotime('-'.$i.' year')) }}">{{ date('Y', strtotime('-'.$i.' year')) }}</option>
                                                                @endif
                                                            @endif
                                                        @endfor
                                                    @else
                                                        @if($user->student->year != 0)

                                                            @for($i = 0; $i <= 49; $i++)
                                                                @if($counter == 1)
                                                                    @if($user->student->year == date('Y'))
                                                                        <option value="{{ $user->student->year }}"
                                                                                selected>{{ $user->student->year }}</option>
                                                                    @else
                                                                        <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                                                    @endif
                                                                    <?php $counter++; ?>
                                                                @else
                                                                    @if($user->student->year == date('Y', strtotime('-'.$i.' year')))
                                                                        <option value="{{ $user->student->year }}"
                                                                                selected>{{ $user->student->year }}</option>
                                                                    @else
                                                                        <option value="{{ date('Y', strtotime('-'.$i.' year')) }}">{{ date('Y', strtotime('-'.$i.' year')) }}</option>
                                                                    @endif
                                                                @endif
                                                            @endfor

                                                        @else
                                                            <option value="0">- السنة -</option>
                                                            @for($i = 0; $i <= 49; $i++)
                                                                @if($counter == 1)
                                                                    <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                                                                    <?php $counter++; ?>
                                                                @else
                                                                    <option value="{{ date('Y', strtotime('-'.$i.' year')) }}">{{ date('Y', strtotime('-'.$i.' year')) }}</option>
                                                                @endif
                                                            @endfor
                                                        @endif
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                                <select class="form-control {{ $errors->has('day') ? ' is-invalid' : '' }} form-control-sm"
                                                        name="month">
                                                    @if(old('month'))
                                                        @for($i = 1; $i <= 12; $i++)
                                                            @if(old('month') == $i)
                                                                <option value="{{ old('month') }}"
                                                                        selected>{{ old('month') }}</option>
                                                            @else
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endif
                                                        @endfor
                                                    @else
                                                        @if($user->student->month != 0)
                                                            @for($i = 1; $i <= 12; $i++)
                                                                @if($user->student->month == $i)
                                                                    <option value="{{ $user->student->month  }}" selected>{{ $user->student->month }}</option>
                                                                @else
                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                @endif
                                                            @endfor
                                                        @else
                                                            <option value="0" selected>- الشهر -</option>
                                                            @for($i = 1; $i <= 12; $i++)
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        @endif
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                                <select class="form-control {{ $errors->has('day') ? ' is-invalid' : '' }} form-control-sm"
                                                        name="day">
                                                    @if(old('day'))
                                                        @for($i = 1; $i <= 31; $i++)
                                                            @if(old('day') == $i)
                                                                <option value="{{ $i }}" selected>{{ $i }}</option>
                                                            @else
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endif
                                                        @endfor
                                                    @else
                                                        @if($user->student->day != 0)
                                                            @for($i = 1; $i <= 31; $i++)
                                                                @if($user->student->day == $i)
                                                                    <option value="{{ $user->student->day }}" selected>{{ $user->student->day }}</option>
                                                                @else
                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                @endif
                                                            @endfor
                                                        @else
                                                            <option value="0" selected>- اليوم -</option>
                                                            @for($i = 1; $i <= 31; $i++)
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        @endif
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 text-right rtl order-lg-last order-md-last order-sm-first order-first">
                                        <label class="col-form-label required-field">تاريخ الميلاد</label>
                                    </div>

                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-lg-8">
                                        <select class="form-control {{ $errors->has('gender') ? ' is-invalid' : '' }} form-control-sm"
                                                name="gender">
                                            @if($user->student->gender_id == 1)
                                                <option value="1" selected> ذكر</option>
                                                <option value="2">أنثى</option>
                                            @else
                                                <option value="1"> ذكر</option>
                                                <option value="2" selected>أنثى</option>
                                            @endif
                                        </select>
                                        @if ($errors->has('gender'))
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('gender') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-4 text-right rtl order-lg-last order-md-last order-sm-first order-first">
                                        <label class="col-form-label required-field">الجنس</label>
                                    </div>
                                </div>


                                <div class="form-group row mb-0">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn custom-btn">حفظ</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <form action="{{ route('account.password') }}" method="get" id="reset-password"></form>
                                <button type="submit" class="btn custom-btn" form="reset-password">تغير كلمة المرور
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection