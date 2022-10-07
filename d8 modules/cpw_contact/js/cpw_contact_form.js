(function ($, Drupal, drupalSettings) {
  'use strict';
  Drupal.behaviors.cpw_contact = {
    attach: function (context) {
      this.contactFormSubmit = $(context).find('.form-submit');
      this.email = $(context).find('#edit-email-me');
      this.chkinput = $(context).find("#edit-privacy-agreement");

      Drupal.behaviors.cpw_contact.preprocess(context);

      // Adding red asterisk on required fields
      $('.mod-contact-form .form-required').each(function () {
        if ($(this).children('span').length === 0) {
          $(this).append('<span class="red-marked">*</span>');
        }
      });

      this.questionCForm = $('#edit-what-would-you-like-to-contact-us-about-today- .js-form-item input');

      this.questionCForm.each(function () {
        if (drupalSettings.question_param != '' && drupalSettings.question_param != null) {
          if ($(this).attr('value').toLowerCase() == drupalSettings.question_param) {
            $(this).prop('checked', true);
          }
          else {
            $(this).prop('checked', false);
          }
        }
      });


      this.requiredFields = $(context).find('form.webform-submission-contact-us-form .required');

      // Check if submit trigger then add error message upon component load
      if (Drupal.behaviors.cpw_contact.getSubmitCookie('contactSumbitTrigger')) {
        Drupal.behaviors.cpw_contact.setSubmitCookie('expired');
        Drupal.behaviors.cpw_contact.checkRequiredField(context);
        setTimeout(function(){
          Drupal.behaviors.cpw_contact.focusField(context);
        }, 500);
      }

      // On Click Event of Submit Button
      this.contactFormSubmit.on('click', function(e) {
        Drupal.behaviors.cpw_contact.setSubmitCookie('new');
        Drupal.behaviors.cpw_contact.checkRequiredField(context);
      });

      // On Change Event
      $(context).change(function(event) {
        const targetElement = event.target || event.srcElement;
        const $element = $(context).find(targetElement);
        const isRequired = $element.attr('required');

        // If the element trigger is required, then add error message
        // Different Browser Support
        if (typeof isRequired !== typeof undefined && isRequired !== false) {
          Drupal.behaviors.cpw_contact.checkErrorMessage($element);
        }
      });
    },

    preprocess: function (context) {
      const $radios = $(context).find('input[name="what_would_you_like_to_contact_us_about_today_"]');
      const $termsCheckbox = $(context).find('input[name="privacy_agreement"]');

      // Select default radio input
      if(!$radios.is(':checked')) {
        $radios.first().attr('checked',true);
      }

      // Event listener for terms and condition checkbox
      $termsCheckbox.on('click', function() {
        const checked = $termsCheckbox.attr('checked');

        // Different Browser Support
        if (typeof checked !== typeof undefined && checked !== false) {
          $termsCheckbox.removeAttr(checked);
        } else {
          $termsCheckbox.attr('checked', 'checked');
        }
      });
    },

    checkRequiredField: function (context) {
      const requiredField = this.requiredFields;
      const requiredFieldLength = requiredField.length;

      for (var i = 0; i < requiredFieldLength; i++) {
        const $requiredFieldContext = $(requiredField[i]);

        Drupal.behaviors.cpw_contact.checkErrorMessage($requiredFieldContext);
      }
    },

    checkErrorMessage: function(element) {
      const $element = element;
      const name = $element.attr('name');
      const $errorLabel = $element.siblings('label.error');
      let error = '<label for="' +
        $element.attr('id') +
        '-error" class="error">' +
        $element.data('msgRequired') +
        '</label>';

      if (!$element.is('fieldset') && ($element.val() == '' || $element.val() == undefined)) {
        if (!$errorLabel.length) {
          Drupal.behaviors.cpw_contact.addErrorMessage($element, error);
        }
      } else {
        if ($errorLabel.length) {
          Drupal.behaviors.cpw_contact.removeErrorMessage($element, $errorLabel);
        }
      }

      // Check if type is email
      if ($element.attr('type') == 'email' &&
        ($element.val() !== '' && $element.val() !== undefined)) {
        const isValidEmail = Drupal.behaviors.cpw_contact.validateEmail($element.val());
        error = '<label for="' +
          $element.attr('id') +
          '-error" class="error">' +
          $element.data('msgEmail') +
          '</label>';

        if (!isValidEmail) {
          Drupal.behaviors.cpw_contact.addErrorMessage($element, error);
        } else {
          if ($errorLabel.length) {
            Drupal.behaviors.cpw_contact.removeErrorMessage($element, $errorLabel);
          }
        }
      }

      // CHeck if element is privacy agreement
      if (typeof name !== typeof undefined && name !== false && name == 'privacy_agreement') {
        const checked = $element.attr('checked');

        // Different Browser Support
        if (typeof checked === typeof undefined || checked === false) {
          Drupal.behaviors.cpw_contact.addErrorMessage($element, error);
        } else {
          Drupal.behaviors.cpw_contact.removeErrorMessage($element, $errorLabel);
        }
      }
    },

    addErrorMessage: function (element, error) {
      const $element = element;

      $element.addClass('error');
      $element.addClass('error').after(error);
    },

    removeErrorMessage: function (element, errorLabel) {
      const $element = element;
      const $errorLabel = errorLabel;

      $element.removeClass('error');
      $errorLabel.remove();
    },

    validateEmail: function(email) {
      const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email);
      if (!0 !== regex)
        return false;
      return true;
    },

    setSubmitCookie: function(state) {
      let date = new Date();

      if (state == 'expired') {
        date = 'Thu, 01 Jan 1970 00:00:00 GMT';
      } else {
        date.setTime(date.getTime()+(3600*1000));
        date.toUTCString();
      }

      const expiry = '; expires=' + date;
      document.cookie = 'contactSumbitTrigger=1' + expiry + '; path=/';
    },

    getSubmitCookie: function (name) {
      const value = `; ${document.cookie}`;
      const parts = value.split(`; ${name}=`);
      if (parts.length === 2) return parts.pop().split(';').shift();
    },

    focusField: function (context) {
      const errorFields = $(context).find('.mod-contact-form [aria-invalid=true]');

      if (errorFields.length > 0) {
        const field = errorFields[0];

        $('html, body').animate({
          scrollTop: ($(field).offset().top - 100)
        }, 1000);

        field.focus();
      }
    },
  }
})(jQuery, Drupal, drupalSettings);
