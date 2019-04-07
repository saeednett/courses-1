$(".toggle").bootstrapToggle({
    on: 'مفعلة',
    off: 'غير مفعلة',
    onstyle: 'success',
    offstyle: 'danger',
});
$(document).ready(function () {
    // Save The Original State In An Array To Compare To The New State
    let state = [];
    // Collection The Original State Function
    function get_state() {
        for (let i = 0; i < $(".toggle").length; i++) {
            let toggle_state = $(".toggle").eq(i).prop('checked');
            state[i] = toggle_state;
        }
    }
    // Calling The Function To Start Collection
    get_state();
    // Listening To The Change On CheckBox Or Input Toggle
    $("input[type=checkbox]").on('change', function () {
        let value = $(this).prop('checked');
        if (value) {
            $(this).parent().next().val(1);
        } else {
            $(this).parent().next().val(0);
        }
    });

    // Listening To The Click Event On The Button To Save The Changes
    $("#activation-form-save-changes").click(function (e) {
        e.preventDefault();
        $("#warning-model").modal("show");

        $(document).on('click', '#agree-warning', function () {
            $("#activation-form").submit();
        });

    });

    // Listening To The Click Event On The Button To Cancel Saving The Changes
    $(document).on('click', '#cancel-warning', function () {
        // Hide The Alert Box Or Waring Box
        $("#warning-model").modal("hide");
        // Compare The Original State To The New To Reset View As It Was
        for (let i = 0; i < state.length; i++) {
            let toggle_state = $(".toggle").eq(i);
            if( state[i] === true && state[i] !== toggle_state.prop('checked') ){
                toggle_state.bootstrapToggle('on');
                toggle_state.parent().next().val(1);
            }else if( state[i] === false && state[i] !== toggle_state.prop('checked') ){
                toggle_state.bootstrapToggle('off');
                toggle_state.parent().next().val(0);
            }else{

            }
        }
    });

});