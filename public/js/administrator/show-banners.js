$(document).ready(function () {

    $(".show-banner").click(function (e) {
        e.preventDefault();

        let banner = $(this).attr("data-banner-link");

        $(".page-cover").fadeIn("slow", function () {

            $("#image-div").fadeIn("slow", function () {
                $("#image-div").css({
                    'background-image': 'url('+banner+')',
                    'background-repeat': 'no-repeat',
                    'background-position': 'center',
                    'background-size': 'cover',
                });
            });

        });

    });

    $(".page-cover").click(function () {

        $(this).fadeOut("slow", function () {

            $("#image-div").css({
                'background': '',
            });

        });

    });


    $(".delete-banner").click(function (e) {
        e.preventDefault();
        let link = $(this).attr('href');
        $("#warning-model").modal("show");

        $(document).on('click', '#agree-warning', function () {
            window.location.replace(link);
        });

        $(document).on('click', '#cancel-warning', function () {
            $("#warning-model").modal("hide");
        });

    });


});