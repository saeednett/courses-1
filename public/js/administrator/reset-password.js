$(document).ready(function () {
    // Listening To The Click Event On The Button To Save The Changes
    $("#save-changes").click(function (e) {
        e.preventDefault();
        $("#warning-model").modal("show");

        $(document).on('click', '#agree-warning', function () {
            $("#reset-email-form").submit();
        });

    });

    // Listening To The Click Event On The Button To Cancel Saving The Changes
    $(document).on('click', '#cancel-warning', function () {
        // Hide The Alert Box Or Waring Box
        $("#warning-model").modal("hide");

        $("input[name=old_password]").val("");
        $("input[name=password]").val("");
        $("input[name=password_confirmation]").val("");

    });

});