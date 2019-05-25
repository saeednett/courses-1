$(".toggle-input").bootstrapToggle({
    on: 'مؤكد',
    off: 'غير مؤكد',
    onstyle: 'success',
    offstyle: 'danger',
});
$(document).ready(function () {

    let search_state = 1;
    const tbody = $("tbody");
    const page_cover = $(".page-cover");
    const search_holder = $(".search-holder");
    const names = [];
    const students = [];

    const student_name = $(".student-name");
    const course_date = $(".course-date");
    const account_owner = $(".account-owner");
    const account_number = $(".account-number");
    const course_discount = $(".course-discount");
    const course_total = $(".course-total");
    const course_confirmation = $(".course-confirmation");
    const course_identifier = $(".course-identifier");

    const note_holder = $('#editing-note');
    const agree = $('#agree');
    const confirmation_form = $("#confirmation-form");
    let toggle = $('.toggle-input');
    const warning_model = $("#warning-model");
    const save_button = $("#confirmation-form-save-changes");
    const check_input = $("input[type=checkbox]");
    const open_search_cover = $("a[data-rel=search]");
    const reload_button = $("a[data-rel=reload]");
    const close_button = $("#close-button");
    const search_button = $("#search-button");
    const search_input = $("#key");
    const error_description = $("#error-description");
    const success_description = $("#success-description");
    // Save The Original State In An Array To Compare To The New State
    const state = [];

    collect_names();
    collect_students();

    open_search_cover.click(function (e) {
        e.preventDefault();
        if ( students.length > 0 ){
            show_cover();
            show_search_box();
        }
    });

    reload_button.click(function () {
        if ( search_state === 1 ){
            clear_tbody().then(function (result) {
                create_default_rows();
            });
        }
    });

    close_button.click(function () {
        hide_cover();
    });


    search_button.click(function () {
        search(search_input.val());
    });

    function refresh_toggle() {
        $(".toggle-input").bootstrapToggle({
            on: 'مؤكد',
            off: 'غير مؤكد',
            onstyle: 'success',
            offstyle: 'danger',
        });
    }

    function collect_names() {
        for (let i = 0; i < student_name.length; i++) {
            names.push(student_name.eq(i).text().trim());
        }
    }

    function collect_students() {
        for (let i = 0; i < student_name.length; i++) {
            let student = {
                "name": student_name.eq(i).text().trim(),
                "date": course_date.eq(i).text().trim(),
                "account_owner": account_owner.eq(i).text().trim(),
                "account_number": account_number.eq(i).text().trim(),
                "discount": course_discount.eq(i).text().trim(),
                'total': course_total.eq(i).text().trim(),
                "confirmation": course_confirmation.eq(i).prop('checked'),
                "identifier": course_identifier.eq(i).text().trim(),
            };
            students.push(student);
        }
    }

    function validate_key(key) {
        if (key.length >= 2 && key.length <= 30) {
            return true;
        } else {
            return false;
        }
    }

    function search(key) {
        search_state = 1;
        let result_array = [];
        key = key.trim();

        if (validate_key(key)) {
            search_input.removeClass("is-invalid");
            error_description.text("");
            for (let i = 0; i < names.length; i++){

                let name = names[i];
                let state = name.startsWith(key);
                if ( state ){
                    result_array.push(i);
                }
            }

            if ( result_array.length > 0 ){
                clear_tbody().then(function (result) {
                    create_result_row(result_array);
                });
            }else{
                clear_tbody().then(function (result) {
                    create_empty_row();
                });
            }
        }else {
            search_input.addClass("is-invalid");
            success_description.text("");
            error_description.text("الحد الاأقصى للحروف هو ٣٠, الحد الأدني ٢");
        }
    }

    function show_cover() {
        page_cover.fadeIn('slow', function () {

        });
    }

    function hide_cover() {
        page_cover.fadeOut('slow', function () {
            search_input.val("");
        });
    }

    function show_search_box() {
        search_holder.fadeIn("slow", function () {

        });
    }

    function clear_tbody() {
        return new Promise(function (resolve, reject) {
            tbody.children().fadeOut("slow", function () {
                tbody.children().remove();
                resolve("Done");
            });
        });
    }

    function create_result_row(result) {
        error_description.text("");

        if ( result.length > 0 && result.length <= names.length ){
            success_description.text("تم العثور على تطابق");

            for (let i = 0; i < result.length; i++){
                let student = students[result[i]];

                tbody.append("<tr id='result_row'></tr>");
                let row = $("#result_row");

                row.append("<td class='student-name pt-17'>"+student.name+"</td>");
                row.append("<td class='course-date pt-17'>"+student.date+"</td>");
                row.append("<td class='account-owner pt-17'>"+student.account_owner+"</td>");
                row.append("<td class='account-number pt-17'>"+student.account_number+"</td>");
                if ( student.discount ==="لايوجد" ){
                    row.append("<td class='course-discount text-danger pt-17'>"+student.discount+"</td>");
                }else {
                    row.append("<td class='course-discount text-success pt-17'>"+student.discount+"</td>");
                }
                row.append("<td class='course-total pt-17'>"+student.total+"</td>");

                if (student.confirmation === true){
                    row.append("<td class='course-confirmation'> <input type='checkbox' data-toggle='toggle' class='toggle-input course-confirmation' checked> <input type='hidden' name='payment[]' value='1' required> <input type='hidden' name='identifier[]' value='"+student.identifier+"' required> </td>");
                }else{
                    row.append("<td class='course-confirmation'> <input type='checkbox' data-toggle='toggle' class='toggle-input course-confirmation'> <input type='hidden' name='payment[]' value='0' required> <input type='hidden' name='identifier[]' value='"+student.identifier+"' required> </td>");
                }

                row.removeAttr("id");
            }
            refresh_toggle();
            refresh_toggle_listener();
        }
    }

    function refresh_toggle_listener(){
        $(document).on('change','.toggle-input', function () {
            let value = $(this).prop('checked');
            if (value) {
                $(this).parent().next().val(1);
            } else {
                $(this).parent().next().val(0);
            }
        });
    }

    function create_empty_row() {
        success_description.text("");
        error_description.text("الرجاء التأكد من اسم الطالب");
        tbody.append("<tr><td class='text-center text-danger' colspan='11'>الرجاء التأكد من اسم الطالب</td></tr>");
    }


    function create_default_rows() {
        search_state = 0;
        for (let i = 0; i < students.length; i++){

            let student = students[i];

            tbody.append("<tr id='result_row'></tr>");
            let row = $("#result_row");

            row.append("<td class='student-name pt-17'>"+student.name+"</td>");
            row.append("<td class='course-date pt-17'>"+student.date+"</td>");
            row.append("<td class='account-owner pt-17'>"+student.account_owner+"</td>");
            row.append("<td class='account-number pt-17'>"+student.account_number+"</td>");

            if ( student.discount ==="لايوجد" ){
                row.append("<td class='course-discount text-danger pt-17'>"+student.discount+"</td>");
            }else {
                row.append("<td class='course-discount text-success pt-17'>"+student.discount+"</td>");
            }
            row.append("<td class='course-total pt-17'>"+student.total+"</td>");

            if (student.confirmation === true){
                row.append("<td class='course-confirmation'> <input type='checkbox' data-toggle='toggle' class='toggle-input course-confirmation' checked> <input type='hidden' name='payment[]' value='1' required> <input type='hidden' name='identifier[]' value='"+student.identifier+"' required> </td>");
            }else{
                row.append("<td class='course-confirmation'> <input type='checkbox' data-toggle='toggle' class='toggle-input course-confirmation'> <input type='hidden' name='payment[]' value='0' required> <input type='hidden' name='identifier[]' value='"+student.identifier+"' required> </td>");
            }

            row.removeAttr("id");
        }
        refresh_toggle();
        refresh_toggle_listener();
    }

    agree.on('click', function () {
        note_holder.fadeOut('slow', function () {
            $(this).remove();
        });
    });

    // Collection The Original State Function
    function get_state() {
        for (let i = 0; i < toggle.length; i++) {
            state.push(toggle.eq(i).prop('checked'));
        }
    }

    // Calling The Function To Start Collection
    get_state();

    // Listening To The Change On CheckBox Or Input Toggle
    check_input.on('change', function () {

        let value = $(this).prop('checked');
        if (value) {
            $(this).parent().next().val(1);
        } else {
            $(this).parent().next().val(0);
        }
    });

    // Listening To The Click Event On The Button To Save The Changes
    save_button.click(function (e) {
        e.preventDefault();
        warning_model.modal("show");
    });

    $(document).on('click', '#agree-warning', function () {
        confirmation_form.submit();
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