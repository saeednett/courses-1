$(document).ready(function () {

    $(document).on("keypress", '.num-only', function (evt) {

        let charCode = (evt.which) ? evt.which : event.keyCode;

        if ( $(this).val().length == 0 ){
            if ( charCode == 43 ){
                return true;
            }else {
                return false;
            }
        }else{
            if ( charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

    });

    $(".select2").select2();
    $(".select2-placeholer").select2({

    });

    $("#profile-image").on('click', function () {
        $("input[name=profile-image]").trigger('click');
    });

    $("input[name=profile-image]").on('change', function () {
        let file = $("input[name=profile-image]")[0].files[0];
        $("#profile-image").val(file.name);
    });

});