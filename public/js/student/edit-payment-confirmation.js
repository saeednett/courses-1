$(document).ready(function () {

    let receipt_image = $("input[name=receipt-image]");
    let image_input = $("#receipt-image");

    $('.carousel').carousel();


    image_input.on('click', function () {
        receipt_image.trigger('click');
    });

    receipt_image.on('change', function () {
        let file = receipt_image[0].files[0];
        image_input.val(file.name);
    });


    $(document).on("keypress", '.num-only', function (evt) {
        let charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    });

});