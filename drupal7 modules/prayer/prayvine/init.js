/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function($) {
   Drupal.behaviors.prayvine_screen = {
    attach: function(context) {
      if (Drupal.settings.user.is_logged == 0) {
        var url = document.URL;
        var post_data = new Object;
        post_data.url = url;
        var set_url = Drupal.settings.base_url.url+'/set_url';
        $.ajax({
              url: set_url,
              data: post_data,
              type: 'POST',
              success: function(result) {
                
              }
        });
      }
      
      if (Drupal.settings.redirect_url) {
        var link = Drupal.settings.redirect_url.url;
        var split_link = link.split('#');//get # anchor
        if (split_link[1]) {
          //animate scroll to given node
          $('html, body').animate({
            scrollTop: $("#"+split_link[1]).offset().top-100
          }, 200);
          //open 
          var prayer_button = $("#"+split_link[1]).find('a.prayer-button-request');
          if (prayer_button.length > 0) {
            setTimeout(function(){prayer_button.trigger('click');}, 300);
          }
          
        }
      }
      
      
      
      
      
    }
  }
})(jQuery);