<?php
add_action( 'wp_ajax_add_to_catalog_cart', 'add_to_catalog_cart' );
add_action( 'wp_ajax_nopriv_add_to_catalog_cart', 'add_to_catalog_cart' ); 
function add_to_catalog_cart() {
  session_start();
  if(empty($_SESSION['catalog_cart'])) {
    $_SESSION['catalog_cart'] = array();
    array_push($_SESSION['catalog_cart'], $_POST['item_id']);
  } else {
    if(!in_array($_POST['item_id'], $_SESSION['catalog_cart'])) {
      array_push($_SESSION['catalog_cart'], $_POST['item_id']);
    }
  }
  wp_die();
}

add_action( 'wp_ajax_remove_to_catalog_cart', 'remove_to_catalog_cart' );
add_action( 'wp_ajax_nopriv_remove_to_catalog_cart', 'remove_to_catalog_cart' );
function remove_to_catalog_cart() {
  session_start();
  if(!empty($_SESSION['catalog_cart'])) {
    if(in_array($_POST['item_id'], $_SESSION['catalog_cart'])) {
      $index = array_search($_POST['item_id'], $_SESSION['catalog_cart']);
      unset($_SESSION['catalog_cart'][$index]);
    }
  }
}

add_action( 'wp_ajax_cart_data', 'cart_data' );
add_action( 'wp_ajax_nopriv_cart_data', 'cart_data' );
function cart_data() {
  global $wpdb;
  session_start();
  if(!empty($_SESSION['catalog_cart'])) {
    $catalog_cart = array();
    $db_cart = array();
    $product_cart = array();
    $corpus_type_cart = array();

    $return_ar = array();

    foreach ($_SESSION['catalog_cart'] as $value) {
      $dbName = '';
      $db = '';
      $product = '';
      $corpus_type = '';
      $value_a = explode('-', $value);
      $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}".$value_a[1]." WHERE id = ".$value_a[0] );
      if($row) {
        $language = $row->language;
        $db = $row->language;
        $product = $row->language;
        $corpus_type = $row->language;
        if(!empty($value_a[1])) {
          if($value_a[1] == 'ots_catalog') {
            $dbName = 'Speech Databases';
            $db .= ' - ('.$row->db_name.')';
            array_push($db_cart, $db);
          }
          if($value_a[1] == 'pronunciation_lexicons') {
            $dbName = 'Pronunciation Lexicons';
            $product .= ' - ('.$row->product.')';
            array_push($product_cart, $product);
          }
          if($value_a[1] == 'part_of_speech_lexicons') {
            $dbName = 'Part of Speech Lexicons';
            $product .= ' - ('.$row->product.')';
            array_push($product_cart, $product);
          }
          if($value_a[1] == 'other_text_data') {
            $dbName = 'Other text data';
            $corpus_type .= ' - ('.$row->corpus_type.')';
            array_push($corpus_type_cart, $corpus_type);
          }
          $language .= ' - ('.$dbName.')';
        }
        array_push($catalog_cart, $language);
      }
    }
    $return_ar['catalog_cart'] = implode(', ', $catalog_cart);
    $return_ar['db_cart'] = implode(', ', $db_cart);
    $return_ar['product_cart'] = implode(', ', $product_cart);
    $return_ar['corpus_type_cart'] = implode(', ', $corpus_type_cart);

    echo json_encode($return_ar);
  }
  wp_die();
}

function slug_create($name) {
  $slug = preg_replace('~[^\pL\d]+~u', '-', $name);
  $slug = iconv('utf-8', 'us-ascii//TRANSLIT', $slug);
  $slug = preg_replace('~[^-\w]+~', '', $slug);
  $slug = trim($slug, '-');
  $slug = preg_replace('~-+~', '-', $slug);
  $slug = strtolower($slug);
  if (empty($slug)) {
    $slug = 'n-a';
  }
  return $slug;
}

function ots_table($atts,$content=null){
$a = shortcode_atts(
    array(
    ),$atts);
ob_start();
?>
<div class="x-container">
  <div class="x-column x-sm x-1-2 catalog-search">
    <div class="custom_search_outer">
      <form id="catalog_table_search_form" class="custom_searc_section ots_search_form" method="get" action="">
          <input type="text" id="frm_search" name="s" placeholder="Search" style="outline: none;">
          <button type="submit" class="btn btn-success">
              <i class="la la-search"></i>
          </button>
      </form>
    </div>
  </div>
  <div class="x-column x-sm x-1-2 catalog-curved">
    <a class="btn_curved" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=show"><span>Request Quote</span></a>
  </div>
</div>
<?php session_start(); ?>
<table id="productCatalog">
  <thead>
    <tr>
      <th></th>
      <th class="productCatalog__language">Language</th>
      <th class="productCatalog__products">Products</th>
      <th class="productCatalog__details">Details</th>
      <th class="productCatalog__quote">Quote</th>
    </tr>
  </thead>
  <tbody>
    <?php
    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ots_catalog" );
    if(!empty($results)) {
    foreach($results as $row) {
    ?>
    <tr>
      <td></td>
      <td><?php echo $row->language; ?></td>
      <td><?php echo $row->product_type2; ?></td>
      <td><a href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/ots_catalog/<?php echo slug_create($row->language); ?>-<?php echo $row->id; ?>"><?php echo $row->db_name; ?></a></td>
      <td>
        <?php if(!empty($_SESSION['catalog_cart'])) { ?>
          <?php if(!in_array($row->id.'-ots_catalog', $_SESSION['catalog_cart'])) { ?>
            <a class="js-quote add_quote" data-id="<?php echo $row->id; ?>-ots_catalog" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $row->id; ?>-ots_catalog"><span>+</span> Add to quote</a>
          <?php } else { ?>
            <a class="js-quote remove_quote" data-id="<?php echo $row->id; ?>-ots_catalog" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?remove_to_catalog_cart=<?php echo $row->id; ?>-ots_catalog"><span>-</span> Remove</a>
          <?php } ?>
        <?php } else { ?>
          <a class="js-quote add_quote" data-id="<?php echo $row->id; ?>-ots_catalog" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $row->id; ?>-ots_catalog"><span>+</span> Add to quote</a>
        <?php } ?>
      </td>
    </tr>
    <?php } } ?>
    <?php
    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pronunciation_lexicons" );
    if(!empty($results)) {
    foreach($results as $row) {
    ?>
    <tr>
      <td></td>
      <td><?php echo $row->language; ?></td>
      <td><?php echo $row->product; ?></td>
      <td><a href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/pronunciation_lexicons/<?php echo slug_create($row->language); ?>-<?php echo $row->id; ?>"><?php echo $row->num_of_words; ?></a></td>
      <td>
        <?php if(!empty($_SESSION['catalog_cart'])) { ?>
          <?php if(!in_array($row->id.'-pronunciation_lexicons', $_SESSION['catalog_cart'])) { ?>
            <a class="js-quote add_quote" data-id="<?php echo $row->id; ?>-pronunciation_lexicons" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $row->id; ?>-pronunciation_lexicons"><span>+</span> Add to quote</a>
          <?php } else { ?>
            <a class="js-quote remove_quote" data-id="<?php echo $row->id; ?>-pronunciation_lexicons" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?remove_to_catalog_cart=<?php echo $row->id; ?>-pronunciation_lexicons"><span>-</span> Remove</a>
          <?php } ?>
        <?php } else { ?>
          <a class="js-quote add_quote" data-id="<?php echo $row->id; ?>-pronunciation_lexicons" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $row->id; ?>-pronunciation_lexicons"><span>+</span> Add to quote</a>
        <?php } ?>
      </td>
    </tr>
    <?php } } ?>
    <?php
    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}part_of_speech_lexicons" );
    if(!empty($results)) {
    foreach($results as $row) {
    ?>
    <tr>
      <td></td>
      <td><?php echo $row->language; ?></td>
      <td><?php echo $row->product; ?></td>
      <td><a href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/part_of_speech_lexicons/<?php echo slug_create($row->language); ?>-<?php echo $row->id; ?>"><?php echo $row->num_of_words; ?></a></td>
      <td>
        <?php if(!empty($_SESSION['catalog_cart'])) { ?>
          <?php if(!in_array($row->id.'-part_of_speech_lexicons', $_SESSION['catalog_cart'])) { ?>
            <a class="js-quote add_quote" data-id="<?php echo $row->id; ?>-part_of_speech_lexicons" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $row->id; ?>-part_of_speech_lexicons"><span>+</span> Add to quote</a>
          <?php } else { ?>
            <a class="js-quote remove_quote" data-id="<?php echo $row->id; ?>-part_of_speech_lexicons" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?remove_to_catalog_cart=<?php echo $row->id; ?>-part_of_speech_lexicons"><span>-</span> Remove</a>
          <?php } ?>
        <?php } else { ?>
          <a class="js-quote add_quote" data-id="<?php echo $row->id; ?>-part_of_speech_lexicons" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $row->id; ?>-part_of_speech_lexicons"><span>+</span> Add to quote</a>
        <?php } ?>
      </td>
    </tr>
    <?php } } ?>
    <?php
    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}other_text_data" );
    if(!empty($results)) {
    foreach($results as $row) {
    ?>
    <tr>
      <td></td>
      <td><?php echo $row->language; ?></td>
      <td><?php echo $row->corpus_type; ?></td>
      <td></td>
      <td>
        <?php if(!empty($_SESSION['catalog_cart'])) { ?>
          <?php if(!in_array($row->id.'-other_text_data', $_SESSION['catalog_cart'])) { ?>
            <a class="js-quote add_quote" data-id="<?php echo $row->id; ?>-other_text_data" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $row->id; ?>-other_text_data">+ Add to quote</a>
          <?php } else { ?>
            <a class="js-quote remove_quote" data-id="<?php echo $row->id; ?>-other_text_data" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?remove_to_catalog_cart=<?php echo $row->id; ?>-other_text_data">- Remove</a>
          <?php } ?>
        <?php } else { ?>
          <a class="js-quote add_quote" data-id="<?php echo $row->id; ?>-other_text_data" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $row->id; ?>-other_text_data">+ Add to quote</a>
        <?php } ?>
      </td>
    </tr>
    <?php } } ?>
  </tbody>
