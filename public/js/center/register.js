$(document).ready(function () {

    var status = false;

    $(document).on("keypress", '.num-only', function (evt) {
        let charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    });


    $('select[name=country]').on('change', function () {
        var country = $(this).val();
        $.ajax({
            url: "http://127.0.0.1:8000/api/v-1/cities/country=" + country,
            type: "get",
            success: function (data, result) {
                $('select[name=city]').children().remove();
                for (let i = 0; i < data['data'].length; i++) {
                    $('select[name=city]').append("<option value='" + data['data'][i]['id'] + "'>" + data['data'][i]['name'] + "</option>");
                }
            },
            error: function () {
                alert("هناك خطأ الرجاء المحاولة لاحقا");
            }
        });
    });

    $("#profile-logo").on('click', function () {
        $("input[name=profile-logo]").trigger('click');
    });

    $("input[name=profile-logo]").on('change', function () {
        let file = $("input[name=profile-logo]")[0].files[0];
        $("#profile-logo").val(file.name);
    });

    $("#profile-cover").on('click', function () {
        $("input[name=profile-cover]").trigger('click');
    });

    $("input[name=profile-cover]").on('change', function () {
        let file = $("input[name=profile-cover]")[0].files[0];
        $("#profile-cover").val(file.name);
    });


    $("select[name=center_type]").on('change', function () {

        if ($(this).val() == 0) {

            $("#verification_code").fadeOut('slow', function () {
                $(this).children().remove();
            });

            $("#verification_authority").fadeOut('slow', function () {
                $(this).children().remove();
            });

            $("#bank").fadeOut('slow', function () {
                $(this).children().remove();
            });

            $("#account_owner").fadeOut('slow', function () {
                $(this).children().remove();
            });

            $("#account_number").fadeOut('slow', function () {
                $(this).children().remove();
            });

            status = true;

        } else if ($(this).val() == 1) {

            if ( status ){

                $("#verification_code").fadeIn('slow', function () {
                    $(this).append('<div class="col-lg-9"><input type="text" name="verification_code" class="form-control custom-input num-only text-center" placeholder="رقم الترخيص" autocomplete="off" maxlength="10" required> </div> <div class="col-lg-3 text-center pt-2"> <label class="col-form-label required-field rtl">رقم الترخيص</label> </div>');
                });

                $("#verification_authority").fadeIn('slow', function () {
                    $(this).append('<div class="col-lg-9"> <input type="text" name="verification_authority" class="form-control custom-input text-center" placeholder="الجهة المرخصة" autocomplete="off" required> </div> <div class="col-lg-3 text-center pt-2"> <label class="col-form-label required-field rtl">الجهة المرخصة</label> </div>');
                });

                $("#bank").fadeIn('slow', function () {
                    getBanks();
                    $(this).append('<div class="col-lg-9"> <select class="custom-select custom-input" name="bank" required> <option>- البنك -</option> </select> </div> <div class="col-lg-3 text-center pt-2"> <label class="col-form-label required-field rtl">اسم البنك</label> </div>');
                });

                $("#account_owner").fadeIn('slow', function () {
                    $(this).append('<div class="col-lg-9"> <input type="text" name="account_owner" class="form-control custom-input text-center" placeholder="اسم صاحب الحساب" autocomplete="off" maxlength="50" minlength="10" required> </div> <div class="col-lg-3 text-center pt-2"> <label class="col-form-label required-field rtl">اسم الحساب</label> </div>');
                });

                $("#account_number").fadeIn('slow', function () {
                    $(this).append('<div class="col-lg-9"> <input type="text" name="account_number" class="form-control custom-input num-only text-center" placeholder="رقم الحساب | الايبان" autocomplete="off" maxlength="20" minlength="20" required> </div> <div class="col-lg-3 text-center pt-2"> <label class="col-form-label required-field rtl">رقم الحساب</label> </div>');
                });

            }

        }


    });


    function getBanks() {

        $.ajax({
            url: "http://127.0.0.1:8000/Service/Banks/",
            type: "get",
            success: function (data, result) {

                $('select[name=bank]').children().remove();
                for (let i = 0; i < data['data'].length; i++) {
                    $('select[name=bank]').append("<option value='" + data['data'][i]['id'] + "'>" + data['data'][i]['name'] + "</option>");
                }
            },
            error: function () {
                alert("هناك خطأ الرجاء المحاولة لاحقا");
            }
        });
    }
});