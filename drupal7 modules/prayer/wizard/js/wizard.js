(function ($) {
  Drupal.behaviors.prayvine_wizard = {
    attach: function (context, settings) {
    
      if($("li.radio-options input[checked=checked]").val() == 2) {
    	  $("#other_element").removeClass("pv-hidden");
      }
      $("li.radio-options input", context).click(function () {
        if ($(this).val() == 2) {
        	$("#other_element").removeClass("pv-hidden");
        } else {
        	$("#other_element").addClass("pv-hidden");
        }
      });
       
    }
  };


})(jQuery);
