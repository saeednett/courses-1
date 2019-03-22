$(document).ready(function () {

    function refreshSelect() {
        // $(".select2").select2();
        $(".select2-placeholer").select2({});
    }

    // Form Wizard
    if ($.isFunction($.fn.bootstrapWizard)) {

        $('#rootwizard').bootstrapWizard({
            tabClass: 'wizard-steps',
            onTabShow: function ($tab, $navigation, index) {
                $tab.prevAll().addClass('completed');
                $tab.nextAll().removeClass('completed');
                $tab.removeClass('completed');
            }

        });

        $(".validate-form-wizard").each(function (i, formwizard) {
            var $this = $(formwizard);
            var $progress = $this.find(".steps-progress div");

            var $validator = $this.validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 10,
                    },

                    category: {
                        required: true,
                        minlength: 1,
                        maxlength: 99,
                    },

                    template: {
                        required: true,
                        minlength: 1,
                        maxlength: 3,
                    },

                    type: {
                        required: true,
                        minlength: 1,
                        maxlength: 2,
                    },

                    city: {
                        required: true,
                        minlength: 1,
                        maxlength: 99,
                    },

                    country: {
                        required: true,
                        minlength: 1,
                        maxlength: 99,
                    },

                    address: {
                        required: true,
                        minlength: 10,
                        maxlength: 200,
                    },

                    location: {
                        required: true,
                        minlength: 10,
                        maxlength: 50,
                    },

                    password: {
                        required: true,
                        minlength: 3
                    },
                    confirmpassword: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true,
                        minlength: 3,
                    }
                }
            });

            // Validation
            var checkValidaion = function (tab, navigation, index) {
                if ($this.hasClass('validate')) {
                    var $valid = $this.valid();
                    if (!$valid) {
                        $validator.focusInvalid();
                        return false;
                    }
                }

                return true;
            };

            $this.bootstrapWizard({
                tabClass: 'wizard-steps',
                onNext: checkValidaion,
                onTabClick: checkValidaion,
                onTabShow: function ($tab, $navigation, index) {
                    $tab.removeClass('completed');
                    $tab.prevAll().addClass('completed');
                    $tab.nextAll().removeClass('completed');
                    refreshSelect();
                }
            });
        });
    }

    $('select[name=country]').on('change', function () {
        var country = $(this).val();
        $.ajax({
            url: "http://127.0.0.1:8000/api/v-1/cities/country=" + country,
            type: "get",
            success: function (data, result) {
                $('select[name=city]').children().remove();
                $('select[name=city]').val(null).trigger('change');
                for (let i = 0; i < data['data'].length; i++) {
                    $('select[name=city]').append("<option value='" + data['data'][i]['id'] + "'>" + data['data'][i]['name'] + "</option>");
                }

                $('select[name=city]').val(data['data'][0]['id']); // Select the option with a value of '1'
                $('select[name=city]').trigger('change');
            },
            error: function () {
                alert("هناك خطأ الرجاء المحاولة لاحقا");
            }
        });
    });

    refreshSelect();


    $("#add-trainer").on('click', function () {
        let select = $("select[name='trainer[]']");
        let options = $("select[name='trainer[]']:first").children();

        if (parseInt(select.length) >= parseInt(options.length)) {
            $("#warning-model").modal("show");
        } else {
            $('#tab2-2').append("<div class='row'><div class='col-lg-6 col-lg-offset-2 col-md-6 col-md-offset-2 col-sm-10 col-xs-10'> <div class='form-group'><label class='required-field' for='trainer'>المدرب</label><select class='form-control select2-placeholer {{ $errors->has('trainer') ? 'is-invalid' : '' }} custom-input' name='trainer[]'></select></div></div> <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'> <label for='trainer'></label><button type='button' class='btn btn-danger btn-block custom-input remove'><i class='fa fa-trash'></i></button> </div> </div>");
            for (let i = 0; i < options.length; i++) {
                let select = $("select[name='trainer[]']:last");
                select.append("<option value='" + options.eq(i).attr('value') + "' >" + options.eq(i).text() + "</option>");
            }
            refreshSelect();
        }
    });

    $(document).on('click', '.remove', function () {
        $(this).parent().parent().remove();
    });


    $("select[name=type]").on('change', function () {
        let value = $(this).val();
        if (value == 2) {
            $("#tab2-3").append("<div class='row'> <div class='col-lg-6 col-lg-offset-3'> <div class='form-group'> <label class='required-field' for='price'>قيمة الدورة</label> <input type='text' class='form-control custom-input text-center num-only ltr' name='price' id='price'  placeholder='قيمة الدورة' autocomplete='off' required> </div></div> </div>   <div class='row'> <div class='col-lg-6 col-lg-offset-3'> <div class='form-group'> <label class='required-field' for='coupon'>كوبونات الخصم</label> <select class='form-control select2-placeholer {{ $errors->has('coupon') ? 'is-invalid' : '' }}' name='coupon' id='coupon'> <option value='0'> لا يوجد كوبونات خصم</option><option value='1'>يوجد كوبونات خصم</option></select></div></div> </div>");
            refreshSelect();
        } else {
            $("#tab2-3 > div:not(#tab2-3 > div:eq(0))").remove();
        }
    });

    $(document).on('change', 'select[name=coupon]', function () {
        let value = $(this).val();
        if (value == 1) {
            $("#tab2-3").append("<div class='row'><div class='col-lg-2 col-lg-offset-5'> <label for='trainer'></label><button type='button' class='btn btn-success btn-block custom-input' id='add-coupon'><i class='fa fa-plus-circle'></i></button> </div> </div>");
            $("#tab2-3").append("<div class='row' style='margin-top:20px;'><div class='col-lg-4 col-lg-offset-2'> <div class='form-group'> <label class='required-field' for='coupon'>كود الخصم</label> <input type='text' class='form-control custom-input text-center ltr' name='coupon_code[]'  placeholder='كود الخصم' autocomplete='off' required> </div></div> <div class='col-lg-4'> <div class='form-group'> <label class='required-field' for='coupon'>قيمة الخصم</label> <input type='text' class='form-control custom-input text-center num-only ltr' name='coupon_discount[]'  placeholder='قيمة الخصم بالنسبة المئوية' autocomplete='off' required> </div></div> </div>");
        } else {
            $("#tab2-3 > div:not(#tab2-3 > div:eq(0), #tab2-3 > div:eq(1), div:eq(2))").remove();
        }
    });

    $(document).on('click', '#add-coupon', function () {
        $("#tab2-3").append("<div class='row' style='margin-top:20px;'><div class='col-lg-3 col-lg-offset-2'> <div class='form-group'> <label class='required-field' for='coupon'>كود الخصم</label> <input type='text' class='form-control custom-input text-center ltr' name='coupon_code[]'  placeholder='كود الخصم' autocomplete='off' required> </div></div> <div class='col-lg-3'> <div class='form-group'> <label class='required-field' for='coupon'>قيمة الخصم</label> <input type='text' class='form-control custom-input text-center num-only ltr' name='coupon_discount[]'  placeholder='قيمة الخصم بالنسبة المئوية' autocomplete='off' required> </div></div> <div class='col-lg-2'> <label for='trainer'></label><button type='button' class='btn btn-danger btn-block custom-input remove'><i class='fa fa-trash'></i></button> </div> </div>");
    });

    refreshTimePicker();

    function refreshTimePicker() {

        $.fn.datepicker.dates['ar'] = {
            days: ["الاأحد", "الاإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"],
            daysShort: ["احد", "اثن", "ثلا", "ارب", "خمي", "جمع", "سبت"],
            daysMin: ["اح", "اث", "ثل", "ار", "خم", "جم", "سب"],
            months: ["يناير", "فبراير", "مارس", "ابريل", "مايو", "يونيو", "يوليو", "اغصطس", "سبتمبر", "اكتوبر", "نوفمبر", "ديسمبر"],
            monthsShort: ["ينا", "فبر", "مار", "ابر", "ماي", "يون", "يول", "اغسط", "سبت", "اكت", "نوف", "ديس"],
            today: "اليوم",
            clear: "حذف",
            format: "yyyy/mm/dd",
            titleFormat: "yyyy MM", /* Leverages same syntax as 'format' */
            weekStart: 0,
        };

        $("input[name=start_date]").datepicker({
            keyboardNavigation: false,
            forceParse: false,
            todayHighlight: true,
            format: 'yyyy/mm/dd',
            autoclose: true,
            clearBtn: true,
            startDate: new Date(),
            title: "تاريخ الدورة",
            language: "ar"

        });

        initializeFinishDate();
        function initializeFinishDate() {
            $("input[name=end_date]").datepicker({
                keyboardNavigation: false,
                forceParse: false,
                todayHighlight: false,
                format: 'yyyy/mm/dd',
                autoclose: true,
                clearBtn: true,
                title: "تاريخ انتهاء الدورة",
                language: "ar"

            });
        }

        function refreshFinishDate(date){
            if (date.length < 10 || date.length > 10){
                $("input[name=end_date]").prop({'readonly': false, 'disabled': true});
            }else {
                $("input[name=end_date]").prop({'readonly': false, 'disabled': false});
                $("input[name=end_date]").datepicker('update', '');
                $("input[name=end_date]").datepicker( 'setStartDate', new Date(date));
            }
        }


        initializeEndReservation();
        function initializeEndReservation() {
            $("input[name=end_reservation]").datepicker({
                keyboardNavigation: false,
                forceParse: false,
                todayHighlight: false,
                format: 'yyyy/mm/dd',
                autoclose: true,
                clearBtn: true,
                title: "تاريخ انتهاء التسجيل",
                language: "ar"

            });
        }

        function refreshEndReservation(date) {
            if (date.length < 10 || date.length > 10) {
                $("input[name=end_reservation]").prop({'readonly': false, 'disabled': true});
            } else {
                $("input[name=end_reservation]").prop({'readonly': false, 'disabled': false});
                $("input[name=end_reservation]").datepicker('update', '');
                $("input[name=end_reservation]").datepicker( 'setEndDate', new Date(date));
                $("input[name=end_reservation]").datepicker( 'setStartDate', new Date());
            }
        }


        $("input[name=start_date]").on('change', function () {
            refreshFinishDate($("input[name=start_date]").val());
            refreshEndReservation($("input[name=start_date]").val());

        });

        $("input[name=start_time]").clockpicker({
            autoclose: true,
            placement: "top",
            align: "right",
            donetext: "موافق",
            // twelvehour: true,
            default: 'now'
        });

    }

    $("#course-poster-1").on('click', function () {
        $("input[name=course-poster-1]").trigger('click');
    });

    $("input[name=course-poster-1]").on('change', function () {
        let file = $("input[name=course-poster-1]")[0].files[0];
        $("#course-poster-1").val(file.name);
    });

    $("#course-poster-2").on('click', function () {
        $("input[name=course-poster-2]").trigger('click');
    });

    $("input[name=course-poster-2]").on('change', function () {
        let file = $("input[name=course-poster-2]")[0].files[0];
        $("#course-poster-2").val(file.name);
    });


    $(document).on("keypress", '.num-only', function (evt) {
        let charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    });

    // For The Attendance Gender
    $("select[name=gender]").on('change', function () {

        if ( $(this).val() == 3 ){
            $('<div class="row" id="attendance-amount"> <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> <div class="form-group"> <label class="required-field" for="men-amount">مقاعد الرجال</label> <input type="text" class="form-control custom-input text-center num-only ltr" name="men_amount" id="men-amount" placeholder="مقاعد الرجال" minlength="1" maxlength="4" autocomplete="off" required> </div> </div>  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"> <div class="form-group"> <label class="required-field" for="women-amount">مقاعد النساء</label> <input type="text" class="form-control custom-input text-center num-only ltr" name="women_amount" id="women-amount" placeholder="مقاعد النساء" minlength="1" maxlength="4" autocomplete="off" required> </div> </div> </div>').insertAfter(  $(this).parent().parent().parent()  );
        }else{
            if ( $("#attendance-amount").length > 0 ){
                $("#attendance-amount").remove();
            }
        }

    });
});