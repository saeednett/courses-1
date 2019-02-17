$(document).ready(function () {

    $('.carousel').carousel();


    $("#receipt-image").on('click', function () {
        $("input[name=receipt-image]").trigger('click');
    });

    $("input[name=receipt-image]").on('change', function () {
        let file = $("input[name=receipt-image]")[0].files[0];
        $("#receipt-image").val(file.name);
    });


    $(document).on("keypress", '.num-only', function (evt) {
        let charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    });

});