$(document).ready(function () {

    $('.payment-toggle').on('change', function () {
        let value = $(this).prop('checked');
        if (value) {
            $(this).parent().next().val(1);
        } else {
            $(this).parent().next().val(0);
        }
    });

    $('#agree').on('click', function () {
        $('#editing-note').fadeOut('slow', function () {
            $(this).remove();
        });
    });
});