</table>
<script>
    jQuery(document).ready(function() {


      if(jQuery(window).width() >= 768) {
    var oTable = jQuery('#productCatalog').DataTable({
      responsive: true,
      //"ordering": false,
      "pagingType": "simple",
      "pageLength": 20,
      "columns": [
          {
              "orderable": true,
              "data": null,
              "defaultContent": '',
              "visible": false
          },
          { 
            "data": "language",
            "orderable": true,
          },
          { 
            "data": "products",
            "orderable": true,
          },
          { 
            "data": "details" ,
            "orderable": true,
          },
          { 
            "data": "quote",
            "orderable": true,
          }
      ],
      columnDefs: [ 
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: -1 } 
      ],
      order: [ 1, 'asc' ]
    });
    } else {
    var oTable = jQuery('#productCatalog').DataTable({
      "pagingType": "numbers",
      "pageLength": 20,
      colReorder: {
          order: [ 0, 1, 4 ]
      },
      "columns": [
          {
              "orderable": true,
              "data": null,
              "defaultContent": '',
              "visible": false
          },
          { 
            "data": "language",
            "orderable": true,
            "className": "control"
          },
          { 
            "data": "products",
            "orderable": true,
            "visible": false
          },
          { 
            "data": "details" ,
            "orderable": true,
            "visible": false
          },
          { 
            "data": "quote",
            "orderable": true,
            "visible": false
          }
      ],
      order: [ 1, 'asc' ]
    });

    }

      jQuery('.paginate_button.previous').after("<strong>"+(oTable.page.info().page+1)+" / "+ oTable.page.info().pages +"</strong>");
      oTable.on( 'draw', function () {
        var current_page = oTable.page.info().page+1;
        var pages = oTable.page.info().pages;
        jQuery('.paginate_button.previous').after("<strong>"+current_page+" / "+ pages +"</strong>");
      } );


      function format ( d ) {
      var data = '<table class="catalog-submenu" cellpadding="5" cellspacing="0" border="0"">';
        data =  data + 
              '<tr>'+
                  '<td>'+
                    '<span class="catalog-title">Products</span>'+
                    '<span>'+d.products+'</span>'+
                  '</td>'+
              '</tr>';
      if(d.details != '') {
        data =  data + 
            '<tr class="fc">'+
                '<td>'+
                  '<span class="catalog-title">Details</span>'+
                  '<span>'+d.details+'</span>'+
                '</td>'+
            '</tr>';
      }
      data =  data + '<tr>'+
              '<td>'+
              d.quote+'</td>'+
          '</tr>'+
      '</table>';
      return data;
    }


    jQuery('body').on('click', 'a.add_quote', function(e) {
      e.preventDefault(); 
      var thisElement = jQuery(this);
      jQuery.ajax({
          url: '<?php echo admin_url('admin-ajax.php'); ?>',
          type: 'post',
          data: {
            action: 'add_to_catalog_cart',
            item_id: jQuery(thisElement).attr('data-id')
          },
          success: function( data, textStatus, jQxhr ){
              jQuery(thisElement).text('- Remove')
                                 .addClass('remove_quote')
                                 .removeClass('add_quote')
                                 .closest('tr').addClass('js-selected');
              var text = jQuery(thisElement).closest('tr').find('td:nth-child(3) a').text()+'-'+jQuery(thisElement).closest('tr').find('td:nth-child(1)').text();
              if ("ga" in window) {
                  tracker = ga.getAll()[0];
                  if (tracker)
                      tracker.send("event", "OTS Database Add to Cart", "Add to Cart", text);
              }
          },
          error: function( jqXhr, textStatus, errorThrown ){
              console.log( errorThrown );
          }
      });
    });


    jQuery('body').on('click', 'a.remove_quote', function(e) {
      e.preventDefault();
      var thisElement = jQuery(this);
      jQuery.ajax({
          url: '<?php echo admin_url('admin-ajax.php'); ?>',
          type: 'post',
          data: {
            action: 'remove_to_catalog_cart',
            item_id: jQuery(thisElement).attr('data-id')
          },
          success: function( data, textStatus, jQxhr ){
              jQuery(thisElement).text('+ Add to quote')
                                 .addClass('add_quote')
                                 .removeClass('remove_quote')
                                 .closest('tr').removeClass('js-selected');
          },
          error: function( jqXhr, textStatus, errorThrown ){
              console.log( errorThrown );
          }
      });
    });

    jQuery('#catalog_table_search_form').submit(function(e){
      e.preventDefault();
      jQuery('<a class="clear_search" href="#"><i class="la la-times" aria-hidden="true"></i></a>').insertAfter(jQuery(this).find('#frm_search'));
      oTable.search(jQuery(this).find('#frm_search').val()).draw() ;
    });
    jQuery('body').on('click', 'a.clear_search', function(e) {
      e.preventDefault();
      jQuery(this).parent().find('#frm_search').val('');
      jQuery(this).remove();
      oTable.search('').draw();
    });

    jQuery('#productCatalog tbody').on('click', 'td.control', function () {
          var tr = jQuery(this).closest('tr');
          var row = oTable.row( tr );
   
          if ( row.child.isShown() ) {
              // row.child.hide();
              tr.toggleClass('parent');
              tr.toggleClass('js-hide');
          }
          else {
              row.child( format(row.data()) ).show();
              var classes = tr.attr('class');
              row.child().find('tr.fc td a').contents().unwrap();
              row.child().addClass(classes);
              tr.addClass('parent');
          }
      } );

    });
