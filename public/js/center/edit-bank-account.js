$(document).ready(function () {

    let counter = 2;
    $(document).on('click', '.add-account', function () {
        $('#accounts').append("<div class='row form-group' id='new-row'> <div class='col-lg-5'> <label class='col-form-label required-field' for='account_owner_" + counter + "' >اسم صاحب الحساب</label> <input type='account_owner' id='account_owner_" + counter + "' class='form-control custom-input' name='account_owner[]' placeholder='اسم صاحب الحساب' autocomplete='off' required> </div> </div>");
        $('#new-row').append("<div class='col-lg-3'> <label class='col-form-label required-field' for='account_number_" + counter + "' >رقم الحساب</label> <input type='text' id='account_number_" + counter + "' class='form-control custom-input' name='account_number[]' placeholder='رقم الحساب' autocomplete='off' required> </div>");
        $('#new-row').append("<div class='col-lg-3'> <label class='col-form-label required-field' for='bank_" + counter + "'>البنك</label>  <select id='new-account' class='form-control custom-input' name='bank[]' required>  </select>  </div>");


        for (let i = 0; i < $('#main-bank').children().length; i++) {
            let text = $('#main-bank').children().eq(i).text();
            let value = $('#main-bank').children().eq(i).attr('value');
            $('#new-account').append("<option value='" + value + "'>" + text + "</option>");
        }
        $('#new-row').append("<div class='col-lg-1 text-center'> <label class='col-form-label opacity-0' for='bank'>المزيد</label> <span class='btn-danger text-center fa fa-remove remove-account'></span> </div>");
        counter++;
        $("#new-row").removeAttr('id');
        $('#new-account').removeAttr("id");
    });

    $(document).on('click', '.remove-account', function () {
        $(this).parent().parent().remove();
    });
});