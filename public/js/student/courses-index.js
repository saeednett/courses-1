$(document).ready(function () {

    // This Function Prevent Pressing Tab On The Keyboard
    $(document).keydown( function ( event ) {
        var keyCode = event .keyCode || event .which;
        if (keyCode == 9) {
            event .preventDefault();
        }
    });
    // This Function For Moving The Waiting Loader To The Left Then Call The Other Function
    function toLeft(){
        $(".loader_holder").animate({
                left: "-40px",
            }, 300, toRight);
    }
    // This Function For Moving The Waiting Loader To The Right Then Call The Other Function
    function toRight(){
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
            for (let i = 0; i < 2; i++){
                $(".blocker").children().eq(i).css({
                    'display': 'none',
                });
            }
        });
    }
    // This Function Remove The Old View To Be Ready For The New View
    function removeView() {

        return new Promise(function (resolve, reject){

            // $("#viewHolder").children().remove();
            for (let i = 0; i < $("#viewHolder").children().length; i++){
                $("#viewHolder").children().eq(i).fadeOut(800, function () {

                    if ( (i + 1) == $("#viewHolder").children().length ){
                        resolve("done");
                    }

                    $("#viewHolder").children().eq(i).remove();

                });
            }

        });
    }
    // This Function Create The New View With The New Data That Came From The Server
    function createView(data) {
        return new Promise(function (resolve, reject) {
            for (let i = 0; i < data.length; i++){
                let price;
                if ( data[i]['type'] == 'free' ){
                    price = "مجانا";
                }else{
                    price = " ريال "+data[i]['price'];
                }
                $("#viewHolder").append("<div class='col-lg-4 col-md-4 col-sm-4 col-12 mt-3'> <a class='card' href='"+data[i]['center']+"/"+data[i]['identifier']+"/CourseDetails' title='"+data[i]['title']+"'> <img src='/storage/course-images/"+data[i]['poster_1']+"'class='card-img-top' alt='...' width='301' height='200'> <div class='card-title text-center mt-2 mr-2'> <h5>"+data[i]['title']+"</h5> </div> <div class='adv-footer'> <p class='adv-price'>"+price+"</p> <p class='adv-place'>"+data[i]['city']+"</p> </div> <div class='clear'></div> </a> </div>");


                if ( (i + 1) == data.length ){
                    resolve("done");
                }
            }
        });
    }
    // This Function Creates A View With Message That No Data Found
    function createNullView(){
        return new Promise(function (resolve, reject) {
            $("#viewHolder").append("<div class='col-12 mt-4'> <h2 class='text-right text-danger'>لاتوجد دورات حسب التصنيف المطلوب</h2> </div>");
            resolve("done");
        })
    }
    // This Function Hides The Loader
    function hideLoader() {
        $(".loader_holder").stop();
        $(".loader_holder").fadeOut(400, function () {
            $(".loader_holder").css({'display': 'none',});
        });
    }
    // This Function Shows An Error Message About The Request
    function showRequestError(message){
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

        var filter = $(this).attr('data-filter');
        let CSRF_TOKEN = $("input[name=token]").val();
        if ( $(this).hasClass('custom-active') ){

        }else {
            $(".custom-active").removeClass('custom-active');
            $(this).addClass('custom-active');
        }

        showBlocker();

        $.ajax({
            url: "http://127.0.0.1:8000",
            type: "post",
            data: {_token: CSRF_TOKEN, type:filter},
            dataType: 'JSON',
            success: function (data, result) {
                let status = data.status;
                if ( status == "success" ){
                    if ( data.response.length > 0 ){
                        removeView().then(function (result) {
                            createView(data['response']).then(function (result) {
                                hideBlocker();
                            })
                        });
                    }else {
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