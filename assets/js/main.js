/*

[Main Script]

Project: SSDCloud - Multipurpose Hosting with WHMCS and Technology Business Template
Version: 1.3
Author : themelooks.com

*/

;(function ($) {
    "use strict";
    
    /* ------------------------------------------------------------------------- *
     * COMMON VARIABLES
     * ------------------------------------------------------------------------- */
    var $wn = $(window),
        $body = $('body');
        
    /* ------------------------------------------------------------------------- *
     * Check Data
     * ------------------------------------------------------------------------- */
    var checkData = function (data, value) {
        return typeof data === 'undefined' ? value : data;
    };

    $(function () {
        /* ------------------------------------------------------------------------- *
         * OWL CAROUSEL
         * ------------------------------------------------------------------------- */
        var $owlCarousel = $('.owl-carousel');
        
        $owlCarousel.each(function () {
            var $t = $(this);
            
            $t.owlCarousel({
				autoWidth:true,
                items: checkData( $t.data('carousel-items'), 1 ),
                margin: checkData( $t.data('carousel-margin'), 1 ),
                loop: checkData( $t.data('carousel-loop'), true ),
                smartSpeed: 1200,
                autoplay: checkData( $t.data('carousel-autoplay'), false ),
                autoplayHoverPause: checkData( $t.data('carousel-hover-pause'), false ),
                nav: checkData( $t.data('carousel-nav'), true ),
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                dots: checkData( $t.data('carousel-dots'), false ),
                dotsContainer: checkData( $t.data('carousel-dots-container'), false ),
                responsive: checkData( $t.data('carousel-responsive'), {} )
            });
        });
        
        
    });
    
    $wn.on('load', function () {        
        /* ------------------------------------------------------------------------- *
         * PRELOADER
         * ------------------------------------------------------------------------- */
        var $preloader = $('#preloader');
        
        if ( $preloader.length ) {
            $preloader.fadeOut();
        }
    });
    
})(jQuery);
