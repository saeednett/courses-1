$(document).ready(function () {

    $('.carousel').carousel();

    let min = 9;
    let sec = 60;
    if (min == 0 && sec == 0) {
        alert("yes");
    }

    let countdown = setInterval(function () {
        if (min == 0 && sec == 0) {
            $('#counter').text(min + ":" + sec);
            clearInterval(countdown);
            history.back();
        } else {
            if (sec == 0) {
                min--;
                sec = 59;
            } else {
                sec--;
            }
        }
        $('#counter').text(min + ":" + sec);
    }, 1000);


    $("select[name=bank]").on('change', function () {
        var bank = $(this).val();
        var center = $("input[name=center]").val();
        $.ajax({
            url: "http://127.0.0.1:8000/api/v-1/account/center=" + center + "&bank=" + bank,
            type: "get",
            success: function (data, result) {
                $(".account-information").children().remove();
                $(".account-information").append(" <div class='row justify-content-center'> <div class='col-lg-8'> <img src='" + data['response']['logo'] + "' class='d-block ml-auto w-100' alt='Bank Logo'> </div> </div> <div class='row justify-content-center mt-4'> <div class='col-lg-8 text-right'> <p class='mb-0 rtl'> البنك : " + data['response']['name'] + " </p></div> </div> <div class='row justify-content-center mt-0'> <div class='col-lg-8 text-right'> <p class='m-0 rtl'> اسم الحساب : " + data['response']['account_owner'] + " </p> </div> </div> <div class='row justify-content-center mt-0'> <div class='col-lg-8 text-right'> <p class='m-0 rtl'>  رقم الحساب : " + data['response']['account_number'] + " </p> </div> </div> <div class='row justify-content-center mt-0'> <div class='col-lg-8 text-right'>  <p class='m-0 rtl'>  رقم الايبان : " + data['response']['account_number'] + " </p> </div> </div> ");
            },
            error: function () {
                alert("هناك خطأ الرجاء المحاولة لاحقا");
            }
        });
    });

    $("button[id=check_coupon_code]").on('click', function (e) {
        e.preventDefault();

        let code = $("input[name=coupon_code]").val();

        if (code.length <= 0 || code.length < 3) {
            $("input[name=coupon_code]").addClass('is-invalid');
            $("#coupon_error_description").text("");
            $("#coupon_error_description").text("كود الخصم لابد ان يكون ٣ احرف او أكثر").removeClass('valid-feedback').addClass('invalid-feedback');
        } else {

            if ($("input[name=coupon_code]").has('is-invalid')) {
                $("input[name=coupon_code]").removeClass('is-invalid');
                $("#coupon_error_description").text("");
            }

            let str = document.location.href.toString().split("/");
            let course = str[3];

            $.ajax({
                url: "http://127.0.0.1:8000/api/v-1/coupon/course=" + course + "&coupon=" + code,
                type: "get",
                success: function (data, result) {
                    if (data['status'] == "Success") {
                        $("#coupon_error_description").text(data['response']).removeClass('invalid-feedback').addClass('valid-feedback');
                    } else {
                        $("#coupon_error_description").text(data['response']).removeClass('valid-feedback').addClass('invalid-feedback');
                    }
                },
                error: function () {
                    alert("هناك خطأ الرجاء المحاولة لاحقا");
                }
            });

        }
    });

});