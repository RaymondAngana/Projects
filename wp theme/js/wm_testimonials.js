jQuery(document).ready(function ($) {
  // Custom script to assign field value in Testimonials custom post_type.
  var acf_author = $('#acf-field_5c5fc34ba7214').val();

  if (acf_author != '') {
    $('#wm-author').val(acf_author);
  }
});
