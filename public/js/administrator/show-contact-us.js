$(document).ready(function () {

    $(".show-message").click(function (e) {
        e.preventDefault();
        let message = $(this).attr("data-message");
        let name = $(this).attr("data-name");
        let phone = $(this).attr("data-phone");
        let email = $(this).attr("data-email");

        $(".page-cover").fadeIn("slow", function () {
            $(".message-holder").fadeIn("slow", function () {
                $("#message").text(message);
                $("#message-name").text(name);
                $("#message-phone").text(phone);
                $("#message-email").text(email);
            });
        });
        // alert(message);
    });


    $(".page-cover").click(function () {
        $(this).fadeOut("slow", function () {

        });
    });

});