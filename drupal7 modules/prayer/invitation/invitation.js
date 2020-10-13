/**
 * @file
 * Customization for prayvine_invitation.
 */

(function ($) {
  Drupal.behaviors.prayvine_invitation = {
    attach: function (context, settings) {
      $('#prayvine-invitation-main-form').submit(function () {
        $('#prayvine-invitation-main-form input[value="Send invitation"]').attr('disabled', 'disabled');
        $('*').css('cursor', 'progress');
      })

      $('#prayvine-wizard-form-3').submit(function () {
        $('#prayvine-wizard-form-3 input[value="Send invitation"]').attr('disabled', 'disabled');
        $('*').css('cursor', 'progress');
      })
    }
  };
}(jQuery));