</script>
<?php
return ob_get_clean();
}
add_shortcode('ots-table','ots_table');

function ots_info($atts,$content=null){
$a = shortcode_atts(
    array(
    ),$atts);
ob_start();
session_start();
global $wp_query;
$table = $wp_query->query_vars['tableots'];
$slug = $wp_query->query_vars['slugots'];
if(isset($slug)) {
  global $wpdb;
  $details = explode('-', $slug);
  $catalog_details = end($details).'-'.$table;
  if($table == 'ots_catalog') {
    $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}".$table." WHERE id = ".end($details) );
    if(!empty($row)) {
    ?>
    <div class="x-container">
      <div class="catalog_container">
        <p>
          <strong>Language:</strong> <?php echo $row->language; ?><br/>
          <strong>DB Name:</strong> <?php echo $row->db_name; ?><br/>
          <strong>Product Type:</strong> <?php echo $row->product_type2; ?><br/>
          <strong>Environment:</strong> <?php echo $row->environment; ?><br/>
          <strong>Speaker:</strong> <?php echo $row->spkrs; ?><br/>
          <strong>Prompts/spkr:</strong> <?php echo $row->prompts_spkr; ?><br/>
          <strong>Utterances:</strong> <?php echo $row->utts; ?><br/>
          <strong>Audio Hrs:</strong> <?php echo $row->audio_hrs; ?><br/>
          <strong>kHz:</strong> <?php echo $row->khz; ?><br/>
          <strong>Channels:</strong> <?php echo $row->channels; ?><br/>
          <strong>Description</strong>
          <?php 
            $brief = $row->brief; 
            $brief_a = explode('|', $brief);
            if(!empty($brief_a)) {
              echo '<ul>';
              foreach ($brief_a as $value) {
                echo '<li>'.$value.'</li>';
              }
              echo '</ul>';
            } else {
              echo $brief.'<br/>';
            }
          ?>
        </p>
        <p class="catalog_footer"><strong>Source:</strong> <?php echo $row->source; ?></p>
        <div class="catalog_curved">
          <?php if(!empty($_SESSION['catalog_cart'])) { ?>
            <?php if(!in_array($catalog_details, $_SESSION['catalog_cart'])) { ?>
                <a class="btn_curved" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $catalog_details; ?>">Request this language</a>
              <?php } else { ?>
                <a class="btn_curved" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?remove_to_catalog_cart=<?php echo $catalog_details; ?>">Remove from quote</a>
              <?php } ?>
            <?php } else { ?>
            <a class="btn_curved" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $catalog_details; ?>">Request this language</a>
          <?php } ?>
        </div>      
      </div>
    </div>
    <?php
    }
  }
  if($table == 'pronunciation_lexicons') {
    $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}".$table." WHERE id = ".end($details) );
      if(!empty($row)) {
    ?>
    <div class="x-container">
      <div class="catalog_container">
        <p>
          <strong>Language:</strong> <?php echo $row->language; ?><br/>
          <strong>Estimated Number of Words:</strong> <?php echo $row->num_of_words; ?><br/>
          <strong>Product:</strong> <?php echo $row->product; ?><br/>
        </p>
        <div class="catalog_curved">
          <?php if(!empty($_SESSION['catalog_cart'])) { ?>
            <?php if(!in_array($catalog_details, $_SESSION['catalog_cart'])) { ?>
                <a class="btn_curved" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $catalog_details; ?>">Request this language</a>
              <?php } else { ?>
                <a class="btn_curved" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?remove_to_catalog_cart=<?php echo $catalog_details; ?>">Remove from quote</a>
              <?php } ?>
            <?php } else { ?>
            <a class="btn_curved" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $catalog_details; ?>">Request this language</a>
          <?php } ?>
        </div>   
      </div>
    </div>
    <?php
    }
  }
  if($table == 'part_of_speech_lexicons') {
    $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}".$table." WHERE id = ".end($details) );
      if(!empty($row)) {
    ?>
    <div class="x-container">
      <div class="catalog_container">      
        <p>
          <strong>Language:</strong> <?php echo $row->language; ?><br/>
          <strong>Estimated Number of Words:</strong> <?php echo $row->num_of_words; ?><br/>
          <strong>Product:</strong> <?php echo $row->product; ?><br/>
        </p>
        <div class="catalog_curved">
          <?php if(!empty($_SESSION['catalog_cart'])) { ?>
            <?php if(!in_array($catalog_details, $_SESSION['catalog_cart'])) { ?>
                <a class="btn_curved" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $catalog_details; ?>">Request this language</a>
              <?php } else { ?>
                <a class="btn_curved" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?remove_to_catalog_cart=<?php echo $catalog_details; ?>">Remove from quote</a>
              <?php } ?>
            <?php } else { ?>
            <a class="btn_curved" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $catalog_details; ?>">Request this language</a>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php
    }
  }
  if($table == 'other_text_data') {
    $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}".$table." WHERE id = ".end($details) );
      if(!empty($row)) {
    ?>
    <div class="x-container">
      <div class="catalog_container">
        <p>
          <strong>Language:</strong> <?php echo $row->language; ?><br/>
          <strong>Corpus Type:</strong> <?php echo $row->corpus_type; ?><br/>
        </p>
        <div class="catalog_curved">
          <?php if(!empty($_SESSION['catalog_cart'])) { ?>
            <?php if(!in_array($catalog_details, $_SESSION['catalog_cart'])) { ?>
                <a class="btn_curved" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $catalog_details; ?>">Request this language</a>
              <?php } else { ?>
                <a class="btn_curved" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?remove_to_catalog_cart=<?php echo $catalog_details; ?>">Remove from quote</a>
              <?php } ?>
            <?php } else { ?>
            <a class="btn_curved" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?add_to_catalog_cart=<?php echo $catalog_details; ?>">Request this language</a>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php
    }
  }
}
if(isset($_GET['add_to_catalog_cart']) || isset($_GET['remove_to_catalog_cart'])) {
  if(isset($_GET['add_to_catalog_cart'])) {
    if($_GET['add_to_catalog_cart'] != 'show') {
      if(empty($_SESSION['catalog_cart'])) {
        $_SESSION['catalog_cart'] = array();
        array_push($_SESSION['catalog_cart'], $_GET['add_to_catalog_cart']);
      } else {
        if(!in_array($_GET['add_to_catalog_cart'], $_SESSION['catalog_cart'])) {
          array_push($_SESSION['catalog_cart'], $_GET['add_to_catalog_cart']);
        }
      }
    }
  }
  if(isset($_GET['remove_to_catalog_cart'])) {
    if($_GET['remove_to_catalog_cart'] != 'show') {
      if(!empty($_SESSION['catalog_cart'])) {
        if(in_array($_GET['remove_to_catalog_cart'], $_SESSION['catalog_cart'])) {
          $index = array_search($_GET['remove_to_catalog_cart'], $_SESSION['catalog_cart']);
          unset($_SESSION['catalog_cart'][$index]);
        }
      }
    }
  }
  global $wpdb;
  if(!empty($_SESSION['catalog_cart'])) {
    ?>
    <script>
      function cart_data() {
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'post',
            data: {
              action: 'cart_data'
            },
            success: function( data, textStatus, jQxhr ){
                var obj = jQuery.parseJSON(data);
                jQuery('#input_28_9').val(obj.catalog_cart);
                jQuery('#input_28_18').val(obj.db_cart);
                jQuery('#input_28_19').val(obj.product_cart);
                jQuery('#input_28_20').val(obj.corpus_type_cart);
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });
      }
      jQuery('document').ready(function() {
        cart_data();
      });
      jQuery('body').on('click', 'a.catalog_cart_list_delete', function(e) {
        e.preventDefault();
        var thisElement = jQuery(this);
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'post',
            data: {
              action: 'remove_to_catalog_cart',
              item_id: jQuery(thisElement).attr('data-id')
            },
            success: function( data, textStatus, jQxhr ){
                jQuery(thisElement).parent().remove();
                cart_data();
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });
      });
    </script>
    <div class="catalog_cart_wrap">
    <?php
      session_start();
      if($_SESSION['gf_submit'] == 1) {
        unset($_SESSION['catalog_cart']);
        unset($_SESSION['gf_submit']);
      } else {
    ?>
    <h1 class="catalog_head">Languages you need</h1>
    <ul class="catalog_cart_list">
    <?php
    $languagesRequested = [];
    $corpusType = [];
    $dbName = [];

    foreach($_SESSION['catalog_cart'] as $cart_item) {
      ?>
      <?php
        $cart_item_a = explode('-', $cart_item);
        $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}".$cart_item_a[1]." WHERE id = ".$cart_item_a[0] );
        if(!empty($row)) {
          array_push($languagesRequested, $row->language);
          if ( isset($row->corpus_type) && !in_array($row->corpus_type, $corpusType) ) array_push($corpusType, $row->corpus_type);
          if ( isset($row->db_name) && !in_array($row->db_name, $dbName) ) array_push($dbName, $row->db_name);
      ?>
      <li>
        <?php echo $row->language; ?>
        <input type="hidden" name="catalog_cart_pro[]" value="<?php echo $cart_item; ?>" />
        <a class="catalog_cart_list_delete" data-id="<?php echo $row->id; ?>-<?php echo $cart_item_a[1]; ?>" href="<?php echo site_url(); ?>/speech-language-datasets/product-catalog/?remove_to_catalog_cart=<?php echo $row->id; ?>"></a>
      </li>
      <?php
      }
    }
    ?>
    </ul>
    <?php } ?>
    <div class="catalog_cart_form">
      <script defer src="//app-ab14.marketo.com/js/forms2/js/forms2.min.js"></script>
      <form id="mktoForm_1979"></form>
      <?php
        $languagesRequestedCleared = [];
        foreach ( $languagesRequested as $lang ) {
          $langCleared = preg_replace( '/ \(.*?\)/', '', $lang );
          if ( !in_array( $langCleared, $languagesRequestedCleared ) ) array_push( $languagesRequestedCleared, $langCleared );
        }
      ?>
      <script defer>
       jQuery(document).ready(function() {
        MktoForms2.loadForm("//app-ab14.marketo.com", "416-ZBE-142", 1979, function(form) {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const utm = {
                'source': urlParams.get('utm_source'),
                'medium': urlParams.get('utm_medium'),
                'content': urlParams.get('utm_content'),
                'term': urlParams.get('utm_term'),
                'campaign': urlParams.get('utm_campaign'),
            };

            form.setValues({
                'utm_source__c': utm.source ? utm.source : '',
                'utm_medium__c': utm.medium ? utm.medium : '',
                'utm_content__c': utm.content ? utm.content : '',
                'utm_term__c': utm.term ? utm.term : '',
                'utm_campaign__c': utm.campaign ? utm.campaign : '',
            });
          form.vals({ "languagesRequested":"<?php echo implode(', ', $languagesRequestedCleared); ?>"});
          form.vals({ "languageforwebuse":"<?php echo implode(', ', $languagesRequested); ?>"});
          form.vals({ "corpusType":"<?php echo implode(', ', $corpusType); ?>"});
          form.vals({ "dBName":"<?php echo implode(', ', $dbName); ?>"});
        });


        MktoForms2.whenReady(function(form) {
            var formElem = form.getFormElem()[0];
            var reasonSelect = formElem.querySelector('[name="whyAreYouReachingOutOnPageForm"]');
            var countrySelect = formElem.querySelector('[name="Country"]');
            var findSelect = formElem.querySelector('[name="howDidYouFindUs"]');
            jQuery(reasonSelect).select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Select'
            });
            jQuery(countrySelect).select2({
                placeholder: 'Select'
            });
            jQuery(findSelect).select2({
                minimumResultsForSearch: Infinity,
                placeholder: 'Select'
            });
        });
      });
      </script>
      <?php // echo do_shortcode('[gravityform id=28 title=false description=false ajax=false tabindex=28]'); ?>    
    </div>
    </div>
    <?php
  } else {
    header("Location: ".site_url()."/speech-language-datasets/#ProductCatalog");
  }
}
return ob_get_clean();
}
add_shortcode('ots-info','ots_info');

