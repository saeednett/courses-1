$(document).ready(function() {
    if(lang == 'ar'){
        var front_modal_error = 'الرقم السري غير صحيح';
    } else {
        var front_modal_error = 'Invalid password';
    }
    fuckAdBlock.onDetected(function() {
        $.ajax({
            type: 'POST',
            url: base_url+"home/get_adblocker_modal",
            dataType: "json",
            data: {},
            success: function(data) {
                if (data.modal) {
                    $('.modal-wrap').html(data.modal)
                    $('.modal-adblock').modal('show');
                }
            }
        });
    });
    fuckAdBlock.check();

    $('#post-slider').carousel();
    $('.nav-tabs li a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    $('.nav-tabs li a').on('show.bs.tab', function(e) {
        $('#loaderHome').show();
    });
    $('.nav-tabs li a').on('shown.bs.tab', function(e) {
        $('#loaderHome').hide();
    });
    $.smartbanner({button: "INSTALL"});

    $('#privateModal').on('shown.bs.modal', function(){
        $('#privatePass').focus();
    });

    if (postsPrivecyId){
        $('#privatePost').val($('.private-activity[data-post='+postsPrivecyId+']').data('post'));
        $('#privateUrl').val($('.private-activity[data-post='+postsPrivecyId+']').attr('href'));
        $('#privateModal').modal();
    }
    $('.tab-content').on('click', '.private-activity', function(e) {
        e.preventDefault();
        $('#privatePost').val($(this).data('post'));
        $('#privateUrl').val($(this).attr('href'));
        $('#privateModal').modal();
    });
    $('#privateModal').on('hidden.bs.modal', function(e) {
        $('#privatePost').val('');
        $('#privateUrl').val('');
        $('#privatePass').val('');
        $('#privateModal .form-group').removeClass('has-error');
        $('#privateModal .help-block').text('');
    });
    $('#privateModal form').submit(function(e) {
        e.preventDefault();
        $.post(
            base_url+'post/chackPassword',
            {pass: $('#privatePass').val(), post: $('#privatePost').val()},
            function(response) {
                if (response.error === false){
                    console.log($('#privateUrl').val());
                    window.location = $('#privateUrl').val();
                } else {
                    $('#privateModal .help-block').text(front_modal_error)
                    $('#privateModal .form-group').addClass('has-error');
                }
            },
            'json'
        );
    });

    $('#header-slider .item').click(function() {
        window.location = $(this).data('href');
    });
    $(".royalSlider").royalSlider({
        keyboardNavEnabled: true,
        imageScaleMode:'fill',
        loopRewind:true,
        loop:true,
        autoPlay: {
            enabled: true,
            pauseOnHover: true,
            delay:6000
    	}
    }); 
    
});
function resizeHomeImg(){
var height = $('.new-header .front-menu-nav').height();
        var width = $(window).width();
        if (width > 992){
if (height > 307){
$('.new-header .front-head').height(height);
        $('#post-slider').height(height);
        $('#post-slider .item, #post-slider .item > img').height(height);
        $('#post-slider .item, #post-slider .item > img').css('width', 'auto');
        $('#post-slider .item, #post-slider .item > img').css('max-width', 'none');
}
} else {
$('#post-slider .item > img').css('height', 'auto');
        $('#post-slider .item, #post-slider .item > img').css('width', '100%');
        $('#post-slider .item, #post-slider .item > img').css('max-width', 'none');
}
}