$(document).ready(function () {

    // This Function Prevent Pressing Tab On The Keyboard
    $(document).keydown(function (event) {
        var keyCode = event.keyCode || event.which;
        if (keyCode === 9) {
            event.preventDefault();
        }
    });

    // This Function For Moving The Waiting Loader To The Left Then Call The Other Function
    function toLeft() {
        $(".loader_holder").animate({
            left: "-40px",
        }, 300, toRight);
    }

    // This Function For Moving The Waiting Loader To The Right Then Call The Other Function
    function toRight() {
        $(".loader_holder").animate({
            left: "40px",
        }, 300, toLeft);
    }

    // This Function Shows The Blocker When Loading Data From The Server
    function showBlocker() {
        $(".loader_holder").fadeIn(100, function () {
            toLeft();
        });
        $(".blocker").fadeIn(600, function () {
        });
    }

    // This Function Hides The Blocker After Finishing Loading Data From The Server
    function hideBlocker() {
        $(".blocker").fadeOut(800, function () {
            for (let i = 0; i < 2; i++) {
                $(".blocker").children().eq(i).css({
                    'display': 'none',
                });
            }
        });
    }

    // This Function Remove The Old View To Be Ready For The New View
    function removeView() {
        var length = $("#viewHolder").children().length;
        return new Promise(function (resolve, reject) {

            // $("#viewHolder").children().remove();
            for (let i = 0; i < $("#viewHolder").children().length; i++) {
                $("#viewHolder").children().eq(i).fadeOut(800, function () {

                    if ((i + 1) === length ) {
                        resolve("done");
                    }

                    $("#viewHolder").children().eq(i).remove();

                });
            }

        });
    }

    // This Function Create The New View With The New Data That Came From The Server
    function createView(data) {
        var length = Object.keys(data).length;
        return new Promise(function (resolve, reject) {
            for (let i = 0; i < length; i++) {
                let price;
                let linkText;

                if (data[i]['type'] === 'free') {
                    price = "مجانا";
                } else {
                    price = " ريال " + data[i]['price'];
                    linkText = "إبلاغ بدفع ( " + data[i]['price'] + " ) ريال";

                }


                if (data[i]['ticket_type'] === "confirmed") {
                    $("#viewHolder").append("<div class='col-lg-4 col-md-4 col-sm-4 col-12 mt-3'> <div class='card'> <img src='/storage/course-images/" + data[i]['poster_1'] + "'class='card-img-top' alt='...' width='301' height='200'> <div class='card-title text-center mt-2 mr-2'> <h5>" + data[i]['title'] + "</h5> </div> <div class='adv-footer'> <p class='adv-price'>" + price + "</p> <p class='adv-place'>" + data[i]['city'] + "</p> </div> <div class='clear'></div> </div> <div class='status'> <div class='col-12 show-confirmed-ticket bg-success'> <a href='"+data[i]['identifier']+"/CourseTicket'> <button class='btn btn-block rtl'> <p class='text-center mb-0'><b>عرض بطاقة الحضور</b></p> </button> </a> </div> </div> <div class='status border-top'> <div class='col-12 confirmed-ticket-label bg-success'> <p class='text-white text-center mb-0'><b>مؤكدة</b></p> </div> </div> </div>");
                } else if (data[i]['ticket_type'] === "AdminUnconfirmed") {
                    $("#viewHolder").append("<div class='col-lg-4 col-md-4 col-sm-4 col-12 mt-3'> <div class='status'> <div class='col-12 cancel-reservation bg-danger'> <a href='"+ data[i]['identifier'] +"/CancelReservation'> <button class='btn btn-block rtl'> <p class='text-white text-center mb-0'><b>إلغاء الحجز</b></p> </button> </a> </div> </div> <div class='card'> <img src='/storage/course-images/" + data[i]['poster_1'] + "'class='card-img-top' alt='...' width='301' height='200'> <div class='card-title text-center mt-2 mr-2'> <h5>" + data[i]['title'] + "</h5> </div> <div class='adv-footer'> <p class='adv-price'>" + price + "</p> <p class='adv-place'>" + data[i]['city'] + "</p> </div> <div class='clear'></div> </div> <div class='status'> <div class='col-12 p-0 m-0'> <a href='" + data[i]['identifier'] + "/PaymentConfirmation/Edit'> <button class='btn btn-block edit-ticket rtl'> <b>تعديل معلومات تأكيد الدفع</b> </button> </a> </div> </div> <div class='status'> <div class='col-12 unconfirmed-ticket bg-warning'> <p class='text-white text-center mb-0'><b>بنتظار التأكد من الدفع</b></p> </div> </div> </div>");
                } else if (data[i]['ticket_type'] === "StudentUnconfirmed") {
                    $("#viewHolder").append("<div class='col-lg-4 col-md-4 col-sm-4 col-12 mt-3'> <div class='status'> <div class='col-12 cancel-reservation bg-danger'> <a href='"+ data[i]['identifier'] +"/CancelReservation'> <button class='btn btn-block rtl'> <p class='text-white text-center mb-0'><b>إلغاء الحجز</b></p> </button> </a> </div> </div> <div class='card'> <img src='/storage/course-images/" + data[i]['poster_1'] + "'class='card-img-top' alt='...' width='301' height='200'> <div class='card-title text-center mt-2 mr-2'> <h5>" + data[i]['title'] + "</h5> </div> <div class='adv-footer'> <p class='adv-price'>" + price + "</p> <p class='adv-place'>" + data[i]['city'] + "</p> </div> <div class='clear'></div> </div> <div class='status'> <div class='col-12 p-0 m-0'> <a href='" + data[i]['identifier'] + "/PaymentConfirmation'> <button class='btn btn-block payed-ticket rtl'> <b>" + linkText + "</b></button> </a> </div> </div> <div class='status'> <div class='col-12 waiting-paying bg-danger'> <p class='text-white text-center mb-0'><b>بنتظار دفع قيمة الدورة</b></p> </div> </div> </div>");
                } else if(data[i]['ticket_type'] === "finished") {
                    $("#viewHolder").append("<div class='col-lg-4 col-md-4 col-sm-4 col-12 mt-3'> <div class='card'> <img src='/storage/course-images/" + data[i]['poster_1'] + "'class='card-img-top' alt='...' width='301' height='200'> <div class='card-title text-center mt-2 mr-2'> <h5>" + data[i]['title'] + "</h5> </div> <div class='adv-footer'> <p class='adv-price'>" + price + "</p> <p class='adv-place'>" + data[i]['city'] + "</p> </div> <div class='clear'></div> </div> <div class='status'> <div class='col-12 p-0 m-0'> <a href='" + data[i]['identifier'] + "/PaymentConfirmation'> <button class='btn btn-block payed-ticket rtl'> <b>" + linkText + "</b></button> </a> </div> </div> <div class='status'> <div class='col-12 finish-ticket bg-danger'> <p class='text-white text-center mb-0'><b>الدورة منتهية</b></p> </div> </div> </div>");
                }else {
                    $("#viewHolder").append("<div class='col-lg-4 col-md-4 col-sm-4 col-12 mt-3'> <div class='card'> <img src='/storage/course-images/" + data[i]['poster_1'] + "'class='card-img-top' alt='...' width='301' height='200'> <div class='card-title text-center mt-2 mr-2'> <h5>" + data[i]['title'] + "</h5> </div> <div class='adv-footer'> <p class='adv-price'>" + price + "</p> <p class='adv-place'>" + data[i]['city'] + "</p> </div> <div class='clear'></div> </div> <div class='status'> <div class='col-12 p-0 m-0'> <a href='" + data[i]['identifier'] + "/PaymentConfirmation'> <button class='btn btn-block payed-ticket rtl'> <b>" + linkText + "</b></button> </a> </div> </div> <div class='status'> <div class='col-12 unconfirmed-ticket bg-warning'> <p class='text-white text-center mb-0'><b>بنتظار تأكيد التذكرة</b></p> </div> </div> </div>");
                }

                if ((i + 1) === length) {
                    resolve("done");
                }
            }
        });
    }

    // This Function Creates A View With Message That No Data Found
    function createNullView() {
        return new Promise(function (resolve, reject) {
            $("#viewHolder").append("<div class='col-12 mt-4'> <h2 class='text-right text-danger'>لاتوجد تذاكر حسب التصنيف المطلوب</h2> </div>");
            resolve("done");
        })
    }

    // This Function Hide The Alert Div If Exists
    function hideAlertDiv() {
        var successAlertLength = $(".alert-success");
        var dangerAlertLength = $(".alert-danger");

        if ( successAlertLength.length > 0 ){
            successAlertLength.parent().parent().fadeOut("slow", function () {
                successAlertLength.parent().parent().remove();
            });
        }else if( dangerAlertLength.length > 0 ){
            dangerAlertLength.parent().parent().fadeOut("slow", function () {
                dangerAlertLength.parent().parent().remove();
            });
        }
    }

    // This Function Hides The Loader
    function hideLoader() {
        var holder = $(".loader_holder");
        holder.stop();
        holder.fadeOut(400, function () {
            holder.css({'display': 'none',});
        });
    }

    // This Function Shows An Error Message About The Request
    function showRequestError(message) {
        hideLoader();
        return new Promise(function (resolve, reject) {
            $(".blocker").fadeIn(600, function () {
                $(".error_holder").fadeIn(500, function () {
                    $(".error_holder").text(message);
                    resolve("done");
                });
            });
        })
    }

    // This Onclick Listener Occurs When Clicking On Filter Button Then Send Request To The Server
    $(".filter-tabs").click(function () {

        hideAlertDiv();

        var filter = $(this).attr('data-filter');
        let CSRF_TOKEN = $("input[name=token]").val();
        if ($(this).hasClass('custom-active')) {

        } else {
            $(".custom-active").removeClass('custom-active');
            $(this).addClass('custom-active');
        }

        showBlocker();

        $.ajax({
            url: "http://127.0.0.1:8000/Tickets",
            type: "post",
            data: {_token: CSRF_TOKEN, type: filter},
            dataType: 'JSON',
            success: function (data, result) {
                var length = Object.keys(data).length;
                let status = data.status[0];
                if (status === "success") {
                    if (length > 0) {
                        removeView().then(function (result) {
                            createView(data['response']).then(function (result) {
                                hideBlocker();
                            })
                        });
                    } else {
                        // When The Response Is Empty Show An Error Message
                        removeView().then(function (result) {
                            createNullView().then(function (result) {
                                hideBlocker();
                            });
                        });
                    }
                }

            },
            error: function () {
                showRequestError("هناك خطأ تقني الرجاء المحاولة لاحقا").then(function (result) {
                    $(".blocker").click(function () {
                        hideBlocker();
                    });
                });
            }
        });
    });
});