/**
* @file
* CPW Category Listing JS.
*/
(function ($, Drupal, drupalSettings) {
  
  'use strict';
  
  /**
   * Slick options for teasers.
   *
   * @type {{attach: Drupal.behaviors.category_listing.attach}}
   */
  Drupal.behaviors.category_listing = {
    attach: function (context, settings) {
      if (context === document) {
        let dotEnabled = false;
        $(window).on("load", function() {
          if ($('.mod-products-landing-slider').children().length > 1) {
            dotEnabled = true;
          }

          $('.mod-products-landing-slider').slick({
            dots: dotEnabled,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: true,
            rtl: $('html').attr('dir') === 'rtl',
          });
        });
      }
    },
  };

}(jQuery, Drupal, drupalSettings));
