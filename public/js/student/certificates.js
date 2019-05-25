$(document).ready(function () {
    var search_state = 0;
    var courses_names = [];
    var centers_names = [];
    var certificates_dates = [];
    var certificates_links = [];
    var certificates_state = [];

    collect_courses_names();

    function collect_courses_names() {
        let element = $(".course-name");
        for (let i = 0; i < element.length; i++) {
            courses_names.push(element.text());

        }
    }

    collect_centers_names();

    function collect_centers_names() {
        let element = $(".center-name");
        for (let i = 0; i < element.length; i++) {
            centers_names.push(element.text());

        }
    }

    collect_certificates_dates();
    function collect_certificates_dates() {
        let element = $(".certificate-date");
        for (let i = 0; i < element.length; i++) {
            certificates_dates.push(element.text());

        }
    }

    collect_certificates_links();
    function collect_certificates_links() {
        let element = $(".certificate-link");
        for (let i = 0; i < element.length; i++) {
            certificates_links.push(element.attr('href'));

        }
    }

    collect_certificates_state();
    function collect_certificates_state() {
        let element = $(".certificate-link");
        for (let i = 0; i < element.length; i++) {
            certificates_state.push(element.attr('data-state'));
        }
    }


    $("input[name=key]").change(function () {
        let element = $(this);
        if ( element.val().length < 5 && search_state === 0){
            $("#serch_error").text("مفتاح البحث يجب ان لا يكون فارغ او اقل من خمسة احرف");
        }else if( element.val().length === 0 && search_state === 1){
            search_state = 0;
            $("#serch_error").text("");
            clear_tbody().then(function (result) {
                create_default_table();
            });
        } else {
            search_state = 1;
            $("#serch_error").text("");
            search_certificate(element.val());
        }
    });


    function search_certificate(key) {
        let result = courses_names.indexOf(key);
        if ( result === -1 ){
            clear_tbody().then(function (result) {
                create_empty_message();
            });
        }else {
            clear_tbody().then(function (promise_result) {
                create_result(result);
            });
        }
    }

    function clear_tbody() {
        return new Promise(function (resolve, reject) {
            $("#tbody").children().fadeOut("slow", function () {
                $(this).children().remove();
                resolve("done");
            });
        });
    }

    function create_empty_message() {
        $("#tbody").append("<tr> <td class='text-center text-danger' colspan='4'> الدورة غير موجودة حاول مجددا</td> </tr>");
    }

    function create_result(index) {
        if ( courses_names[index] !== null ){
            if ( parseInt(certificates_state[index]) === 0 ){
                $("#tbody").append("<tr>" +
                    "<td class='text-center'><a class='rounded-circle count-certificates w-35 h-35 pt-10' href='"+certificates_links[index]+"'>عرض</td>" +
                    "<td class='text-center pt-4'>"+certificates_dates[index]+"</td>" +
                    "<td class='text-center pt-4'>"+centers_names[index]+"</td>" +
                    "<td class='text-center pt-4'>"+courses_names[index]+"</td>" +
                    "</tr>"
                );
            }else{
                $("#tbody").append("<tr>" +
                    "<td class='text-center'><a href='"+certificates_links[index]+"'>عرض</td>" +
                    "<td class='text-center'>"+certificates_dates[index]+"</td>" +
                    "<td class='text-center'>"+centers_names[index]+"</td>" +
                    "<td class='text-center'>"+courses_names[index]+"</td>" +
                    "</tr>"
                );
            }
        }
    }

    function create_default_table() {
        for (let i = 0; i < courses_names.length; i++){

            if ( parseInt(certificates_state[i]) === 0 ){
                $("#tbody").append("<tr>" +
                    "<td class='text-center'><a class='rounded-circle count-certificates w-35 h-35 pt-10' href='"+certificates_links[i]+"'>عرض</td>" +
                    "<td class='text-center pt-4'>"+certificates_dates[i]+"</td>" +
                    "<td class='text-center pt-4'>"+centers_names[i]+"</td>" +
                    "<td class='text-center pt-4'>"+courses_names[i]+"</td>" +
                    "</tr>"
                );
            }else{
                $("#tbody").append("<tr>" +
                    "<td class='text-center'><a href='"+certificates_links[i]+"'>عرض</td>" +
                    "<td class='text-center'>"+certificates_dates[i]+"</td>" +
                    "<td class='text-center'>"+centers_names[i]+"</td>" +
                    "<td class='text-center'>"+courses_names[i]+"</td>" +
                    "</tr>"
                );
            }

        }
    }

});