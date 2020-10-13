/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


(function($) {
  Drupal.behaviors.prayvine = {
    attach: function(context) {

      var comment_container = $('.ajax-comment-container');
      var prayer_container = $('.ajax-prayer-container');
      var request_container = $('.ajax-request-container');


      //add prayer top

      $('.ajax-prayer-top').click(function(env) {

    	if ($(this).hasClass("no-action")) {
    		return false;
    	}
    	
        var container_m1 = $('#prayvine-private-replay-missionary').parent();
        container_m1.addClass('pv-hidden');

        env.preventDefault();
        if (prayer_container.length > 0 && comment_container.length > 0 && request_container.length > 0) {
          prayer_container.removeClass('prayvine-removed');
          prayer_container.addClass('prayvine-active');
          comment_container.removeClass('prayvine-active');
          request_container.removeClass('prayvine-active');
          $('.prayvine-buttons a').removeClass('prayvine-active');
          //$('.prayvine-buttons').addClass('prayvine-removed');
          $('.left-content-buttons .placeholder-bubble').removeClass('prayvine-active');
          $('.left-content-buttons .placeholder-bubble').addClass('prayvine-removed');

          $(this).addClass('prayvine-active');
        }

      });
      $('.left-content-buttons .placeholder-bubble').click(function(env) {
        env.preventDefault();
        if (prayer_container.length > 0 && comment_container.length > 0 && request_container.length > 0) {
          prayer_container.removeClass('prayvine-removed');
          prayer_container.addClass('prayvine-active');
          comment_container.removeClass('prayvine-active');
          request_container.removeClass('prayvine-active');
          $('.prayvine-buttons a').removeClass('prayvine-active');
          //$('.prayvine-buttons').addClass('prayvine-removed');
          $(this).removeClass('prayvine-active');
          $(this).addClass('prayvine-removed');

          $('.left-content .ajax-prayer-top').addClass('prayvine-active');
        }

      });
      $('.ajax-comment').click(function(env) {
    	 if ($(this).hasClass("no-action")) {
      	 	return false;
      	 }
        env.preventDefault();

        if (prayer_container.length > 0 && comment_container.length > 0 && request_container.length > 0) {
          comment_container.removeClass('prayvine-removed');
          prayer_container.removeClass('prayvine-active');
          request_container.removeClass('prayvine-active');
          comment_container.addClass('prayvine-active');
          $('.prayvine-buttons a').removeClass('prayvine-active');
          //$('.prayvine-buttons').addClass('prayvine-removed');
          $('.left-content-buttons .placeholder-bubble').removeClass('prayvine-active');
          $('.left-content-buttons .placeholder-bubble').addClass('prayvine-removed');
          $(this).addClass('prayvine-active');
        }

      });
      $('.ajax-request').click(function(env) {
    	if ($(this).hasClass("no-action")) {
      		return false;
      	}
        env.preventDefault();

        if (prayer_container.length > 0 && comment_container.length > 0 && request_container.length > 0) {
          request_container.removeClass('prayvine-removed');
          prayer_container.removeClass('prayvine-active');
          comment_container.removeClass('prayvine-active');
          request_container.addClass('prayvine-active');
          $('.prayvine-buttons a').removeClass('prayvine-active');
          //$('.prayvine-buttons').addClass('prayvine-removed');
          $('.left-content-buttons .placeholder-bubble').removeClass('prayvine-active');
          $('.left-content-buttons .placeholder-bubble').addClass('prayvine-removed');
          $(this).addClass('prayvine-active');
        }

      });

      /***shamsher**/
      jQuery('.message-silent-button').click(function(e) {
          if ($(this).attr("href").indexOf("key") > 0) {
        	  return true;
          } else {
	    	  jQuery('#silent').css('display', 'block'); 
	    	  var parent = $(this).parent();
	    	  parent.find('.ajax-prayer-top').removeClass('prayvine-active');
	          parent.parent().find('.ajax-prayer-container').removeClass('prayvine-active').addClass('pv-hidden');
	          console.log(parent);
	          parent.find('.message-replay-button-missionary').removeClass('prayvine-active');
	          parent.find('.ajax-replay-container-center-missionary').addClass('pv-hidden');
	          var button = $(this);
	          button.addClass('prayvine-active');
	          $('#prayvine-private-replay-missionary').parent().addClass("pv-hidden");
	          parent.parent().find('.placeholder-bubble').addClass('pv-hidden');
          }
          
      });
      jQuery('.ajax-prayer-top').click(function(e) {

        if (jQuery('#silent').is(":visible")) {
          jQuery('#silent').css('display', 'none');
        }

      });

      jQuery('.message-replay-button-missionary').click(function(e) {

        if (jQuery('#silent').is(":visible")) {
          jQuery('#silent').css('display', 'none');
          
        }
        jQuery(".message-silent-button").removeClass('prayvine-active');

      });


      /***End**/

      //add prayer left
      $('.ajax-prayer').click(function(env) {
        env.preventDefault();
        var this_object = $(this);
        var href = $(this).attr('href');
        var links = new String();
        links = href.split('=');
        var nids = new String();
        nids = links[1].split('&');
        var nid = nids[0];
        var token = links[3];
        var container = $('<div class="ajax-prayer-container-left">');
        var form = $('.ajax-prayer-container').children().clone();
        if ($('.ajax-prayer-container-left').length != 0) {
          $('.ajax-prayer-container-left').remove();
        } else {
          container.append(form);
          var row_element = this_object.parent().parent().parent();
          row_element.after(container);
          $('.ajax-prayer-container-left .prayvine-cancel-prayer').click(function(env) {
            env.preventDefault();
            $('.ajax-prayer-container-left').remove();
          });
        }



      });

      //login - sign in 
      var login = $('.login-form_lazy');
      var signin = $('.signin-form_lazy');
      var login_button = $('.lazy-login-signin');
      var register_button = $('.lazy-login-register');

      if (login.length > 0) {
        signin.addClass('pv-hidden');
        register_button.click(function(env) {
          env.preventDefault();
          login.removeClass('pv-hidden');
          signin.addClass('pv-hidden');
        });
        login_button.click(function(env) {
          env.preventDefault();
          login.addClass('pv-hidden');
          signin.removeClass('pv-hidden');
        })
      }

      permission_select();


      function permission_select() {
        //handling select people
        var select_people = $('#edit-field-prayer-select-people');
        var permission_type = $('#edit-field-prayer-permission-type-und');
        var permission_type_value = permission_type.val();
        if (permission_type_value != 2) {
          select_people.addClass('pv-hidden');
        }
        //check change of permission 
        permission_type.change(function(env) {
          var value = $(this).val();
          if (value != 2) {
            select_people.addClass('pv-hidden');
          } else {
            select_people.removeClass('pv-hidden');
          }
        });
      }



      //handling request replay
      var text_area = $('.replay-request');
      var prayer_button = $('.prayer-button-request');
      var replay_button = $('.message-replay-button');
      function addPrayerRequest(element_this, clicked) {

        var element = $(element_this);
        var container = $('<div class="ajax-prayer-container-center">');
        var form = $('.ajax-prayer-container').children().clone();
        if ($('.ajax-prayer-container-center').length != 0) {
          $('.ajax-prayer-container-center').remove();
          clicked.removeClass('prayvine-active');
        } else {
          clicked.addClass('prayvine-active');
          container.append(form);
          var row_element = $(element_this).parent();
          var request_id = row_element.parent().attr('id');
          var nid = request_id.split('-');
          var val_text = 'title (' + nid[1] + ')';
          row_element.append(container);

          if (row_element.hasClass('comment-forms')) {//handling comments update

            var comment_id = $('.ajax-prayer-container-center .form-item-field-comment-id-und-0-target-id input');
            if (nid[1] > 0) {
              comment_id.val(val_text);
              comment_id.attr('value', val_text);
            }
          } else {//handling request handling
            var prayer_id = $('.ajax-prayer-container-center .form-field-name-field-prayer-id input');
            if (nid[1] > 0) {
              prayer_id.val(val_text);
              prayer_id.attr('value', val_text);
            }
          }



          $('.ajax-prayer-container-center .prayvine-cancel-prayer').click(function(env) {
            env.preventDefault();
            $('.ajax-prayer-container-center').remove();
            element.removeClass('pv-hidden');
            clicked.removeClass('prayvine-active');
            $('.prayer-button-request.request-reply').addClass('prayvine-active');//always set first button to active
            $('.placeholder-bubble').addClass('prayvine-active');
            $('.placeholder-bubble').removeClass('prayvine-removed');
          });

          var select_people = $('.ajax-prayer-container-center .form-field-name-field-prayer-select-people');
          var permission_type = $('.ajax-prayer-container-center .form-item-field-prayer-permission-type-und select');
          var permission_type_value = permission_type.val();
          if (permission_type_value != 2) {
            select_people.addClass('pv-hidden');
          }
          //check change of permission 
          permission_type.change(function(env) {
            var value = $(this).val();
            if (value != 2) {
              select_people.addClass('pv-hidden');
            } else {
              select_people.removeClass('pv-hidden');
            }
          });
          //handling cancel button
        }
      }
      ;
      //prevent link click
      $('.request-reply').click(function(env) {
        env.preventDefault();
      });
      if (text_area.length > 0) {
        text_area.click(function(env) {
          env.preventDefault();
          $('.ajax-prayer-container-center').remove();
          $('.ajax-replay-container-center').remove();
          $('.request-reply').removeClass('prayvine-active');
          $(this).addClass('pv-hidden');
          addPrayerRequest(this, $(this));
          $(this).removeClass('prayvine-active');

        });
        prayer_button.click(function(env) {
          env.preventDefault();
          $('.ajax-prayer-container-center').remove();
          $('.ajax-replay-container-center').remove();
          $('.request-reply').removeClass('prayvine-active');

          var txt_area = $(this).parent().parent().children('.placeholder-bubble');
          txt_area.addClass('pv-hidden');

          var element = $(this).parent();
          addPrayerRequest(element, $(this));


        });

      }

      //handling private message 
      var message_replay_buttons = $('.message-replay-button');
      message_replay_buttons.click(function(env) {
        env.preventDefault();
        $('.ajax-prayer-container-center').remove();
        $('.ajax-replay-container-center').remove();
        $('.request-reply').removeClass('prayvine-active');
        var user_uid = $(this).attr('href');
        var request_id = $(this).parent().parent().parent().attr('id');
        var request_nid_split = request_id.split('-');
        var request_nid = request_nid_split[1];
        var txt_area = $(this).parent().parent().find('.placeholder-bubble');
        txt_area.addClass('pv-hidden');
        txt_area.removeClass('prayvine-active');
        var button = $(this);
        button.addClass('prayvine-active');
        var form = $('.private-message-replay').clone();
        var container = $('<div class="ajax-replay-container-center">');
        form.removeClass('pv-hidden');
        if ($('.ajax-replay-container-center').length != 0) {
          $('.ajax-replay-container-center').remove();
          button.removeClass('prayvine-active');
        } else {
          container.append(form);
          var row_element = $(this).parent();
          row_element.after(container);
          //populate hidden elements
          var user_uid_element = $('.user_uid');
          user_uid_element.val(user_uid);
          if (row_element.parent().hasClass('comment-forms')) {
            var comment_id_element = $('.comment_id');
            comment_id_element.val(request_nid);
          } else {
            var request_id_element = $('.request_id');
            request_id_element.val(request_nid);
          }

        }

        $('.ajax-replay-container-center .prayvine-cancel-replay').click(function(env) {
          env.preventDefault();
          $(this).parent().parent().parent().parent().remove();
          txt_area.removeClass('pv-hidden');
          button.removeClass('prayvine-active');
          $('.prayer-button-request.request-reply').addClass('prayvine-active');//always set first button to active
        });
      })


      //handling missionary replay
      var message_replay_buttons_missionary = $('.message-replay-button-missionary'); //message-replay-button-missionary
      message_replay_buttons_missionary.click(function(env) {
        env.preventDefault();
        //var write_prayer = $(this).find('.ajax-prayer-container');
        // write_prayer.removeClass('prayvine-active');
        //  $('.ajax-prayer-container').remove(); //ajax-prayer-container prayvine-active
        $('.ajax-prayer-top').removeClass('prayvine-active');
        $('.ajax-prayer-container').removeClass('prayvine-active');
        $('.ajax-prayer-container').addClass('pv-hidden');
        // $('.ajax-replay-container-center-missionary').remove();//ajax-replay-container-center-missionary pv-hidden
        //var user_uid = $(this).attr('href'); //user id
        //alert(user_uid);
        //fetch request id discuss
        var txt_area = $(this).parent().parent().find('.placeholder-bubble');
        txt_area.addClass('pv-hidden');
        txt_area.removeClass('prayvine-active');
        var button = $(this);
        button.addClass('prayvine-active');
        var form_m = $('.private-message-replay-missionary').clone();
        var container_m = $('#prayvine-private-replay-missionary').parent();
        // alert(1);
        //alert(alert(JSON.stringify(container_m)));
        container_m.removeClass('pv-hidden');
        //if ($('.ajax-replay-container-center-missionary').length != 0) {
        //    $('.ajax-replay-container-center-missionary').remove();
        //   button.removeClass('prayvine-active');
        //}else {
        //   container_m.append(form_m);
        //  var row_element_m = $(this).parent();
        //   row_element_m.after(container_m);
        //   //populate hidden elements
        //   var user_uid_element = $('.user_uid');
        //   user_uid_element.val(user_uid);
        //   //if (row_element.parent().hasClass('comment-forms')) {
        //   //  var comment_id_element = $('.comment_id');
        //   //  comment_id_element.val(request_nid);  
        //   //} else {
        //   //  var request_id_element = $('.request_id');
        //   //  request_id_element.val(request_nid);
        //   //}
        //   
        //}

      })
      //handling missionary replay

      //handling get data ajax for statistics
      var stat_data_url = Drupal.settings.prayvine_data.json_url;
      $('.stat-data').click(function(env) {
        var id = $(this).attr('id');
        var split_id = id.split('_');
        var full_url = stat_data_url + '/' + split_id[1] + '/' + split_id[2] + '/' + split_id[3];
        var data_element = $(this);
        //get data using get
        $.get(full_url, function(data) {

          $('.data-prayers-amens-tooltip').remove();
          data_element.after(data);
        });
      });
      $('html').click(function() {
        //Hide the tooltip
        $('.data-prayers-amens-tooltip').remove();
      });
      //handling pray silently
      $('.request-silent').click(function(env) {
        env.preventDefault();
        var url = $(this).attr('href');
        window.open(url, '_blank');

      });
      //handling autoload
      var position_marker = $('.loading-marker').offset();
      var marker_element = $('.loading-marker').last();
      var screen_size = $(window).height();
      if ($('.loading-marker').length > 0) {
        var marker_id = $('.loading-marker').attr('id');
        var marker = marker_id.split('_');
        var begin = marker[1];
      }

      var start_load = true;

      $(window).scroll(function(env) {
        var scroll = $(window).scrollTop();
        marker_element = $('.loading-marker').last();
        position_marker = marker_element.offset();
        //recalculate marker
        marker_id = marker_element.attr('id');
        marker = marker_id.split('_');
        begin = marker[1];

        var trigger_position = position_marker.top - 2 * screen_size;
        var nid = Drupal.settings.prayvine_topic.id;
        if ((trigger_position - scroll) < 0 && start_load) {//trigger actions
          //get aditional content
          var autoload_url = Drupal.settings.prayvine_autoload.json_url + '?begin=' + begin + '&nid=' + nid;
          start_load = false;


          if ($('.autoload_finish').length == 0) {//check if we are at the end of topic
            $('.loading-marker').last().text(Drupal.t('Loading more posts…'));
            $.get(autoload_url, function(data) {

              $('.loading-marker').after(data).remove();

              start_load = true;
            });
          }


        }


      });
      //update buttons for photo and pdf

      var photo_field = $('.ajax-comment-container .field-name-field-add-photo');
      var pdf_field = $('.ajax-comment-container .field-name-field-pdf-doc');
      var photo_button = $('.photo-add');
      var pdf_button = $('.pdf-add');

      pdf_field.hide();
      pdf_button.addClass('tab-inactive');
      photo_button.click(function(env) {
        env.preventDefault();
        $(this).removeClass('tab-inactive');
        $(this).removeClass('tab-inactive');
        pdf_button.addClass('tab-inactive');

        photo_field.show();
        pdf_field.hide();

      });
      pdf_button.click(function(env) {
        $(this).removeClass('tab-inactive');
        $(this).removeClass('tab-inactive');
        photo_button.addClass('tab-inactive');

        env.preventDefault();
        photo_field.hide();
        pdf_field.show();
      });

      var invite_button_not_allow = $('.invite-friends-not-allow');
      invite_button_not_allow.click(function(env) {
        alert(Drupal.t('Please post a prayer request before sending invitations. This helps your friends know how to pray for you.'));
      });

    }
  }
})(jQuery);