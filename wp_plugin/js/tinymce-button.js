(function() {
  'use strict';
  jQuery(document).ready(function() {
    var $authorization_token = "Bearer " + Token.token;
    try {
      tinymce.PluginManager.add( 'widendam_iframe', function( editor, url ) {
        // Add Widen button to TinyMCE toolbar
        editor.addButton('widendam_iframe', {
            title: 'Widen Collective',
            image: url.replace('js', '') + 'images/widencollective.png',
            cmd: 'widendam_iframe',
        }); 

        // Command when Widen button is clicked
        editor.addCommand('widendam_iframe', function() {
          jQuery.ajax({
           url: "https://api.widencollective.com/v2/integrations/url/",
           type: "GET",
           headers: {
            "Authorization": $authorization_token
           }
          }).done(function(body) {
            var $auth_url = body.url + '&actions=download,view,insert';

            // Opens a HTML page inside a TinyMCE dialog
            editor.windowManager.open({
              title: 'Widen Collective',
              url: $auth_url,
              width: 1024,
              height: 640,
            });
          }).fail(function() {
            var msg = 'Cannot connect to Widen Collective server. Please try again.';
              if (body) {
                msg = msg + '\n' + body;
              }
              alert(msg);
          });
        });

        window.addEventListener('message', function (event) {
          try {
            var embedCode = event.data.items[0].embed_code;
            editor.insertContent(embedCode);

            // Close the dialog.
            top.tinymce.activeEditor.windowManager.close();
          } catch(e) {}
        });
    });
  } catch(e) {}
        
    jQuery(document).on( 'click', '#mce-modal-block', function() {
      tinyMCE.activeEditor.windowManager.close();
    });
  });
})();