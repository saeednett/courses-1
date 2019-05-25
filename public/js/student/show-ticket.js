$(document).ready(function () {

    $('.carousel').carousel();

    $(".show-ticket").click(function (event) {
        event.preventDefault();

        $(document).keydown(function (event) {
            var keyCode = event.keyCode || event.which;
            if (keyCode === 9) {
                event.preventDefault();
            }
        });

        let barcode = $("#barcode").attr('src');
        $(".barcode").css({ 'background': 'url('+barcode+')', 'background-position': 'center', 'background-repeat': 'no-repeat', 'background-size': 'cover', });

        $(".ticket-blocker").fadeIn('slow', function () {

        });

    });

    $(".ticket-blocker").click(function () {
        $(this).fadeOut('slow', function () {

        });
    });

});