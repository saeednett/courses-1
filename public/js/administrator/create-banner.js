
function readCover(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $("#barcode")
                .attr('src', e.target.result)
        };

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready( function () {

    $("#banner-image").on('click', function () {
        $("input[name=banner-image]").trigger('click');
    });

    $("input[name=banner-image]").on('change', function () {
        let file = $("input[name=banner-image]")[0].files[0];
        $("#banner-image").val(file.name);
    });

});