add_action( 'gform_after_submission_28', 'after_submission_clear_cart', 10, 2 );
function after_submission_clear_cart() {
  session_start();
  $_SESSION['gf_submit'] = 1;
}

function catalog_admin_menu_setup(){
    add_menu_page( 
        'Speech Databases',
        'Speech Databases',
        'manage_options',
        'otf-catalog-admin',
        'otf_catalog_admin_menu_page',
        'dashicons-editor-ul',
        10
    );
    add_submenu_page(
      'otf-catalog-admin',
      'Pronunciation Lexicons',
      'Pronunciation Lexicons',
      'manage_options',
      'pronunciation-lexicons',
      'pronunciation_lexicons'
    );
    add_submenu_page(
      'otf-catalog-admin',
      'Part of Speech Lexicons',
      'Part of Speech Lexicons',
      'manage_options',
      'part-of-speech-lexicons',
      'part_of_speech_lexicons'
    );
    add_submenu_page(
      'otf-catalog-admin',
      'Other Text Data',
      'Other Text Data',
      'manage_options',
      'other-text-data',
      'other_text_data'
    );
    add_submenu_page(
      'otf-catalog-admin',
      'Export All Data',
      'Export All Data',
      'manage_options',
      'export-all-data',
      'export_all_data'
    );
    add_submenu_page(
      '',
      'OTS Catalog Edit',
      'OTS Catalog Edit',
      'manage_options',
      'otf-catalog-edit',
      'otf_catalog_edit'
    );
    add_submenu_page(
      '',
      'PL Catalog Edit',
      'PL Catalog Edit',
      'manage_options',
      'pl-catalog-edit',
      'pl_catalog_edit'
    );
    add_submenu_page(
      '',
      'PSL Catalog Edit',
      'PSL Catalog Edit',
      'manage_options',
      'psl-catalog-edit',
      'psl_catalog_edit'
    );
    add_submenu_page(
      '',
      'OTD Catalog Edit',
      'OTD Catalog Edit',
      'manage_options',
      'otd-catalog-edit',
      'otd_catalog_edit'
    );
    add_submenu_page(
      '',
      'OTS Catalog Delete',
      'OTS Catalog Delete',
      'manage_options',
      'otf-catalog-delete',
      'otf_catalog_delete'
    );
}
add_action( 'admin_menu', 'catalog_admin_menu_setup' );

