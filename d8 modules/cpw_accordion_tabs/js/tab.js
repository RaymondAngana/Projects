/**
 * @file
 * Contains Tab JS functions.
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.cpw_tabs = {
    attach: function (context, settings) {
      $('.country-tab').on('click', function (e) {
        e.preventDefault();
        let $wrapper = $(this).closest('.mod');
        let $countryTab = $wrapper.find('.country-item');
        let $regionContent = $wrapper.find('.country-tab-content');
        let toShow = $(this).attr('href');
        $countryTab.removeClass('is-active');
        $(this).parent('li').addClass('is-active');
        $regionContent.removeClass('is-active');
        $(toShow).addClass('is-active');
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
