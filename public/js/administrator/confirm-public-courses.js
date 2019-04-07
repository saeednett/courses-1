$(".toggle").bootstrapToggle();
$(document).ready(function () {

    $("input[type=checkbox]").on('change', function () {
        let value = $(this).prop('checked');
        if ( value ){

            $(this).parent().next().val(1);
        }else{
            $(this).parent().next().val(0);
        }
    });

    $("#public-form-save-changes").click(function (e) {
        e.preventDefault();
        $("#warning-model").modal("show");

        $(document).on('click', '#agree-warning', function () {
            $("#public-form").submit();
        });

    });

    $(document).on('click', '#cancel-warning', function () {
        $("#warning-model").modal("hide");
    });

});