function otf_catalog_admin_menu_page() {
  if (isset($_POST["import"])) { 
    global $wpdb;
    $fileName = $_FILES["csvUpload"]["tmp_name"];    
    if ($_FILES["csvUpload"]["size"] > 0) {        
        $file = fopen($fileName, "r");
        $i = 0;        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {            
            if($i != 0 && $column[1] != '') {
              $row = $wpdb->get_row( "SELECT id FROM {$wpdb->prefix}ots_catalog WHERE id = '".$column[0]."'" );
              if(count($row) == 0) {
                $wpdb->insert($wpdb->prefix."ots_catalog",array(
                    "id" => $column[0],
                    "language" => $column[1],
                    "db_name" => $column[2],
                    "product_type1" => $column[3],
                    "product_type2" => $column[4],
                    "environment" => $column[5],
                    "spkrs" => $column[6],
                    "avg_call_length" => $column[7],
                    "prompts_spkr" => $column[8],
                    "utts" => $column[9],
                    "audio_hrs" => $column[10],
                    "khz" => $column[11],
                    "channels" => $column[12],
                    "curr" => $column[13],
                    "price" => $column[14],
                    "brief" => $column[15],
                    "source" => $column[16],
                    "comments" => $column[17]
                  )
                );
                $wpdb->print_error();
              } else {
                $wpdb->update($wpdb->prefix."ots_catalog",array(
                    "language" => $column[1],
                    "db_name" => $column[2],
                    "product_type1" => $column[3],
                    "product_type2" => $column[4],
                    "environment" => $column[5],
                    "spkrs" => $column[6],
                    "avg_call_length" => $column[7],
                    "prompts_spkr" => $column[8],
                    "utts" => $column[9],
                    "audio_hrs" => $column[10],
                    "khz" => $column[11],
                    "channels" => $column[12],
                    "curr" => $column[13],
                    "price" => $column[14],
                    "brief" => $column[15],
                    "source" => $column[16],
                    "comments" => $column[17]
                  ),array('id'=> $row->id)
                );
                $wpdb->print_error();
              }
            }
            /*if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }*/
            $i++;
        }
    }
  }
  ?>
  <link rel='stylesheet' href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' />
  <script type='text/javascript' src='//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'></script>
  <h1><?php _e( 'Speech Databases', 'appen' ); ?></h1>
  <form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="csvUpload" accept=".csv">
    <input type="submit" value="Upload CSV" class="button button-primary" name="import">
    <a class="button button-primary" href="<?php echo admin_url( 'admin-post.php?action=print.csv' ); ?>"><?php _e( 'Download CSV', 'appen' ); ?></a>
  </form>
  <div style="height: 50px;"></div>
  <table id="productCatalog">
    <thead>
      <tr>
        <th>ID</th>
        <th>Language</th>
        <th>DB Name</th>
        <th>Type</th>
        <th>Environment</th>
        <th>Spkrs</th>
        <th>Prompts/spkr</th>
        <th>Total utts/entries</th>
        <th>Audio hrs</th>
        <th>kHz</th>
        <th>Channels</th>
        <th>Price</th>
        <th>Source</th>
      </tr>
    </thead>
    <tbody>
      <?php
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ots_catalog" );
        if(!empty($results)) {
          foreach ($results as $key => $value) {
            ?>
            <tr>
              <td><?php echo $value->id; ?></td>
              <td>
                <strong><?php echo $value->language; ?></strong>
                <br/>
                <a href="<?php echo admin_url('admin.php'); ?>?page=otf-catalog-edit&otf_id=<?php echo $value->id; ?>">Edit</a> | <a href="<?php echo admin_url('admin.php'); ?>?page=otf-catalog-delete&otf_id=<?php echo $value->id; ?>&page_text=otf-catalog-admin">Delete</a>
              </td>
              <td><?php echo $value->db_name; ?></td>
              <td><?php echo $value->product_type2; ?></td>
              <td><?php echo $value->environment; ?></td>
              <td><?php echo $value->spkrs; ?></td>
              <td><?php echo $value->prompts_spkr; ?></td>
              <td><?php echo $value->utts; ?></td>
              <td><?php echo $value->audio_hrs; ?></td>
              <td><?php echo $value->khz; ?></td>
              <td><?php echo $value->channels; ?></td>
              <td><?php echo $value->curr; ?> <?php echo $value->price; ?></td>
              <td><?php echo $value->source; ?></td>
            </tr>
            <?php
          }
        }
      ?>
    </tbody>
  </table>
  <script>
    jQuery(document).ready(function() {
      var table = jQuery('#productCatalog').DataTable();
    });
  </script>
  <?php
}

function otf_catalog_edit() {
  if(isset($_POST['update'])) {
    global $wpdb;
    $wpdb->update($wpdb->prefix."ots_catalog", 
      array('language'=>$_POST['language'],
            'db_name'=>$_POST['db_name'],
            'product_type1'=>$_POST['product_type1'],
            'product_type2'=>$_POST['product_type2'],
            'environment'=>$_POST['environment'],
            'spkrs'=>$_POST['spkrs'],
            'avg_call_length'=>$_POST['avg_call_length'],
            'prompts_spkr'=>$_POST['prompts_spkr'],
            'utts'=>$_POST['utts'],
            'audio_hrs'=>$_POST['audio_hrs'],
            'khz'=>$_POST['khz'],
            'channels'=>$_POST['channels'],
            'curr'=>$_POST['curr'],
            'price'=>$_POST['price'],
            'brief'=>$_POST['brief'],
            'source'=>$_POST['source'],
            'comments'=>$_POST['comments']
            ),
        array('id'=>$_POST['ots_id'])
      );
    echo '<div>Update Successfull</div>';
  }
  if(isset($_GET['otf_id'])) {
    global $wpdb;
    $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}ots_catalog WHERE id = ".$_GET['otf_id'] );
    if($row) {
    ?>
    <h1>Edit OTS Catalog </h1>
    <form method="POST" action="">
      <p>
        <input type="hidden" name="ots_id" value="<?php echo $row->id; ?>" />
        <label>Language:</label><br/> <input type="text" name="language" value="<?php echo $row->language; ?>" /><br/>
        <label>DB Name:</label><br/> <input type="text" name="db_name" value="<?php echo $row->db_name; ?>" /><br/>
        <label>Product Type 1:</label><br/> <input type="text" name="product_type1" value="<?php echo $row->product_type1; ?>" /><br/>
        <label>Product Type 2:</label><br/> <input type="text" name="product_type2" value="<?php echo $row->product_type2; ?>" /><br/>
        <label>Environment:</label><br/> <input type="text" name="environment" value="<?php echo $row->environment; ?>" /><br/>
        <label>Speaker:</label><br/> <input type="text" name="spkrs" value="<?php echo $row->spkrs; ?>" /><br/>
        <label>Avg length of call/session:</label><br/> <input type="text" name="avg_call_length" value="<?php echo $row->avg_call_length; ?>" /><br/>
        <label>Prompts/spkr:</label><br/> <input type="text" name="prompts_spkr" value="<?php echo $row->prompts_spkr; ?>" /><br/>
        <label>Utterances:</label><br/> <input type="text" name="utts" value="<?php echo $row->utts; ?>" /><br/>
        <label>Audio Hrs:</label><br/> <input type="text" name="audio_hrs" value="<?php echo $row->audio_hrs; ?>" /><br/>
        <label>kHz:</label><br/> <input type="text" name="khz" value="<?php echo $row->khz; ?>" /><br/>
        <label>Channels:</label><br/> <input type="text" name="channels" value="<?php echo $row->channels; ?>" /><br/>
        <label>Currency:</label><br/> <input type="text" name="curr" value="<?php echo $row->curr; ?>" /><br/>
        <label>Price:</label><br/> <input type="text" name="price" value="<?php echo $row->price; ?>" /><br/>
        <label>Description</label><br/> <textarea name="brief"><?php echo $row->brief; ?></textarea><br/>
        <label>Source:</label><br/> <input type="text" name="source" value="<?php echo $row->source; ?>" /><br/>
        <label>Appen Comments</label><br/> <textarea name="comments"><?php echo $row->comments; ?></textarea>
      </p>
      <input type="submit" name="update" class="button button-primary" value="Update" />
    </form>
    <style>
      label {
        font-weight: bold;
      }
      input:not([type="submit"]), textarea {
        width: 400px;
      }
      textarea {
        height: 200px;
      }
    </style>
    <?php
    }
  }
}

