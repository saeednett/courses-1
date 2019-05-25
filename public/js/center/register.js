$(document).ready(function () {

    var status = false;
    const bank = $("#bank");
    const account_owner = $("#account_owner");
    const account_number = $("#account_number");
    const city = $('select[name=city]');
    const profile_logo = $("#profile-logo");
    const website = $('input[name=website]');
    const country = $('select[name=country]');
    const profile_cover = $("#profile-cover");
    const profile_image = $("input[name=profile-image]");
    const center_type = $("select[name=center_type]");
    const verification_code = $("#verification_code");
    const verification_authority = $("#verification_authority");

    $(document).on("keypress", '.num-only', function (evt) {

        let charCode = (evt.which) ? evt.which : event.keyCode;

        if ( $(this).val().length === 0 ){
            if ( charCode === 48 ){
                return true;
            }else {
                return false;
            }
        }else if($(this).val().length === 1){
            if ( charCode === 53 ){
                return true;
            }else {
                return false;
            }
        }else if($(this).val().length < 10){
            if ( charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }else{
            return false;
        }

    });


    $(document).on("keypress", '.num', function (evt) {

        let charCode = (evt.which) ? evt.which : event.keyCode;

        if ( charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;

    });


    $(document).on('paste', website, function (e) {
        var content = '';

        if (isIE()) {
            //IE allows to get the clipboard data of the window object.
            content = window.clipboardData.getData('text');
        } else {
            //This works for Chrome and Firefox.
            content = e.originalEvent.clipboardData.getData('text/plain');
        }

        var regex = /www[.][0-9a-zA-Z]{3,20}[.][com|org|net|edu|biz|]{3}/g;
        match = regex.exec(content);

        if ( match === null ){
            return false;
        }else {
            website.val(match);
            return false;
        }

    });

    $(document).on('change', website, function () {
        var content = website.val();


        var regex = /www[.][0-9a-zA-Z]{3,20}[.][com|org|net|edu|biz|]{3}/g;
        match = regex.exec(content);

        if ( match === null ){
            website.val("");
        }else {
            website.val(match);
        }

    });

    function isIE(){
        var ua = window.navigator.userAgent;

        return ua.indexOf('MSIE ') > 0 || ua.indexOf('Trident/') > 0 || ua.indexOf('Edge/') > 0
    }

    country.on('change', function () {
        var country = $(this).val();
        $.ajax({
            url: "http://127.0.0.1:8000/api/v-1/cities/country=" + country,
            type: "get",
            success: function (data, result) {
                city.children().remove();
                for (let i = 0; i < data['data'].length; i++) {
                    city.append("<option value='" + data['data'][i]['id'] + "'>" + data['data'][i]['name'] + "</option>");
                }
            },
            error: function () {
                alert("هناك خطأ الرجاء المحاولة لاحقا");
            }
        });
    });

    profile_logo.on('click', function () {
        profile_image.trigger('click');
    });

    profile_image.on('change', function () {
        let file = profile_image[0].files[0];
        profile_logo.val(file.name);
    });

    profile_logo.on('click', function () {
        profile_image.trigger('click');
    });

    profile_image.on('change', function () {
        let file = profile_image[0].files[0];
        profile_cover.val(file.name);
    });


    center_type.on('change', function () {

        if ( parseInt($(this).val()) === 0) {

            verification_code.fadeOut('slow', function () {
                $(this).children().remove();
            });

            verification_authority.fadeOut('slow', function () {
                $(this).children().remove();
            });

            bank.fadeOut('slow', function () {
                $(this).children().remove();
            });

            account_owner.fadeOut('slow', function () {
                $(this).children().remove();
            });

            account_number.fadeOut('slow', function () {
                $(this).children().remove();
            });

            status = true;

        } else if ( parseInt($(this).val()) === 1) {

            if ( status ){

                verification_code.fadeIn('slow', function () {
                    $(this).append('<div class="col-lg-9"><input type="text" name="verification_code" class="form-control custom-input num-only text-center" placeholder="رقم الترخيص" autocomplete="off" maxlength="10" required> </div> <div class="col-lg-3 text-center pt-2"> <label class="col-form-label required-field rtl">رقم الترخيص</label> </div>');
                });

                verification_authority.fadeIn('slow', function () {
                    $(this).append('<div class="col-lg-9"> <input type="text" name="verification_authority" class="form-control custom-input text-center" placeholder="الجهة المرخصة" autocomplete="off" required> </div> <div class="col-lg-3 text-center pt-2"> <label class="col-form-label required-field rtl">الجهة المرخصة</label> </div>');
                });

                bank.fadeIn('slow', function () {
                    getBanks();
                    $(this).append('<div class="col-lg-9"> <select class="custom-select custom-input" name="bank" required> <option>- البنك -</option> </select> </div> <div class="col-lg-3 text-center pt-2"> <label class="col-form-label required-field rtl">اسم البنك</label> </div>');
                });

                account_owner.fadeIn('slow', function () {
                    $(this).append('<div class="col-lg-9"> <input type="text" name="account_owner" class="form-control custom-input text-center" placeholder="اسم صاحب الحساب" autocomplete="off" maxlength="50" minlength="10" required> </div> <div class="col-lg-3 text-center pt-2"> <label class="col-form-label required-field rtl">اسم الحساب</label> </div>');
                });

                account_number.fadeIn('slow', function () {
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

                bank.children().remove();
                for (let i = 0; i < data['data'].length; i++) {
                    bank.append("<option value='" + data['data'][i]['id'] + "'>" + data['data'][i]['name'] + "</option>");
                }
            },
            error: function () {
                alert("هناك خطأ الرجاء المحاولة لاحقا");
            }
        });
    }
});