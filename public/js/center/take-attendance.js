$(".toggle-input").bootstrapToggle({
    on: 'حاضر',
    off: 'غير حاضر',
    onstyle: 'success',
    offstyle: 'danger',
});
$(document).ready(function () {

    // Save The Original State In An Array To Compare To The New State
    const state = [];
    const toggle_input = $(".toggle-input");
    const warning_model = $("#warning-model");
    const attendance_form = $("#attendance-form");

    // Collection The Original State Function
    function collect_state() {
        for (let i = 0; i < toggle_input.length; i++) {
            state.push(toggle_input.eq(i).prop('checked'));
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

    toggle_input.on('change', function () {
        let value = $(this).prop('checked');
        if (value) {
            $(this).parent().next().val(1);
        } else {
            $(this).parent().next().val(0);
        }
    });



    // Listening To The Click Event On The Button To Save The Changes
    function show_model(e){
        e.preventDefault();
        warning_model.modal("show");
    }

    $(document).on('click', '#agree-warning', function () {
        attendance_form.submit();
    });

    // Listening To The Click Event On The Button To Cancel Saving The Changes
    $(document).on('click', '#cancel-warning', function () {
        toggle = $(".toggle-input");
        // Hide The Alert Box Or Waring Box
        warning_model.modal("hide");
        // Compare The Original State To The New To Reset View As It Was
        for (let i = 0; i < state.length; i++) {
            let toggle_state = toggle.eq(i);
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