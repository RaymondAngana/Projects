/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function($) {
   Drupal.behaviors.prayvine_tutorial = {
    attach: function(context) {
      var small_size_res = 700;//resulotion where we change modal size
      var width = 65;
      //for small screen set it on 90%

      if ($(window).width() < small_size_res){
        width = 92;
      }
      this.adjust_modal(width);

      //do not start if user is
      if (!Drupal.settings.user.is_logged){
        return;
      }
      //if user is topic owner not start tutorial
      if (Drupal.settings.prayvine_topic_owner){
        return;
      }

      var state_tutorial = Drupal.settings.prayvine_tutorial_state.json_url;

      var tutorial_data = [];
      var steps = [];
      //initial values
      for (i=0;i<7;i++) {
        steps[i] = 0;
      }
      $.get(state_tutorial,function(data){
        tutorial_data = data;
        if (tutorial_data !== null){

          if (typeof tutorial_data.first_step !== 'undefined') {
            steps[0] = 1;
          }
          if (typeof tutorial_data.second_step !== 'undefined') {
            steps[1] = 1;
          }
          if (typeof tutorial_data.third_step !== 'undefined') {
            steps[2] = 1;
          }
          if (typeof tutorial_data.forth_step !== 'undefined') {
            steps[3] = 1;
          }
          if (typeof tutorial_data.fifth_step !== 'undefined') {
            steps[4] = 1;
          }
          if (typeof tutorial_data.sixth_step !== 'undefined') {
            steps[5] = 1;
          }
           if (typeof tutorial_data.seventh_step !== 'undefined') {
            steps[6] = 1;
          }
          //trigger screen six if this topic hasn't been visit with tutorial
          //if tutorial pass and tutorial on this specific page is not pass
          if (Drupal.settings.prayvine_topic_tutorial_pass == false && steps[6] == 1) {
            steps[5] = 0;
            //steps[6] = 0;
          }

        }


        for (i=0;i<7;i++) {

          if (steps[i] == 0) {//find first that is no processed and live loop
            if (i==0) {
              if ($('#prayvine-tutorial-1-form').length == 0) {
                $('#prayvine-tutorial-link-1').trigger('click');

              }

            }
            if (i==1) {

              if ($('#prayvine-tutorial-2-form').length == 0) {
                $('#prayvine-tutorial-link-2').trigger('click');

              }
            }
            if (i==2) {

              if ($('#prayvine-tutorial-3-form').length == 0) {
                $('#prayvine-tutorial-link-3').trigger('click');

              }

            }
            if (i==3) {
              if ($('#prayvine-tutorial-4-form').length == 0) {
                $('#prayvine-tutorial-link-4').trigger('click');

              }


            }
            if (i==4) {
              if ($('#prayvine-tutorial-5-form').length == 0) {
                $('#prayvine-tutorial-link-5').trigger('click');

              }

            }
            if (i==5) {
              if ($('#prayvine-tutorial-6-form').length == 0) {
                $('#prayvine-tutorial-link-6').trigger('click');

              }

            }
            if (i==6) {
              if ($('#prayvine-tutorial-7-form').length == 0) {
                $('#prayvine-tutorial-link-7').trigger('click');

              }

            }
            break;
          }
        }


      });
      var tutrial_form_4 = $('#prayvine-tutorial-4-form');
      if (tutrial_form_4.length > 0) {
        var facebook = document.getElementById('facebook-jssdk');
        if (facebook !== null){

          $.getScript( "/sites/all/modules/custom/prayvine_tutorial/facebook_login.js", function( data, textStatus, jqxhr ) {

          });
        }
      }

      //take photo
      if ($('#canvas').length > 0 ) {
        //trigger page 1
        var canvas = document.getElementById("canvas"),
        context = canvas.getContext("2d"),
        video = document.getElementById("video"),
        videoObj = { "video": true },
        errBack = function(error) {
          console.log("Video capture error: ", error.code);
        };

        //save image to file
        function saveImage() {
          var canvasData = canvas.toDataURL("image/png");

          var url = document.URL;
          var post_data = new Object;
          post_data.imgData = canvasData;
          var set_url = Drupal.settings.base_url.url+'/prayvine_tutorial/save_image';
          $.ajax({
            url: set_url,
            data: post_data,
            type: 'POST',
            success: function(result) {

            }
          });
        }

        if(navigator.getUserMedia) { // Standard
          navigator.getUserMedia(videoObj, function(stream) {
            video.src = stream;
            video.play();
          }, errBack);
        } else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
          navigator.webkitGetUserMedia(videoObj, function(stream){
            video.src = window.webkitURL.createObjectURL(stream);
            video.play();
          }, errBack);
        }
        else if(navigator.mozGetUserMedia) { // Firefox-prefixed
          navigator.mozGetUserMedia(videoObj, function(stream){
            video.src = window.URL.createObjectURL(stream);
            video.play();
          }, errBack);
        }
        // Put video listeners into place
        // Trigger photo take
        $('#snap').click(function(env) {
          env.preventDefault();
          context.drawImage(video, 0, 0, 300, 200);
        });
        $("input[name='use_this_photo']").click(function(env){
          //env.preventDefault();
          saveImage();
        });
      }
      //facebook
      if ($('#fb-picture').length > 0) {
        function take_facebook_picture() {
          var profile_image = $('#facebook-profile-image');
          var src = profile_image.attr('src');
          var set_url = Drupal.settings.base_url.url+'/prayvine_tutorial/save_image';
          var post_data = new Object;
          post_data.imgLink = src;
          post_data.imgData = '';

          $.ajax({
            url: set_url,
            data: post_data,
            type: 'POST',
            success: function(result) {

            }
          });
        }
        $("input[name='use_this_photo']").click(function(env){

          take_facebook_picture();
        });
        var load_text = '<p id="loading-message">'+Drupal.t('Connecting to facebook, please wait..')+'</p>';
        $('#loading-message').remove();
        $('#prayvine-tutorial-5-form h2').after(load_text);



      }

      var tutrial_form_5 = $('#prayvine-tutorial-5-form');
      if (tutrial_form_5.length > 0) {
        var facebook = document.getElementById('facebook-jssdk');
        if (facebook !== null){

          $.getScript( "/sites/all/modules/custom/prayvine_notification/facebook.js", function( data, textStatus, jqxhr ) {

          })
        }

        function replace() {
          var uploaded_file = $('#prayvine-tutorial-5-form').find('a');
          if (uploaded_file.length > 0) {

            var image_link = uploaded_file.attr('href');
            if (!jQuery.isEmptyObject(image_link)) {
              var widget = $("#tutorial-page-photo");
              widget.hide();
              $('#tutorial-page5-image').remove();
              widget.after('<img id="tutorial-page5-image" src="'+image_link+'" height="300" width="200">');
            }
          }
        }

        var image_field = $("div.form-item-field-add-photo-und-0");
        image_field.replaceWith('<div id="edit-field-add-photo-und-0-ajax-wrapper">'+image_field.html()+'</div>');

        $( document ).ajaxComplete(function( event, xhr, settings ) {
          replace();
        });
      }
      var tutorial_form_7 = $('#prayvine-tutorial-7-form');
      if (tutorial_form_7.length > 0) {
        var submit_button = $('.form-submit');
        submit_button.click(function(env){
          var topic_id = Drupal.settings.prayvine_topic.id;
          window.location.href = '/node/'+topic_id;
        });
      }
    },
    adjust_modal:function(percentage){
      var screen_width = $(window).width();

      var new_width = screen_width*(percentage/100);
      var modal = $('.ctools-modal-content, .modal-content');
      //calculate left position;
      var left_left = screen_width*((100 - percentage)/100);
      var left = left_left/2;
      console.log(left,new_width,percentage);
      modal.css({
        'width': Math.round( new_width ) + 'px',
        'height': modal.height() + 'px',
      });
      $('#modalContent').css({
        'left': Math.round(left) + 'px'
      });

    }
  }
})(jQuery);

