<?php

/**
 * Full width Video Only.
 **/

$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$videoID = call_user_func($field_or_subfield, 'video_id') ? : 'Video ID';
?>


<section class="fw-vid">
  <div class="row">
    <div class="columns xlarge-12 large-11 medium-11 small-11">
      <div class="responsive-embed widescreen">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $videoID; ?>?rel=0&controls=0&enablejsapi=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</section>