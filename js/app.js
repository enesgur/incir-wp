// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$(document).foundation();
$(document).ready(function ($) {

    //$('.home-page.style-1 div.column').homeStyle();
    //$('.home-page.style-1 div.column').homeStyle();

    $('div.search span').on('click', function () {
        $(this).parent().find('input').width($(this).parent().width() / 1.5).focus().css('padding-left', '5px');
    });

    $('div.search input').focusout(function () {
        $(this).val('').css({width: '0', paddingLeft: '0'});
    });

    var id;
    $(window).resize(function () {
        if (isSmall() == false && $('body').hasClass('home-1')) {
            clearTimeout(id);
            id = setTimeout($('.home-page.style-1 div.column').homeStyle(), 1000);
            $('.home-page.style-1').sectionSize(false);
        }

        if (isSmall() == true) {
            clearTimeout(id);
            id = setTimeout($('.home-page.style-1').css('height', 'auto'), 1000);

        }
    });
    $(window).load(function () {
        if (isSmall() == false && $('body').hasClass('home-1')) {
            $('.home-page.style-1 div.column').homeStyle();
            $('.home-page.style-1').sectionSize(true);
        }

        if(isSmall() == true && $('body').hasClass('home-1')) {
            $('.loader').fadeOut(function () {
                $('section > div.row').hide();
                $('section > div.row').css('visibility', 'visible');
                $('section > div.row').fadeIn();
            });
        }
    });
    $('section article div.content p:has(img.aligncenter)').css('text-align', 'center');

    $('div.social a').click(function(e){
        e.preventDefault();
        javascript:window.open($(this).attr('href'),'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
    });
});
