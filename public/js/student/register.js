$(document).on("keypress", '.num-only', function (evt) {

    let error_model = $("#warning-model");
    let charCode = (evt.which) ? evt.which : event.keyCode;

    if ( $(this).val().length === 0 ){

        if ( charCode === 53 ){
            return true;
        }else {
            return false;
        }

    }else{
        if ( $(this).val().length === 9 ){
            error_model.modal("show");
            return false;
        }else{
            if ( charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }else{
                return true;
            }
        }
    }

});