/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
(function($) {
   Drupal.behaviors.prayvine_screen = {
    attach: function(context) {
      
      var form = document.getElementById("prayvine-pray-verbaly");
      var title_full = true;
      
      $('#full-screen').click (function(env){
        env.preventDefault();
        launchFullscreen(form);
        $('#full-screen-exit').removeClass('pv-hidden');
        $(this).addClass('pv-hidden');
      });
      $('#full-screen-exit').click (function(env){
        env.preventDefault();
        exitFullScreen();
        $('#full-screen').removeClass('pv-hidden');
        $(this).addClass('pv-hidden');
      });
      $(window).resize(function(){
        
        if (is_Fullscreen()) {
          
          $('#full-screen-exit').removeClass('pv-hidden');
          $('#full-screen').addClass('pv-hidden');
        } else {
          
          $('#full-screen').removeClass('pv-hidden');
          $('#full-screen-exit').addClass('pv-hidden');
        }
      });
      //cacth escape key pressed
      
      function launchFullscreen(element) {
        if(element.requestFullscreen) {
          element.requestFullscreen();
        } else if(element.mozRequestFullScreen) {
          element.mozRequestFullScreen();
        } else if(element.webkitRequestFullscreen) {
          element.webkitRequestFullscreen();
        } else if(element.msRequestFullscreen) {
          element.msRequestFullscreen();
        }
      }
      function is_FullscreenEnabled() {
        if (
            document.fullscreenEnabled || 
            document.webkitFullscreenEnabled || 
            document.mozFullScreenEnabled ||
            document.msFullscreenEnabled
        ) {
          return true
        }
        return false;
      }
      function is_Fullscreen() {
        if (!document.fullscreenElement &&    // alternative standard method
            !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {
          return false;    
        } else {
          return true;
        }
      }
      function exitFullScreen() {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
          document.webkitExitFullscreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
        
      }
    }
  }
})(jQuery);
