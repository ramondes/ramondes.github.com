(function ($) {
  jQuery(document).bind('mousedown',function() {
    $('.view-display-id-block_1 .next').click(function(e) {
      e.preventDefault();
      $('.view-display-id-block_1 .pager-next a').get(0).click();
    });

    $('.view-display-id-block_1 .prew').click(function(e) {
      e.preventDefault();
      $('.view-display-id-block_1 .pager-previous a').get(0).click();
    });

//--------------------------------------------------------------

    $('.view-display-id-block .next').click(function(e) {
      e.preventDefault();
      $('.view-display-id-block .pager-next a').get(0).click();
    });

    $('.view-display-id-block .prew').click(function(e) {
      e.preventDefault();
      $('.view-display-id-block .pager-previous a').get(0).click();
    });

// TODO: Begin Open cart in popup
    $('.my-cart a').click(function(e) {
      e.preventDefault();
        $.get('/cart', function(data){
          var data2 = $('.span9', data);
          $.colorbox({
            inline:true,
            width:"60%",
            href: data2,
          });
        });
    });
// TODO: End Open cart in popup
  });

    // $.ajax().done(function() {
    // if (window.location.pathname != '/cart') {
    //       $.get('/cart', function(data){
    //         var data2 = $('.span9', data);
    //         $.colorbox({
    //           inline:true,
    //           width:"40%",
    //           href: data2,
    //         });
    //       });
    //     }
    //   });

$.fn.cart_show = function(){
          $.get('/cart', function(data){
          var data2 = $('.span9', data);
          $.colorbox({
            inline:true,
            width:"60%",
            href: data2,
          });
        });
}

})(jQuery);
