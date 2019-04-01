
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

    $("#barcode-image").on('click', function () {
        $("input[name=barcode-image]").trigger('click');
    });

    $("input[name=barcode-image]").on('change', function () {
        let file = $("input[name=barcode-image]")[0].files[0];
        $("#barcode-image").val(file.name);
    });

});

