$(document).ready(function () {

    $('.carousel').carousel();

    $('.preview').on('click', function (e) {
        e.preventDefault();
        $("#warning-model").modal("show");
    });

});