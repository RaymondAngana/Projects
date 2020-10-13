/**
 * @file
 * Global utilities.
 *
 */
(function($, Drupal) {

  'use strict';

  Drupal.behaviors.bootstrap_barrio_subtheme = {
    attach: function(context, settings) {
      var position = $(window).scrollTop();
      $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
          $('body').addClass("scrolled");
        }
        else {
          $('body').removeClass("scrolled");
        }
        var scroll = $(window).scrollTop();
        if (scroll > position) {
          $('body').addClass("scrolldown");
          $('body').removeClass("scrollup");
        } else {
          $('body').addClass("scrollup");
          $('body').removeClass("scrolldown");
        }
        position = scroll;
      });
    }
  };

  // Contact Us button animate scrolling to Prefooter form.
  Drupal.behaviors.contact_scroll = {
    attach: function(context, settings) {
      $("a.cta-orange").click(function (e) {
        e.preventDefault();

        var position = $($(this).attr("href")).offset().top;

        $("body, html").animate({
          scrollTop: position
        }, 500);
      });
    }
  };

  // Accessibility. Setting focus on navigation open.
  Drupal.behaviors.nav_accessibility = {
    attach: function(context, settings) {
      // Main menu.
      $('.button-bar').click(function (e) {
        e.preventDefault();
        $('#block-promet-v3-main-menu').attr('tabindex','-1');
        setTimeout(function () {
          $('#block-promet-v3-main-menu').focus();
        }, 500);
      });

      //  Contact button, phone icon.
      $('.contact-button.phone button').click(function (e) {
        e.preventDefault();
        setTimeout(function () {
          $('.phone.contact-link a').focus();
        }, 500);
      });

      //  Contact button, emil icon.
      $('.contact-button.email button').click(function (e) {
        e.preventDefault();
        setTimeout(function () {
          $('.email.contact-link a').focus();
        }, 500);
      });
    }
  };

})(jQuery, Drupal);
