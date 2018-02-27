(function($) {
    "use strict";
    // window scroll function

    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    // scroll top click function
    $('.scrollup').on('click', function() {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    // left  sidebar close function
    $('.library-menu').on('click', function(e) {
        $(this).toggleClass("active");
        $('body').toggleClass('page-sidebar-closed');
        e.preventDefault();
    });

    // left sidebar togal
    $('.nav-link').on('click', function() {
        if ($(this).parent("li").hasClass('open')) {
            $(this).parent("li").removeClass('open');
        } else {
            $('.nav-item').removeClass('open');
            $(this).parents("li").addClass('open');
        }
    });

    

    $('.menu-toggler.sidebar-toggler').on('click', function() {
        $('body').toggleClass('page-sidebar-closed');
    });

    // apply slimScroll 
    var scrollH = $(window).height();
    $('#right-sidebar .tab-content').slimScroll({
        height: scrollH - 45
    });

    $('.page-sidebar-fixed .page-sidebar-menu').slimScroll({
        height: scrollH - 45
    });

    // sidebar search click
    $('.sidebar-search .submit, .sidebar-search .remove').on('click', function() {
        if ($('body').hasClass('page-sidebar-closed')) {
            $('.sidebar-search').toggleClass('open');
        }
    });

    // ibox tools close button 
    $('.ibox-tools .close-link').on('click', function() {
        $(this).parents(".ibox").hide();
    });

    // apply tooltip
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    // header expanded on click
    $(".search-form .input-group .form-control").focus(function() {
            $(".page-header.navbar .search-form.search-form-expanded").addClass("open");
        })
        .focusout(function() {
            $(".page-header.navbar .search-form.search-form-expanded").removeClass("open");
        });

})(jQuery);

// window resize
$(window).resize(function() {
    var scrollH = $(window).height();

    $('#right-sidebar .tab-content').slimScroll({
        height: scrollH - 45
    });
    $('.page-sidebar-fixed .page-sidebar-menu').slimScroll({
        height: scrollH - 45
    });

});

function mostrarAlerta(clase, titulo, mensaje){
    var html='<div class="alert alert-'+clase+' alert-message">'
                +'<strong>'+titulo+'!</strong> '+mensaje
                +'<i class="fa fa-close close-alert"></i>'
              +'</div>';

    $('.top-menu').append(html);
    setTimeout(function(){
        $('.alert-message').remove();
    },5000);
}

function numberFormat(number, decimals = 0, dec_point = '.', thousands_sep = '.') {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}