function otf_catalog_delete() {
  if(isset($_GET['otf_id'])) {
    global $wpdb;
    if($_GET['page_text'] == 'otf-catalog-admin') {
      $table = "ots_catalog";
    } elseif($_GET['page_text'] == 'pronunciation-lexicons') {
      $table = "pronunciation_lexicons";
    } elseif($_GET['page_text'] == 'part-of-speech-lexicons') {
      $table = "part_of_speech_lexicons";
    } elseif($_GET['page_text'] == 'other-text-data') {
      $table = "other_text_data";
    } else {
      $table = "ots_catalog";
    }
    $wpdb->delete( $wpdb->prefix.$table, array( 'id' => $_GET['otf_id'] ) );
  }
  header('Location: '.admin_url('admin.php').'?page='.$_GET['page_text']);
  //exit;
}

function pronunciation_lexicons() {
  if (isset($_POST["import"])) { 
    global $wpdb;
    $fileName = $_FILES["csvUpload"]["tmp_name"];    
    if ($_FILES["csvUpload"]["size"] > 0) {        
        $file = fopen($fileName, "r");
        $i = 0;        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {            
            if($i > 0) {
                $row = $wpdb->get_row( "SELECT id FROM {$wpdb->prefix}pronunciation_lexicons WHERE id = '".$column[0]."'" );
                if(count($row) == 0) {
                  $wpdb->insert($wpdb->prefix."pronunciation_lexicons",array(
                      "id" => $column[0],
                      "language" => $column[1],
                      "num_of_words" => $column[2],
                      "category_pronunciations" => $column[3],
                      "license_price" => $column[4],
                      "product" => $column[5],
                      "comment" => $column[6]
                    )
                  );
                  $wpdb->print_error();
                } else {
                  $wpdb->update($wpdb->prefix."pronunciation_lexicons",array(
                      "language" => $column[1],
                      "num_of_words" => $column[2],
                      "category_pronunciations" => $column[3],
                      "license_price" => $column[4],
                      "product" => $column[5],
                      "comment" => $column[6]
                    ),array('id'=> $row->id)
                  );
                  $wpdb->print_error();
                }
            }
            /*if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }*/
            $i++;
        }
    }
  }
  ?>
  <link rel='stylesheet' href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' />
  <script type='text/javascript' src='//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'></script>
  <h1><?php _e( 'Pronunciation Lexicons', 'appen' ); ?></h1>
  <form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="csvUpload" accept=".csv">
    <input type="submit" value="Upload CSV" class="button button-primary" name="import">
    <a class="button button-primary" href="<?php echo admin_url( 'admin-post.php?action=print_pl.csv' ); ?>"><?php _e( 'Download CSV', 'appen' ); ?></a>
  </form>
  <div style="height: 50px;"></div>
  <table id="productCatalog">
    <thead>
      <tr>
        <th>ID</th>
        <th>Language</th>
        <th>Estimated Number of Words</th>
        <th>License Pricing Category - Pronunciations</th>
        <th>License Price per Word (USD)</th>
        <th>Product</th>
        <th>Comment</th>
      </tr>
    </thead>
    <tbody>
      <?php
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pronunciation_lexicons" );
        if(!empty($results)) {
          foreach ($results as $key => $value) {
            ?>
            <tr>
              <td><?php echo $value->id; ?></td>
              <td>
                <strong><?php echo $value->language; ?></strong>
                <br/>
                <a href="<?php echo admin_url('admin.php'); ?>?page=pl-catalog-edit&otf_id=<?php echo $value->id; ?>">Edit</a> | <a href="<?php echo admin_url('admin.php'); ?>?page=otf-catalog-delete&otf_id=<?php echo $value->id; ?>&page_text=pronunciation-lexicons">Delete</a>
              </td>
              <td><?php echo $value->num_of_words; ?></td>
              <td><?php echo $value->category_pronunciations; ?></td>
              <td><?php echo $value->license_price; ?></td>
              <td><?php echo $value->product; ?></td>
              <td><?php echo $value->comment; ?></td>
            </tr>
            <?php
          }
        }
      ?>
    </tbody>
  </table>
  <script>
    jQuery(document).ready(function() {
      var table = jQuery('#productCatalog').DataTable();
    });
  </script>
  <?php
}

function pl_catalog_edit() {
  if(isset($_POST['update'])) {
    global $wpdb;
    $wpdb->update($wpdb->prefix."pronunciation_lexicons", 
      array('language'=>$_POST['language'],
            'num_of_words'=>$_POST['num_of_words'],
            'category_pronunciations'=>$_POST['category_pronunciations'],
            'license_price'=>$_POST['license_price'],
            'product'=>$_POST['product'],
            'comment'=>$_POST['comment'],
            ),
        array('id'=>$_POST['ots_id'])
      );
    echo '<div>Update Successfull</div>';
  }
  if(isset($_GET['otf_id'])) {
    global $wpdb;
    $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}pronunciation_lexicons WHERE id = ".$_GET['otf_id'] );
    if($row) {
    ?>
    <h1>Edit Pronunciation Lexicons</h1>
    <form method="POST" action="">
      <p>
        <input type="hidden" name="ots_id" value="<?php echo $row->id; ?>" />
        <label>Language:</label><br/> <input type="text" name="language" value="<?php echo $row->language; ?>" /><br/>
        <label>Number of words:</label><br/> <input type="text" name="num_of_words" value="<?php echo $row->num_of_words; ?>" /><br/>
        <label>Category Pronunciations:</label><br/> <input type="text" name="category_pronunciations" value="<?php echo $row->category_pronunciations; ?>" /><br/>
        <label>License Price:</label><br/> <input type="text" name="license_price" value="<?php echo $row->license_price; ?>" /><br/>
        <label>Product:</label><br/> <input type="text" name="product" value="<?php echo $row->product; ?>" /><br/>
        <label>Comment</label><br/> <textarea name="comment"><?php echo $row->comment; ?></textarea>
      </p>
      <input type="submit" name="update" class="button button-primary" value="Update" />
    </form>
    <style>
      label {
        font-weight: bold;
      }
      input:not([type="submit"]), textarea {
        width: 400px;
      }
      textarea {
        height: 200px;
      }
    </style>
    <?php
    }
  }
}

function part_of_speech_lexicons() {
  if (isset($_POST["import"])) { 
    global $wpdb;
    $fileName = $_FILES["csvUpload"]["tmp_name"];    
    if ($_FILES["csvUpload"]["size"] > 0) {        
        $file = fopen($fileName, "r");
        $i = 0;        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {  
            if($i > 0) {
                $row = $wpdb->get_row( "SELECT id FROM {$wpdb->prefix}part_of_speech_lexicons WHERE id = '".$column[0]."'" );
                if(count($row) == 0) {
                  $wpdb->insert($wpdb->prefix."part_of_speech_lexicons",array(
                      "id" => $column[0],
                      "language" => $column[1],
                      "num_of_words" => $column[2],
                      "product" => $column[3],
                      "comment" => $column[4]
                    )
                  );
                  $wpdb->print_error();
                } else {
                  $wpdb->update($wpdb->prefix."part_of_speech_lexicons",array(
                      "language" => $column[1],
                      "num_of_words" => $column[2],
                      "product" => $column[3],
                      "comment" => $column[4]
                    ),array('id'=> $row->id)
                  );
                }
            }
            /*if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }*/
            $i++;
        }
    }
  }
  ?>
  <link rel='stylesheet' href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' />
  <script type='text/javascript' src='//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'></script>
  <h1><?php _e( 'Part of Speech Lexicons', 'appen' ); ?></h1>
  <form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="csvUpload" accept=".csv">
    <input type="submit" value="Upload CSV" class="button button-primary" name="import">
    <a class="button button-primary" href="<?php echo admin_url( 'admin-post.php?action=print_sl.csv' ); ?>"><?php _e( 'Download CSV', 'appen' ); ?></a>
  </form>
  <div style="height: 50px;"></div>
  <table id="productCatalog">
    <thead>
      <tr>
        <th>ID</th>
        <th>Language</th>
        <th>Estimated Number of Words</th>
        <th>Product</th>
        <th>Comment</th>
      </tr>
    </thead>
    <tbody>
      <?php
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}part_of_speech_lexicons" );
        if(!empty($results)) {
          foreach ($results as $key => $value) {
            ?>
            <tr>
              <td><?php echo $value->id; ?></td>
              <td>
                <strong><?php echo $value->language; ?></strong>
                <br/>
                <a href="<?php echo admin_url('admin.php'); ?>?page=psl-catalog-edit&otf_id=<?php echo $value->id; ?>">Edit</a> | <a href="<?php echo admin_url('admin.php'); ?>?page=otf-catalog-delete&otf_id=<?php echo $value->id; ?>&page_text=part-of-speech-lexicons">Delete</a>
              </td>
              <td><?php echo $value->num_of_words; ?></td>
              <td><?php echo $value->product; ?></td>
              <td><?php echo $value->comment; ?></td>
            </tr>
            <?php
          }
        }
      ?>
    </tbody>
  </table>
  <script>
    jQuery(document).ready(function() {
      var table = jQuery('#productCatalog').DataTable();
    });
  </script>
  <?php
}

