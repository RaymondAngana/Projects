/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function($) {
	
	Drupal.behaviors.prayvine = {
		attach: function(context) {
			var node_nid = Drupal.settings.prayvine_reminder_node_id;
			var page_id = Drupal.settings.prayvine_reminder_page_id;
			 if ($('#webform-client-form-'+node_nid).length == 0 ) {
				$('#prayvine-loadform_general').trigger('click');
				$('.popups-close.close').html('').removeClass( "popups-close close" );

			$(document).keydown(function(e) {
			    // ESCAPE key pressed
			    if (e.keyCode == 27) {
				window.location.href = '/node/'+page_id;

			    }
			});
			}
		}
	}
})(jQuery);
