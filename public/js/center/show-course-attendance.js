$(document).ready(function () {

    let state = 0;
    const reload_button = $(".icon-arrows-ccw");
    const tbody = $("tbody");
    const close_button = $("#close-button");
    const search_button = $("#search-button");
    const search_input = $("#key");
    const page_cover = $(".page-cover");
    const search_holder = $(".search-holder");
    const open_search_cover = $("a[data-rel=search]");

    const names = [];
    const students = [];

    const error_description = $("#error_description");
    const success_description = $("#success-description");

    const student_name = $(".student-name");
    const student_phone = $(".student-phone");
    const student_email = $(".student-email");
    const student_attendance = $(".student-attendance");
    const course_days = $(".course-days");
    const more_details = $(".more-details");

    collect_names();
    collect_students();

    open_search_cover.click(function (e) {
        e.preventDefault();
        if ( students.length > 1 ){
            show_cover();
            show_search_box();
        }
    });

    reload_button.click(function () {
        if ( state === 1 ){
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

    function collect_names() {
        for (let i = 0; i < student_name.length; i++) {
            names.push(student_name.eq(i).text());
        }
    }

    function collect_students() {
        for (let i = 0; i < student_name.length; i++) {
            let student = {
                "name": student_name.eq(i).text().trim(),
                "phone": student_phone.eq(i).text().trim(),
                "email": student_email.eq(i).text().trim(),
                "attendance": student_attendance.eq(i).text().trim(),
                "total": course_days.eq(i).text().trim(),
                'link': more_details.children().eq(i).attr('href').trim(),
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
        state = 1;
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
            error_description.text("الحد الاأقصى للحروف هو ٣٠, الحد الأدني ٥");
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

                row.append("<td class='student-name'>"+student.name+"</td>");
                row.append("<td class='student-phone ltr'>"+student.phone+"</td>");
                row.append("<td class='student-email'>"+student.email+"</td>");
                row.append("<td class='student-attendance'>"+student.attendance+"</td>");
                row.append("<td class='course-days'>"+student.total+"</td>");
                row.append("<td class='more-details'>"+student.link+"</td>");

                row.removeAttr("id");
            }
        }
    }

    function create_empty_row() {
        success_description.text("");
        error_description.text("الرجاء التأكد من اسم الطالب");
        tbody.append("<tr><td class='text-center text-danger' colspan='11'>الرجاء التأكد من اسم الطالب</td></tr>");
    }

    function create_default_rows() {
        state = 0;
        for (let i = 0; i < students.length; i++){

            let student = students[i];
            tbody.append("<tr id='result_row'></tr>");
            let row = $("#result_row");

            row.append("<td class='student-name'>"+student.name+"</td>");
            row.append("<td class='student-phone ltr'>"+student.phone+"</td>");
            row.append("<td class='student-email'>"+student.email+"</td>");
            row.append("<td class='student-attendance'>"+student.attendance+"</td>");
            row.append("<td class='course-days'>"+student.total+"</td>");
            row.append("<td class='more-details'>"+student.link+"</td>");

            row.removeAttr("id");
        }
    }
});