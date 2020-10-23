<?php
/**
 * Markup for the custom RSVP fields when submitting community ticket.
 * Works in this page: events/community/add.
 */
function custom_rsvp_fields($label, $capacity) {
  $html = '
    <div class="tribe-section tribe-section-rsvp">
      <div class="tribe-section-header">
        <h3>RSVP Information</h3>
      </div>
      <table class="tribe-section-content">
        <colgroup>
          <col class="tribe-colgroup tribe-colgroup-label">
          <col class="tribe-colgroup tribe-colgroup-field">
        </colgroup>

        <tbody>
        <tr class="tribe-section-content-row">
          <td class="tribe-section-content-label">
            <label for="RSVPname" class="">Ticket Name: </label>      </td>
          <td class="tribe-section-content-field">
            <input type="text" id="RSVPname" name="RSVPname" class="cost-input-field" value="' . $label . '">
            <p>
              Ticket type name shows on the front end and emailed tickets        </p>
          </td>
        </tr>
        <tr class="tribe-section-content-row">
          <td class="tribe-section-content-label">
            <label for="RSVPcapacity" class="">Max Attendees: </label>      </td>
          <td class="tribe-section-content-field">
            <input type="number" id="RSVPcapacity" name="RSVPcapacity" class="cost-input-field" value="' . $capacity . '">
            <p>
              Leave blank for unlimited        </p>
          </td>
        </tr>
      </tbody></table>
      </div>';

  return $html;
}