function psl_catalog_edit() {
  if(isset($_POST['update'])) {
    global $wpdb;
    $wpdb->update($wpdb->prefix."part_of_speech_lexicons", 
      array('language'=>$_POST['language'],
            'num_of_words'=>$_POST['num_of_words'],
            'product'=>$_POST['product'],
            'comment'=>$_POST['comment'],
            ),
        array('id'=>$_POST['ots_id'])
      );
    echo '<div>Update Successfull</div>';
  }
  if(isset($_GET['otf_id'])) {
    global $wpdb;
    $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}part_of_speech_lexicons WHERE id = ".$_GET['otf_id'] );
    if($row) {
    ?>
    <h1>Edit Part of Speech Lexicons</h1>
    <form method="POST" action="">
      <p>
        <input type="hidden" name="ots_id" value="<?php echo $row->id; ?>" />
        <label>Language:</label><br/> <input type="text" name="language" value="<?php echo $row->language; ?>" /><br/>
        <label>Number of words:</label><br/> <input type="text" name="num_of_words" value="<?php echo $row->num_of_words; ?>" /><br/>
        <label>Product:</label><br/> <input type="text" name="product" value="<?php echo $row->product; ?>" /><br/>
        <label>Comment</label><br/> <textarea name="comment"><?php echo $row->comment; ?></textarea>
      </p>
      <input type="submit" name="update" class="button button-primary" value="Update" />
    </form>
    <style>
      label {
        font-weight: bold;
      }
      input:not([type="submit"]), textarea {
        width: 400px;
      }
      textarea {
        height: 200px;
      }
    </style>
    <?php
    }
  }
}

function other_text_data() {
  if (isset($_POST["import"])) { 
    global $wpdb;
    $fileName = $_FILES["csvUpload"]["tmp_name"];    
    if ($_FILES["csvUpload"]["size"] > 0) {        
        $file = fopen($fileName, "r");
        $i = 0;        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {            
            if($i > 0) {
                $row = $wpdb->get_row( "SELECT id FROM {$wpdb->prefix}other_text_data WHERE id = '".$column[0]."'" );
                if(count($row) == 0) {
                  $wpdb->insert($wpdb->prefix."other_text_data",array(
                      "id" => $column[0],
                      "language" => $column[1],
                      "corpus_type" => $column[2],
                    )
                  );
                  $wpdb->print_error();
                } else {
                  $wpdb->update($wpdb->prefix."other_text_data",array(
                     "language" => $column[1],
                      "corpus_type" => $column[2],
                    ),array('id'=> $row->id)
                  );
                }
            }
            /*if (! empty($result)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }*/
            $i++;
        }
    }
  }
  ?>
  <link rel='stylesheet' href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' />
  <script type='text/javascript' src='//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js'></script>
  <h1><?php _e( 'Other text data', 'appen' ); ?></h1>
  <form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="csvUpload" accept=".csv">
    <input type="submit" value="Upload CSV" class="button button-primary" name="import">
    <a class="button button-primary" href="<?php echo admin_url( 'admin-post.php?action=print_otd.csv' ); ?>"><?php _e( 'Download CSV', 'appen' ); ?></a>
  </form>
  <div style="height: 50px;"></div>
  <table id="productCatalog">
    <thead>
      <tr>
        <th>ID</th>
        <th>Language</th>
        <th>Corpus Type</th>
      </tr>
    </thead>
    <tbody>
      <?php
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}other_text_data" );
        if(!empty($results)) {
          foreach ($results as $key => $value) {
            ?>
            <tr>
              <td><?php echo $value->id; ?></td>
              <td>
                <strong><?php echo $value->language; ?></strong>
                <br/>
                <a href="<?php echo admin_url('admin.php'); ?>?page=otd-catalog-edit&otf_id=<?php echo $value->id; ?>">Edit</a> | <a href="<?php echo admin_url('admin.php'); ?>?page=otf-catalog-delete&otf_id=<?php echo $value->id; ?>&page_text=other-text-data">Delete</a>
              </td>
              <td><?php echo $value->corpus_type; ?></td>
            </tr>
            <?php
          }
        }
      ?>
    </tbody>
  </table>
  <script>
    jQuery(document).ready(function() {
      var table = jQuery('#productCatalog').DataTable();
    });
  </script>
  <?php
}

function otd_catalog_edit() {
  if(isset($_POST['update'])) {
    global $wpdb;
    $wpdb->update($wpdb->prefix."other_text_data", 
      array('language'=>$_POST['language'],
            'corpus_type'=>$_POST['corpus_type'],
            ),
        array('id'=>$_POST['ots_id'])
      );
    echo '<div>Update Successfull</div>';
  }
  if(isset($_GET['otf_id'])) {
    global $wpdb;
    $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}other_text_data WHERE id = ".$_GET['otf_id'] );
    if($row) {
    ?>
    <h1>Edit Other text data</h1>
    <form method="POST" action="">
      <p>
        <input type="hidden" name="ots_id" value="<?php echo $row->id; ?>" />
        <label>Language:</label><br/> <input type="text" name="language" value="<?php echo $row->language; ?>" /><br/>
        <label>Corpus Type:</label><br/> <input type="text" name="corpus_type" value="<?php echo $row->corpus_type; ?>" /><br/>
      </p>
      <input type="submit" name="update" class="button button-primary" value="Update" />
    </form>
    <style>
      label {
        font-weight: bold;
      }
      input:not([type="submit"]), textarea {
        width: 400px;
      }
      textarea {
        height: 200px;
      }
    </style>
    <?php
    }
  }
}

add_action( 'admin_post_print.csv', 'print_csv' );

function print_csv()
{
    if ( ! current_user_can( 'manage_options' ) )
        return;

    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename=OTS-Catalog-'.date('Y-m-d').'.csv');
    header('Pragma: no-cache');
  global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ots_catalog",  ARRAY_A);
    if(!empty($results)) {
      $output = fopen("php://output", "wb");
      
      fputcsv($output, array(
                  'Unique ID',
                  'Language',
                  'DB Name',
                  'Type 1',
                  'Type 2',
                  'Environment',
                  'Spkrs',
                  'Avg length of call/session',
                  'Prompts/spkr',
                  'Total utts/entries',
                  'Audio hrs',
                  'kHz',
                  'Channels',
                  'Curr',
                  'List Price (Orig)',
                  'Brief Description',
                  'Source',
                  'Appen Comments'));
      //print_r($results);
      foreach($results as $key => $val) {
        if(!empty($val)) {
              fputcsv($output, $val);
          }
      }
      fclose($output);
    }
    // output the CSV data
}

add_action( 'admin_post_print_pl.csv', 'print_csv_pl' );

