$(document).ready(function () {


    $(".show-barcode").click(function (e) {
        e.preventDefault();

        let link = $(this).attr('data-link');

        $(".body-cover").fadeIn('slow', function () {
            $(".barcode-holder").fadeIn('fast', function () {
                $("#barcode-image").attr('src', link);
            });
        });

    });



    $(".body-cover").click(function () {

        $(this).fadeOut('slow');

    });


});