$(document).ready(function () {

    let state = 0;
    const reload_button = $(".icon-arrows-ccw");
    const tbody = $("tbody");
    const names = [];
    const courses = [];
    const error_description = $("#error_description");
    const success_description = $("#success_description");
    const titles = $(".course_title");
    const open_search_cover = $("a[data-rel=search]");
    const page_cover = $(".body_cover");
    const search_holder = $(".search_holder");
    const close_button = $("#close_button");
    const search_button = $("#search_button");
    const search_input = $("#key");
    const course_date = $(".course_date");
    const course_attendance = $(".course_attendance");
    const course_reservation = $(".course_reservation");
    const course_days = $(".course_days");
    const course_gender = $(".course_gender");
    const course_trainer = $(".course_trainer");
    const course_city = $(".course_city");
    const course_validation = $(".course_validation");
    const course_edit = $(".course_edit");
    const course_view = $(".course_view");

    collect_names();
    collect_courses();

    open_search_cover.click(function (e) {
        e.preventDefault();
        if ( courses.length > 0 ){
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
        for (let i = 0; i < titles.length; i++) {
            names.push(titles.eq(i).text());
        }
    }

    function collect_courses() {
        for (let i = 0; i < titles.length; i++) {
            let course = {
                "title": titles.eq(i).text().trim(),
                "date": course_date.eq(i).text().trim(),
                "attendance": course_attendance.eq(i).text().trim(),
                "reservation": course_reservation.eq(i).text().trim(),
                "days": course_days.eq(i).text().trim(),
                'gender': course_gender.eq(i).text().trim(),
                "trainer": course_trainer.eq(i).text().trim(),
                "city": course_city.eq(i).text().trim(),
                "validation": course_validation.eq(i).text().trim(),
                "edit": course_edit.children().eq(0).attr("href").trim(),
                'view': course_view.children().eq(0).attr("href").trim(),
            };
            courses.push(course);
        }
    }

    function validate_key(key) {
        if (key.length >= 5 && key.length <= 30) {
            return true;
        } else {
            return false;
        }
    }

    function search(key) {
        state = 1;
        key = key.trim();
        if (validate_key(key)) {
            search_input.removeClass("is-invalid");
            error_description.text("");
            let position = names.indexOf(key);
            if (position === -1) {
                clear_tbody().then(function (result) {
                    create_empty_row();
                });
            } else {
                clear_tbody().then(function (result) {
                    create_one_row(position);
                });
            }
        } else {
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

    function create_one_row(position) {
        error_description.text("");

        if ( position <= courses.length && position !== -1 ){
            success_description.text("تم العثور على تطابق");

            let edit = "تعديل";
            let view = "عرض";
            let course = courses[position];
            tbody.append("<tr id='result_row'></tr>");
            let row = $("#result_row");
            row.append("<td class='course_title'>"+course.title+"</td>");
            row.append("<td class='course_date'>"+course.date+"</td>");
            row.append("<td class='course_attendance'>"+course.attendance+"</td>");
            row.append("<td class='course_reservation'>"+course.reservation+"</td>");
            row.append("<td class='course_days'>"+course.days+"</td>");
            row.append("<td class='course_gender'>"+course.gender+"</td>");
            row.append("<td class='course_trainer'>"+course.trainer+"</td>");
            row.append("<td class='course_city'>"+course.city+"</td>");

            if (course.validation === "مؤكدة"){
                row.append("<td class='course_validation text-success'>"+course.validation+"</td>");
            }else{
                row.append("<td class='course_validation text-danger'>"+course.validation+"</td>");
            }

            row.append("<td class='course_edit'><a href='"+course.edit+"'>"+edit+"</a></td>");
            row.append("<td class='course_view'><a href='"+course.view+"'>"+view+"</a></td>");

            row.removeAttr("id");
        }
    }

    function create_empty_row() {
        success_description.text("");
        error_description.text("الرجاء التأكد من اسم الدورة");
        tbody.append("<tr><td class='text-center text-danger' colspan='11'>الرجاء التأكد من اسم الدورة</td></tr>");
    }
    
    function create_default_rows() {
        state = 0;
        for (let i = 0; i < names.length; i++){

            let edit = "تعديل";
            let view = "عرض";
            let course = courses[i];

            tbody.append("<tr id='result_row'></tr>");

            let row = $("#result_row");

            row.append("<td class='course_title'>"+course.title+"</td>");
            row.append("<td class='course_date'>"+course.date+"</td>");
            row.append("<td class='course_attendance'>"+course.attendance+"</td>");
            row.append("<td class='course_reservation'>"+course.reservation+"</td>");
            row.append("<td class='course_days'>"+course.days+"</td>");
            row.append("<td class='course_gender'>"+course.gender+"</td>");
            row.append("<td class='course_trainer'>"+course.trainer+"</td>");
            row.append("<td class='course_city'>"+course.city+"</td>");

            if (course.validation === "مؤكدة"){
                row.append("<td class='course_validation text-success'>"+course.validation+"</td>");
            }else{
                row.append("<td class='course_validation text-danger'>"+course.validation+"</td>");
            }

            row.append("<td class='course_edit'><a href='"+course.edit+"'>"+edit+"</a></td>");
            row.append("<td class='course_view'><a href='"+course.view+"'>"+view+"</a></td>");

            row.removeAttr("id");
        }
    }
});