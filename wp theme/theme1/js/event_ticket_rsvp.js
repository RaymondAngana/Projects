jQuery(document).ready(function ($) {
  // Custom script to set RSVP info if submitted event has RSVP details.
  var rsvp_name = $('#acf-field_5c77d053925ff').val();
  var rsvp_max = $('#acf-field_5c77d08a92600').val();

  if (rsvp_name != '') {
    $('#rsvp_form_toggle').trigger('click');
    $('#ticket_name').val(rsvp_name);
    $('#Tribe__Tickets__RSVP_capacity').val(rsvp_max);
    $('#acf-group_5c77cffe3247f').hide();
  }
});
