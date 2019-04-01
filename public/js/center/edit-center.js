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

    $('select[name=country]').on('change', function () {
        var country = $(this).val();
        $.ajax({
            url: "http://127.0.0.1:8000/api/v-1/cities/country=" + country,
            type: "get",
            success: function (data, result) {
                $('select[name=city]').children().remove();
                $('select[name=city]').val(null).trigger('change');
                for (let i = 0; i < data['data'].length; i++) {
                    $('select[name=city]').append("<option value='" + data['data'][i]['id'] + "'>" + data['data'][i]['name'] + "</option>");
                }

                $('select[name=city]').val(data['data'][0]['id']); // Select the option with a value of '1'
                $('select[name=city]').trigger('change');
            },
            error: function () {
                alert("هناك خطأ الرجاء المحاولة لاحقا");
            }
        });
    });


    $(".select2-placeholer").select2({

    });

    $("#profile-logo").on('click', function () {
        $("input[name=profile-logo]").trigger('click');
    });

    $("input[name=profile-logo]").on('change', function () {
        let file = $("input[name=profile-logo]")[0].files[0];
        $("#profile-logo").val(file.name);
    });

    $("#profile-cover").on('click', function () {
        $("input[name=profile-cover]").trigger('click');
    });

    $("input[name=profile-cover]").on('change', function () {
        let file = $("input[name=profile-cover]")[0].files[0];
        $("#profile-cover").val(file.name);
    });

});