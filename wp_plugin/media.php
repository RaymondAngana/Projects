<link rel="stylesheet" type="text/css" href="<?php echo plugins_url( 'css/widen.css', __FILE__ ); ?>">
<?php
$check_page_dam_lib = isset($_GET['page']);
$check_tab_is_one = (isset($_GET['tab']) && $_GET['tab'] == 1);

if ($check_page_dam_lib || $check_tab_is_one) {
  $actions = ($_GET['page'] != 'DAMLibrary' || $_GET['tab'] == 1) ? 'insert' : 'add';
}

$url = widendam_api_get_iframe_url()->url;
$url .= '&actions=download,view,' . $actions . '&preset=2048px';

$domain = get_option('widen_domain');
$token = get_option('widen_access_token');
if (isset($domain) && (strlen($domain) != 0)) {
  if (isset($token) && (strlen($token) != 0)) { ?>
    <div id="widen_media_body" class="wrap" style="width: 98%; height: 638px;">
        <iframe src="<?php print $url; ?>" tabindex="-1" style="width: 100%;height:100%"></iframe>
    </div>
  <?php
  }

  else { ?>
    <br />
    <p>
      You are currently not Authorized to use Widen Collective.
      <a href='<?php echo get_site_url(); ?>/wp-admin/options-general.php?page=DAMSettings'>Authorize with Widen Collective</a>
      now.
    </p>
  <?php
  }
}

// If NOT Media page. Assuming this is post/page content.
if (isset($_GET['page'])) {
if ($_GET['page'] != 'DAMLibrary'): ?>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    window.addEventListener('message', function (event) {
      try {
        var embedCode = event.data.items[0].embed_code;
        window.parent.send_to_editor(embedCode);

        // Close the dialog.
        //top.tinymce.activeEditor.windowManager.close();
        window.parent.tb_remove();
      } catch(e) {}
    });

    $('#mce-modal-block').click(function() {
      tinyMCE.activeEditor.windowManager.close();
    });
  });
</script>
<?php endif; } ?>



<!-- Modal content -->
  <div class="modal-content modal">
    <span class="close">&times;</span>
    <img src="<?php echo plugins_url( 'images/ajax_loader_blue_128.gif', __FILE__ ); ?>" >
    <h3>Please wait while image is being added into Media Library.</h3>
  </div>
