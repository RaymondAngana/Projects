jQuery(document).ready( function($) {
  // var embedLink = 'https://embed.widencdn.net/original/schewe/xsf13j4hro/screaming-internally.gif';
  
  window.addEventListener('message', function (event) {
    // console.log(event);
    try {
      var embedLink = event.data.items[0].embed_link;
      var fname = event.data.items[0].filename;
      var raw_filename = fname.replace(/\.gif|\.png|\.jpg/gi, '');

      var embedFileName = raw_filename.charAt(0).toUpperCase() + raw_filename.slice(1);
      var data = {
        'action': 'widen_media',
        'url': embedLink,
        'filename': embedFileName
      };
  
    if(embedLink) {
      $('.modal').fadeIn('slow');
        
        // We can also pass the url value separately from ajaxurl for front end AJAX implementations
        jQuery.post(ajax_object.ajax_url, data, function(response) {
          $('.modal').hide(function() {
            alert(embedFileName + ' has been successfully added to the Media Library.');
          });
        })
        .fail(function() {
          alert( "An error occurred: " + response );
        })
      }
    } catch(e) {}
  });

});