function print_csv_pl()
{
    if ( ! current_user_can( 'manage_options' ) )
        return;

    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename=pronunciation-lexicons-'.date('Y-m-d').'.csv');
    header('Pragma: no-cache');
  global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pronunciation_lexicons",  ARRAY_A);
    if(!empty($results)) {
      $output = fopen("php://output", "wb");
      
      fputcsv($output, array(                  
                  'Unique ID',
                  'Language',
                  'Estimated Number of Words',
                  'License Pricing Category - Pronunciations',
                  'License Price per Word (USD)',
                  'Product',
                  'Comment'
                  ));
      //print_r($results);
      foreach($results as $key => $val) {
        if(!empty($val)) {
          fputcsv($output, $val);
        }
      }
      fclose($output);
    }
    // output the CSV data
}

add_action( 'admin_post_print_sl.csv', 'print_csv_sl' );

function print_csv_sl()
{
    if ( ! current_user_can( 'manage_options' ) )
        return;

    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename=part-of-speech-lexicons-'.date('Y-m-d').'.csv');
    header('Pragma: no-cache');
  global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}part_of_speech_lexicons",  ARRAY_A);
    if(!empty($results)) {
      $output = fopen("php://output", "wb");
      
      fputcsv($output, array(
                  'Unique ID',                  
                  'Language',
                  'Estimated Number of Words',
                  'Product',
                  'Comment'
                  ));
      //print_r($results);
      foreach($results as $key => $val) {
        if(!empty($val)) {
          fputcsv($output, $val);
        }
      }
      fclose($output);
    }
    // output the CSV data
}
add_action( 'admin_post_print_otd.csv', 'print_csv_otd' );

function print_csv_otd()
{
    if ( ! current_user_can( 'manage_options' ) )
        return;

    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename=other-text-data-'.date('Y-m-d').'.csv');
    header('Pragma: no-cache');
  global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}other_text_data",  ARRAY_A);
    if(!empty($results)) {
      $output = fopen("php://output", "wb");
      
      fputcsv($output, array(
                  'Unique ID',                  
                  'Language',
                  'Corpus Type'
                  ));
      //print_r($results);
      foreach($results as $key => $val) {
        if(!empty($val)) {
          fputcsv($output, $val);
        }
      }
      fclose($output);
    }
    // output the CSV data
}

/* Export OTS data to excelsheet */
require STYLESHEETPATH.'/custom/PhpSpreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
function export_all_data() {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  $char_ar = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R');

  $spreadsheet = new Spreadsheet();
  $sheetIndex = $spreadsheet->getIndex( $spreadsheet->getSheetByName('Worksheet') );
  $spreadsheet->removeSheetByIndex($sheetIndex);

  $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'SpeechDB');
  $spreadsheet->addSheet($myWorkSheet, 0);

  global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ots_catalog",  ARRAY_A);
    if(!empty($results)) {
    $sheet = $spreadsheet->getSheetByName('SpeechDB');

    $sheet->setCellValue('A1', 'Unique ID');
    $sheet->setCellValue('B1', 'Language');
    $sheet->setCellValue('C1', 'DB Name');
    $sheet->setCellValue('D1', 'Type 1');
    $sheet->setCellValue('E1', 'Type 2');
    $sheet->setCellValue('F1', 'Environment');
    $sheet->setCellValue('G1', 'Spkrs');
    $sheet->setCellValue('H1', 'Avg length of call/session');
    $sheet->setCellValue('I1', 'Prompts/spkr');
    $sheet->setCellValue('J1', 'Total utts/entries');
    $sheet->setCellValue('K1', 'Audio hrs');
    $sheet->setCellValue('L1', 'kHz');
    $sheet->setCellValue('M1', 'Channels');
    $sheet->setCellValue('N1', 'Curr');
    $sheet->setCellValue('O1', 'List Price (Orig)');
    $sheet->setCellValue('P1', 'Brief Description');
    $sheet->setCellValue('Q1', 'Source');
    $sheet->setCellValue('R1', 'Appen Comments');

    foreach($results as $key => $val) {
      if(!empty($val)) {
        $i = 0;
        foreach($val as $v) {
          $char = $char_ar[$i];
            $sheet->setCellValue($char.($key+2), $v);
            $i++;         
        }
      }
      }
  }

  $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'PronunciationLexicons');
  $spreadsheet->addSheet($myWorkSheet, 1);

  global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}pronunciation_lexicons",  ARRAY_A);
    if(!empty($results)) {
    $sheet = $spreadsheet->getSheetByName('PronunciationLexicons');

    $sheet->setCellValue('A1', 'Unique ID');
    $sheet->setCellValue('B1', 'Language');
    $sheet->setCellValue('C1', 'Estimated Number of Words');
    $sheet->setCellValue('D1', 'License Pricing Category - Pronunciations');
    $sheet->setCellValue('E1', 'License Price per Word (USD)');
    $sheet->setCellValue('F1', 'Product');
    $sheet->setCellValue('G1', 'Comment');

    foreach($results as $key => $val) {
      if(!empty($val)) {
        $i = 0;
        foreach($val as $v) {
          $char = $char_ar[$i];
            $sheet->setCellValue($char.($key+2), $v);
            $i++;         
        }
      }
      }
  }

  $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'PartOfSpeechLexicons');
  $spreadsheet->addSheet($myWorkSheet, 2);

  global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}part_of_speech_lexicons",  ARRAY_A);
    if(!empty($results)) {
    $sheet = $spreadsheet->getSheetByName('PartOfSpeechLexicons');

    $sheet->setCellValue('A1', 'Unique ID');
    $sheet->setCellValue('B1', 'Language');
    $sheet->setCellValue('C1', 'Estimated Number of Words');
    $sheet->setCellValue('D1', 'Product');
    $sheet->setCellValue('E1', 'Comment');

    foreach($results as $key => $val) {
      if(!empty($val)) {
        $i = 0;
        foreach($val as $v) {
          $char = $char_ar[$i];
            $sheet->setCellValue($char.($key+2), $v);
            $i++;         
        }
      }
      }
  }

  $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'OtherTextData');
  $spreadsheet->addSheet($myWorkSheet, 3);

  global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}other_text_data",  ARRAY_A);
    if(!empty($results)) {
    $sheet = $spreadsheet->getSheetByName('OtherTextData');

    $sheet->setCellValue('A1', 'Unique ID');
    $sheet->setCellValue('B1', 'Language');
    $sheet->setCellValue('C1', 'Corpus Type');

    foreach($results as $key => $val) {
      if(!empty($val)) {
        $i = 0;
        foreach($val as $v) {
          $char = $char_ar[$i];
            $sheet->setCellValue($char.($key+2), $v);
            $i++;         
        }
      }
      }
  }

  $writer = new Xlsx($spreadsheet);
  $fileName = 'AppenOTSCatalog'.date('Y-m-d');
  $filePath = STYLESHEETPATH.'/custom/xlsx/'.$fileName.'.xlsx';
  $writer->save($filePath);
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$fileName.'.xlsx"');
  header('Cache-Control: max-age=0');
  ob_clean();
    flush();
  readfile($filePath);
  unlink($filePath);
    exit;
}

function ots_rewrite_tag() {
  add_rewrite_tag('%tableots%', '([^&]+)');
  add_rewrite_tag('%slugots%', '([^&]+)');
}
add_action('init', 'ots_rewrite_tag', 10, 0);

add_action( 'init', 'ots_rewrite_rules', 10, 0 );
function ots_rewrite_rules() {  
  add_rewrite_rule(
      '^speech-language-datasets/product-catalog/([^/]*)/([^/]*)/?',
      'index.php?page_id=31434&tableots=$matches[1]&slugots=$matches[2]',
      'top' // The rule position; either 'top' or 'bottom' (default).
  );
}