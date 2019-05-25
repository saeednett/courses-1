
$(".toggle-input").bootstrapToggle({
    on: 'إصدار',
    off: 'عدم إصدار',
    onstyle: 'success',
    offstyle: 'danger',
});


$(document).ready(function () {
    // Save The Original State In An Array To Compare To The New State
    const state = [];
    let input_state = 0;
    const toggle_state = $(".toggle-input");
    const warning_model = $("#warning-model");
    const select_all_button = $(".select-all");
    const generation_form = $("#generation-form");

    // Collection The Original State Function
    function collect_state() {
        for (let i = 0; i < toggle_state.length; i++) {
            state.push(toggle_state.eq(i).prop('checked'));
        }
    }

    collect_state();

    $('.DataTable').DataTable({

        ordering:  false,
        stateSave: true,
        lengthChange: false,
        info: false,
        dom: '<"html5buttons mb-20" B>Tfgitpl',
        buttons: [
            {
                text: 'حفظ التغيرات',
                className: "btn btn-success ",
                action: function ( e, dt, node, config ) {
                    show_model(e);
                }
            }
        ]
    });

    //
    select_all_button.click(function () {
        if ( input_state === 0 ){
            toggle_state.bootstrapToggle('on');
            select_all_button.text("إلغاء التحديد");
            input_state = 1;
        }else {
            toggle_state.bootstrapToggle('off');
            select_all_button.text("تحديد الكل");
            input_state = 0;
        }

    });

    toggle_state.on('change', function () {

        let value = $(this).prop('checked');
        if (value) {
            $(this).parent().next().val(1);
        } else {
            $(this).parent().next().val(0);
        }
    });

    function show_model(e){
        e.preventDefault();
        warning_model.modal("show");
    }

    $(document).on('click', '#agree-warning', function () {
        generation_form.submit();
    });

    // Listening To The Click Event On The Button To Cancel Saving The Changes
    $(document).on('click', '#cancel-warning', function () {
        // Hide The Alert Box Or Waring Box
        warning_model.modal("hide");

        // Compare The Original State To The New To Reset View As It Was
        for (let i = 0; i < state.length; i++) {
            let toggle = toggle_state.eq(i);
            if( state[i] === true && state[i] !== toggle.prop('checked') ){
                toggle.bootstrapToggle('on');
                toggle.parent().next().val(1);
            }else if( state[i] === false && state[i] !== toggle.prop('checked') ){
                toggle.bootstrapToggle('off');
                toggle.parent().next().val(0);
            }else{

            }
        }
    });

});