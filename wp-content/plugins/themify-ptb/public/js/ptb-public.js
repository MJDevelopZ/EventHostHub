(function ($) {
    'use strict';
    $(window).load(function () {
         var $container = $('.ptb_post .ptb_items_wrapper');
          if ($container.length > 0) {		
            var $loop = $('.ptb_loops_wrapper').length > 0;		
             $container.each(function () {		
                 if ($(this).closest('.ptb_loops_shortcode').length === 0) {		
                    var $post = $(this).closest('.ptb_post');		
                    $post.html($(this));		
                    if ($loop) {		
                        $post.closest('.ptb_loops_wrapper').append($post);		
                   }		
                }		
           });		
            if ($loop) {		
                $('.ptb_loops_wrapper>*').not('.ptb_post').remove();		
            }		
        }		
        $('.ptb_loops_wrapper,.ptb_pagenav,.ptb_single .ptb_post,.ptb_category_wrapper').css('display', 'block');		
        $.event.trigger({type: "ptb_loaded"});

        //Single Page Lightbox
        $('a.ptb_open_lightbox').lightcase({
            type: 'ajax',
            maxWidth: $(window).width() * 0.8,
            onFinish: {
                baz: function () {
                    $('#lightcase-case').addClass('ptb_is_single_lightbox');
                    $('.ptb_post img').css('display', 'block');
                    $.event.trigger({type: "ptb_loaded"});
                }
            }
        });

        //Page Lightbox
        $('a.ptb_lightbox').lightcase({
            type: 'iframe'
        });

        //Isotop Filter
        var $filter = $('.ptb-post-filter');
        if ($filter.length > 0) {
            $filter.on('click', 'li', function (e) {
                e.preventDefault();
                var $filter_class = '';
                var $entity = $filter.next();
                if ($(this).hasClass('active')) {
                    $filter.find('li.active').removeClass('active');
                    $filter_class = '.ptb_post';
                    $entity.removeClass('ptb-isotop-filter')
                }
                else {
                    $filter_class = '.ptb-tax-' + $(this).data('tax');
                    $filter.find('li.active').removeClass('active');
                    $(this).addClass('active');
                    $entity.addClass('ptb-isotop-filter');
                }
                $entity.isotope({filter: $filter_class});
            });
        }
    });
}(jQuery));