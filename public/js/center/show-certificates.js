$(document).ready(function () {

    $('.DataTable').DataTable({

        ordering:  false,
        stateSave: true,
        lengthChange: false,
        info: false,
        dom: '<"html5buttons mb-20" B>Tfgitpl',
        buttons: [
            {
                text: 'اكسل',
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                text: 'تنزيل الشهادات',
                action: function ( e, dt, node, config ) {
                    alert( 'Button activated' );
                }
            }
        ]
    });


    let input_state = 0;
    const select_all_button = $(".select-all");
    const download_button = $("#download-button");
    const check_input = $("input[name='certificate[]']");
    //
    select_all_button.click(function () {
        if ( input_state === 0 ){
            for (let i = 0; i < check_input.length; i++){
                check_input.eq(i).prop('checked', true);
                check_input.eq(i).val(1);
            }

            download_button.prop('disabled', false);
            select_all_button.text("إلغاء التحديد");

            input_state = 1;
        }else {
            for (let i = 0; i < check_input.length; i++){
                check_input.eq(i).prop('checked', false);
                check_input.eq(i).val(0);
            }

            download_button.prop('disabled', true);
            select_all_button.text("تحديد الكل");

            input_state = 0;
        }

    });
    //
    //
    //
    //
    // let state = 0;
    // const reload_button = $(".icon-arrows-ccw");
    // const tbody = $("tbody");
    // const close_button = $("#close-button");
    // const search_button = $("#search-button");
    // const search_input = $("#key");
    // const page_cover = $(".page-cover");
    // const search_holder = $(".search-holder");
    // const open_search_cover = $("a[data-rel=search]");
    //
    // const names = [];
    // const students = [];
    //
    // const error_description = $("#error_description");
    // const success_description = $("#success-description");
    //
    //
    // const student_name = $(".student-name");
    // const student_phone = $(".student-phone");
    // const student_email = $(".student-email");
    // const student_city = $(".student-city");
    // const student_gender = $(".student-gender");
    // const student_attendance = $(".student-attendance");
    // const issue_date = $(".issue-date");
    // const admin_name = $(".admin-name");
    // const download_state = $(".download-state");
    // const course_days = $("input[name=course-days]");
    //
    // collect_names();
    // collect_students();
    //
    // open_search_cover.click(function (e) {
    //     e.preventDefault();
    //     if ( students.length > 0 ){
    //         show_cover();
    //         show_search_box();
    //     }
    // });
    //
    // reload_button.click(function () {
    //     if ( state === 1 ){
    //         clear_tbody().then(function (result) {
    //             create_default_rows();
    //         });
    //     }
    // });
    //
    // close_button.click(function () {
    //     hide_cover();
    // });
    //
    //
    // search_button.click(function () {
    //     search(search_input.val());
    // });
    //
    // function collect_names() {
    //     for (let i = 0; i < student_name.length; i++) {
    //         names.push(student_name.eq(i).text().trim());
    //     }
    // }
    //
    // function collect_students() {
    //     for (let i = 0; i < student_name.length; i++) {
    //         let student = {
    //             "name": student_name.eq(i).text().trim(),
    //             "phone": student_phone.eq(i).text().trim(),
    //             "email": student_email.eq(i).text().trim(),
    //             "city": student_city.eq(i).text().trim(),
    //             "gender": student_gender.eq(i).text().trim(),
    //             "date": issue_date.eq(i).text().trim(),
    //             'attendance': student_attendance.eq(i).text().trim(),
    //             'admin': admin_name.eq(i).text().trim(),
    //             'days': course_days.eq(i).text().trim(),
    //             'state': download_state.children().eq(i).val(),
    //         };
    //         students.push(student);
    //     }
    // }
    //
    // function validate_key(key) {
    //     if (key.length >= 2 && key.length <= 30) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
    //
    // function search(key) {
    //     state = 1;
    //     let result_array = [];
    //     key = key.trim();
    //
    //     if (validate_key(key)) {
    //         search_input.removeClass("is-invalid");
    //         error_description.text("");
    //         for (let i = 0; i < names.length; i++){
    //
    //             let name = names[i];
    //             let state = name.startsWith(key);
    //             if ( state ){
    //                 result_array.push(i);
    //             }
    //         }
    //
    //         if ( result_array.length > 0 ){
    //             clear_tbody().then(function (result) {
    //                 create_result_row(result_array);
    //             });
    //         }else{
    //             clear_tbody().then(function (result) {
    //                 create_empty_row();
    //             });
    //         }
    //     }else {
    //         search_input.addClass("is-invalid");
    //         success_description.text("");
    //         error_description.text("الحد الاأقصى للحروف هو ٣٠, الحد الأدني ٥");
    //     }
    // }
    //
    // function show_cover() {
    //     page_cover.fadeIn('slow', function () {
    //
    //     });
    // }
    //
    // function hide_cover() {
    //     page_cover.fadeOut('slow', function () {
    //         search_input.val("");
    //     });
    // }
    //
    // function show_search_box() {
    //     search_holder.fadeIn("slow", function () {
    //
    //     });
    // }
    //
    // function clear_tbody() {
    //     return new Promise(function (resolve, reject) {
    //         tbody.children().fadeOut("slow", function () {
    //             tbody.children().remove();
    //             resolve("Done");
    //         });
    //     });
    // }
    //
    // function create_result_row(result) {
    //     error_description.text("");
    //
    //     if ( result.length > 0 && result.length <= names.length ){
    //         success_description.text("تم العثور على تطابق");
    //
    //         for (let i = 0; i < result.length; i++){
    //             let student = students[result[i]];
    //
    //             tbody.append("<tr id='result_row'></tr>");
    //             let row = $("#result_row");
    //
    //             row.append("<td class='student-name'>"+student.name+"</td>");
    //             row.append("<td class='student-phone ltr'>"+student.phone+"</td>");
    //             row.append("<td class='student-email'>"+student.email+"</td>");
    //             row.append("<td class='student-city'>"+student.city+"</td>");
    //             row.append("<td class='course-gender'>"+student.gender+"</td>");
    //             row.append("<td class='issue-date'>"+student.date+"</td>");
    //             row.append("<td class='admin-name'>"+student.admin+"</td>");
    //
    //
    //             if ( student.attendance === student.days  ){
    //                 row.append("<td class='student-attendance bg-success text-success'>"+student.attendance+"</td>");
    //             }else {
    //                 row.append("<td class='student-attendance bg-danger text-danger'>"+student.attendance+"</td>");
    //             }
    //
    //             alert(student.state);
    //
    //             if ( student.state === 1 ){
    //                 row.append("<td class='download-state'> <input type='checkbox' name='certificate[]' value='1' checked> </td>");
    //             }else{
    //                 row.append("<td class='download-state'> <input type='checkbox' name='certificate[]' value='0'> </td>");
    //             }
    //
    //             row.removeAttr("id");
    //         }
    //     }
    // }
    //
    // function create_empty_row() {
    //     success_description.text("");
    //     error_description.text("الرجاء التأكد من اسم الطالب");
    //     tbody.append("<tr><td class='text-center text-danger' colspan='11'>الرجاء التأكد من اسم الطالب</td></tr>");
    // }
    //
    // function create_default_rows() {
    //     state = 0;
    //     for (let i = 0; i < students.length; i++){
    //
    //         let student = students[i];
    //         tbody.append("<tr id='result_row'></tr>");
    //         let row = $("#result_row");
    //
    //         row.append("<td class='student-name'>"+student.name+"</td>");
    //         row.append("<td class='student-phone ltr'>"+student.phone+"</td>");
    //         row.append("<td class='student-email'>"+student.email+"</td>");
    //         row.append("<td class='student-city'>"+student.attendance+"</td>");
    //         row.append("<td class='course-gender'>"+student.total+"</td>");
    //         row.append("<td class='issue-date'>"+student.link+"</td>");
    //         row.append("<td class='admin-name'>"+student.link+"</td>");
    //         row.append("<td class='issue-date'>"+student.link+"</td>");
    //
    //         if ( student.attendance === student.days  ){
    //             row.append("<td class='student-attendance bg-success text-success'>"+student.link+"</td>");
    //         }else {
    //             row.append("<td class='student-attendance bg-danger text-danger'>"+student.link+"</td>");
    //         }
    //
    //         row.append("<td class='download-state'> <a href='"+student.state+"'>"+student.state+"</a> </td>");
    //
    //         row.removeAttr("id");
    //     }
    // }

});