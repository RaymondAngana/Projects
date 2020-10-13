(function ($, window, document) {
  var Careersource = {
    page_title: '',

    /**
     * CWR-171: Fix mobile navigation.
     * Ensure this only affects at mobile view.
     * Also ensure this gets fired everytime a page gets resized.
     */
    mobile_menu: function () {
      var mobile_menu = '.mobile-search-form + div.menu ul#menu-primary > li';
      var $ = jQuery.noConflict();
      if ($(window).width() < 880) {
        $(mobile_menu).find('ul.sub-menu').hide();
        $(mobile_menu).find('a').each(function () {
          $(this).click(function (e) {
            var submenu = $(this).parent().find('ul.sub-menu');

            $('#menu-primary li:not(.focus)').find('ul.sub-menu').slideUp().prev().removeClass('active');
            $(this).toggleClass('active').next().slideToggle();

            if ($(this).parent().hasClass('menu-item-has-children')) {
              e.preventDefault();
            }
            e.stopPropogation();
          });
        });
      }
      else {
        $(mobile_menu).find('ul.sub-menu').show();
      }
    },

    /**
     * CWR-149: Filter by industry-news.
     */
    filter_by_industry_news: function () {
      var url = location.href;
      var cat_slug_value_ref = {
        'advanced-manufacturing': 1057,
        'finance': 1054,
        'healthcare': 1056,
        'information-technology': 1055,
        'transportation-logistics': 1053
      };

      for (var slug in cat_slug_value_ref) {
        if (url.indexOf(slug) > 0) {
        var category = cat_slug_value_ref[slug];
          $('#ofindustry').val(category).hide();
        }
      }
    },

    /**
     * CWR-133: Set title if it's blank.
     */
    set_title_if_blank: function () {
      var title_text = $('.page-title.intro-title').text();
      var get_title = $('title').text().split(' - ')[0];
      this.page_title = get_title;
      $('.page-title.intro-title').text(title_text == '' ? get_title : title_text);
    },

    /**
     * CWR-273: Add breadcrumb current item if blank.
     */
    add_breadcrumb_to_current_item_if_blank: function () {
      var current_item_text = $('.breadcrumbs-container span.current-item').text();
      if (window.location.pathname == '/events/') {
        Careersource.page_title = 'Event Calendar';
      }

      if (current_item_text == '') {
        $('.breadcrumbs-container span.current-item').text(Careersource.page_title);
      }
    },

    /**
     * CWR-278: Trigger live chat on "Enter" and change alert messages accordingly.
     */
    make_wp_live_chat_accessible: function () {
      var pre_alert = "The WP Live Chat window is ";
      var status = "closed";
      $('body').on("keydown click", function (e) {
        // Since we're binding in the "body" element, we need to ensure that we
        // will only react if the clicked elements are #wp-live-chat-header.
        if (e.target.id == 'wp-live-chat-header') {
          status = (e.type == 'keydown') ? status : 'closed';

          // If screen reader and uses "Enter" key.
          if (e.which == 13) {
            if (!$('#wp-live-chat-header').hasClass('active')) {
              status = "now open";
              $('#wp-live-chat-header-trigger').trigger('click');
            }
            else {
              status = "now closed";
              $('#wp-live-chat-2, #wplc_hovercard').hide();
              $('#wp-live-chat-header').removeClass('active');
            }
          }
          $('#wp-live-chat [role="alert"]').text(pre_alert + status);
        }

        // ...as well as #speeching_button element.
        if (e.target.id == 'speeching_button') {
          $('#wp-live-chat [role="alert"]').text("The WP Live Chat window is now open");
        }
      });
    },

    /**
     * CWR-287: Remediate modal popups.
     */
    add_close_button_in_event_tooltip: function () {
      var close = '<span class=\'close_tooltip\' tabindex=\'0\'>X <small class=\'screen-reader-text\'>Close</small></span>';
      $('.tribe-events-calendar .tribe_events').each(function () {
        var old_title = $(this).attr('data-tribejson').split('"title":"')[1].split('",')[0];
        var new_title = close + old_title;
        var new_attr_val = $(this).attr('data-tribejson').replace(old_title, new_title);

        $(this).attr({
          'data-tribejson': new_attr_val,
          'tabIndex': 0
        })
        .on('focus', function () {
          $(this).trigger('mouseenter');
        })
        .on('blur', function () {
          $(this).trigger('mouseleave');
        });
      });

      $('body').on('click', function (event) {
        if (event.target.className == 'close_tooltip') {
          $(event.target).parent().parent().hide();
        }
      });
    },

    /**
     * Redirect dropdowns on change.
     */
    redirect_dropdowns_on_change: function () {
      // Redirect Job Seekers menu dropdown onclick.
      $('.more-in-dropdown-submit').on('click keydown', function () {
        if ($('.more-in-dropdown').val() != '#') {
          event.preventDefault();
          location.href = $('.more-in-dropdown').val();
        }
      });

      // CWR-261: Redirect industry-news-category onChange().
      $('#industry-news-category-dropdown').on('change', function () {
        var val = $(this).find(":selected").val();
        if (val != '') {
          location.href = '/industry/' + val;
        }
      });
    },

    /**
     * CWR-288: Set custom validity message on required fields of constant contact forms.
     */
    set_custom_validity_message_to_constant_contact_forms: function () {
      $('form.ctct-form input[required]').each(function () {
        var field = $(this).attr('name').split('___')[0].replace('_', ' ');
        $(this)
        .on('invalid', function () {
          this.setCustomValidity('Please fill out the ' + field + ' field.');
        })
        .on('input', function () {
          this.setCustomValidity('');
        });
      });
    },

    /**
     * CWR-288: Remediation in relation to the Constant Contact form.
     */
    remediate_constant_contact_form: function () {
      // CWR-288: Add "role='alert'" to the ctct-message parent div.
      if ($('.ctct-message').hasClass('success')) {
        $('.ctct-message').parents('.fl-module-content.fl-node-content').eq(0).attr('role', 'alert');
      }

      // CWR-288: Add aria-hidden to #ctct_usage elements.
      $('.ctct-form input[type="hidden"]').attr('aria-hidden', 'true');
    },

    /**
     * CWR-288: Remediate event calendar page.
     */
    remediate_event_calendar: function () {
      // CWR-288: Add autocomplete attribute to filter form fields.
      $('#tribe-bar-search, #tribe-bar-geoloc').attr('autocomplete', 'on');

      // CWR-288: Add understandable context for screen-readers.
      $('#tribe-bar-geoloc').attr('aria-label', 'Near which location? (enter address and then select one from list)');

      // CWR-288: Add role="button" to event calendars "Submit event" and "export events".
      var buttons = 'body.post-type-archive-tribe_events div.tribe-events-before-html a,';
      buttons += ' a.tribe-events-ical.tribe-events-button';
      $(buttons).attr('role', 'button');
    },

    /**
     * CWR-311: Hide Author Widget on sidebar if author is none or the default (cs_admin).
     */
    hide_author_widget_if_cs_admin: function () {
      var author_name = $('.mks_author_widget h3.widget-title').text();
      if (author_name == 'cs_admin' || author_name == '') {
        $('.mks_author_widget').hide();
      }
    },

    /**
     * CWR-321: Clone and move RSVP message on top of event page.
     */
     move_rsvp_message_on_top_content: function () {
      $('.tribe-rsvp-messages').remove().clone().appendTo('#tribe-rsvp-message-display-top');
     },

    /**
     * Consolidated script for all accessibility-related fixes.
     */
    accessibility_fixes: function () {
      // CWR-199: Move Email address in footer area.
      $('.footer-area-footer-widgets .wm-contact-info .email').remove().clone().insertBefore('.footer-area-footer-widgets .address');

      // CWR-276: Loop through screen-reader-text's parent and hide fl-col-group.
      $('div.screen-reader-text.force-hide').parents('.fl-col-group').eq(0).css('height', '0');

      // CWR-288: Add tab-index="0" to Page title.
      $('.page-title.intro-title').attr('tabIndex', '0');

      // CWR-276: Footer info, hide the heading title on logo
      $('#footer-widgets .widget_media_image h3.widget-title').addClass('screen-reader-text');
    }

  // Closing of Careersource helper methods.
  }


  /**
   * Execute whenever the page/DOM has fully loaded and is ready.
   */
  $(document).ready(function () {
    Careersource.mobile_menu();
    Careersource.filter_by_industry_news();
    Careersource.set_title_if_blank();
    Careersource.add_breadcrumb_to_current_item_if_blank();
    Careersource.make_wp_live_chat_accessible();
    Careersource.add_close_button_in_event_tooltip();
    Careersource.redirect_dropdowns_on_change();
    Careersource.set_custom_validity_message_to_constant_contact_forms();
    Careersource.remediate_constant_contact_form();
    Careersource.remediate_event_calendar();
    Careersource.hide_author_widget_if_cs_admin();
    Careersource.move_rsvp_message_on_top_content();
    Careersource.accessibility_fixes();
  });

  /**
   * CWR-279: Listen to keypress and close the tooltip on events page.
   */
  $(document).keydown(function (e) {
    if (e.key === "Escape") {
      $('.close_tooltip').trigger('click');
    }
  });

  /**
   * Execute function whenever window is resized.
   */
  $(window).resize(function () {
    Careersource.mobile_menu();
  });

  /**
   * CWR-244: Execute when a page scrolls (Offsets page on mobile-only).
   */
  $(window).on('scroll', function () {
    var y_scroll_pos = window.pageYOffset;
    var scroll_pos_test = 50;

    if ($(window).width() < 880) {
       $('.active .main-navigation-container').css('margin-top', (y_scroll_pos > scroll_pos_test) ? '0' : '110px');
    }
  });

})(jQuery, window, document);
