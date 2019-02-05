$(document).ready(function(){
    var subscribeCategoriesDefoult = $('#newsletterCatigoriesSelected').text();
    var subscribeCitiesDefoult = $('#newsletterCitiesSelectedDefoult').text();
    $('.save-subscribe-categories').click(function(){
        $('#newsletterCatigoriesModal').modal('hide');
    });
    $('#newsletterCatigoriesModal').on('hidden.bs.modal', function (e) {
         var subscribeCategories = '';
        if($('.subscribe-categories:checked').length == $('.subscribe-categories').length){
            subscribeCategories = subscribeCategoriesDefoult;
        }else{
            $('.subscribe-categories:checked').each(function(){
                subscribeCategories += $(this).data('name')+', ';
            });
            subscribeCategories = subscribeCategories.slice(0, -2);
        }
        $('.newsletterCatigoriesSelected').text(subscribeCategories);
    });
    $('.save-subscribe-cities').click(function(){
        $('#newsletterCitiesModal').modal('hide');
    });
    $('#newsletterCitiesModal').on('hidden.bs.modal', function (e) {
        var subscribeCities = '';
        $('#newsletterCitiesModal').modal('hide');
        if($('.subscribe-cities:checked').length == $('.subscribe-cities').length){
            subscribeCities = subscribeCitiesDefoult;
        }else{
            $('.subscribe-cities:checked').each(function(){
                subscribeCities += $(this).data('name')+', ';
            });
            subscribeCities = subscribeCities.slice(0, -2);
        }
        $('.newsletterCitiesSelected').text(subscribeCities);
    })

    
    $('.sidebar-newsletter-form, .footer-newsletter-form').submit(function(e){
        e.preventDefault();
        var email = $(this).find('input[name="newsletterEmail"]').val();
        var newsletterCities = new Array();
        var newsletterCatigories = new Array();
        $("input[name='subscribeCategories[]']:checked").each(function(){
            newsletterCatigories.push($(this).val());
        });
        $("input[name='subscribeCities[]']:checked").each(function(){
            newsletterCities.push($(this).val());
        });
        var form = $(this);
        $.post(
            baseUrlForFooter+'home/saveNewsletter',
            {newsletterEmail: email, newsletterCatigories: newsletterCatigories, newsletterCities: newsletterCities},
            function(data){
                if(data.error){
                    form.find('.newsletterResponse').removeClass('newsletter-success').text(data.error).show();
                }else if(data.success){
                    //form.find('.newsletterResponse').addClass('newsletter-success').text(data.success).show();
                    form.parents('.newsletter-first-block').html('<span class="newsletter-success-message"><i class="fa fa-check"></i>&nbsp;&nbsp;'+data.success+'</span>');
                }
            },
            'json'
        );
    });
    
    $('#subscribeCitiesAll').change(function(){
        if($(this).prop('checked')){
            $('.subscribe-cities').prop('checked', true);
        }else{
            $('.subscribe-cities').prop('checked', false);
        }
    });
    $('#subscribeCategoriesAll').change(function(){
        if($(this).prop('checked')){
            $('.subscribe-categories').prop('checked', true);
        }else{
            $('.subscribe-categories').prop('checked', false);
        }
    });
    $('.subscribe-cities').change(function(){
        if($('.subscribe-cities:checked').length == $('.subscribe-cities').length){
            $('#subscribeCitiesAll').prop('checked', true);
        }else{
            $('#subscribeCitiesAll').prop('checked', false);
        }
    });
    $('.subscribe-categories').change(function(){
        if($('.subscribe-categories:checked').length == $('.subscribe-categories').length){
            $('#subscribeCategoriesAll').prop('checked', true);
        }else{
            $('#subscribeCategoriesAll').prop('checked', false);
        }
    });
});