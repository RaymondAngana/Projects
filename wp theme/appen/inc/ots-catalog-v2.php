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
  print_r($_SESSION['catalog_cart']);
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
  print_r($_SESSION['catalog_cart']);
  wp_die();
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
      $dataset = '';
      $product = '';
      $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}ots_catalog_2 WHERE id = ".$value );
      if($row) {
        $dataset_name = $row->dataset_name;
        $dataset_id = $row->dataset_id;
        $dataset_name .= ' - ('.$dataset_id.')';
        array_push($catalog_cart, $dataset_name);
      }
    }
    $return_ar['catalog_cart'] = implode(', ', $catalog_cart);

    echo json_encode($return_ar);
  }
  wp_die();
}

function my_wp_is_mobile() {
  static $is_mobile;

  if ( isset($is_mobile) )
      return $is_mobile;

  if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
      $is_mobile = false;
  } elseif (
      strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
      || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
      || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
      || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
      || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false ) {
          $is_mobile = true;
  } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false && strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') == false) {
          $is_mobile = true;
  } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {
      $is_mobile = false;
  } else {
      $is_mobile = false;
  }

  return $is_mobile;
}

function ots_table($atts,$content=null){
  $a = shortcode_atts(
    array(
    ),$atts);
ob_start();
session_start();
?>
<div class="x-container request_wrap">
  <div class="x-column x-sm x-1-2 catalog-search">
  </div>
  <div class="x-column x-sm x-1-2 catalog-curved">
    <?php
      $count = 0;
      if(isset($_SESSION['catalog_cart'])) {
        $count = count($_SESSION['catalog_cart']);
      }
    ?>
    <a class="btn_curved request-quote" href="<?php bloginfo('url'); ?>/products/pre-labeled-datasets/product-catalog/" data-cart="0">Request Quote<span><?php echo $count; ?></span></a>
  </div> 
</div>
<div class="table-fix">
  <table>
    <thead>
      <tr>
        <th class="productCatalog__name">Dataset Name</th>
        <th class="productCatalog__products">Product Type</th>
        <th class="productCatalog__use">Common Use Cases</th>
        <th class="productCatalog__device">Recording Device</th>
        <th class="productCatalog__unit">Unit</th>
        <th class="productCatalog__quote text-hide"></th>
      </tr>
    </thead>
  </table>
</div>
<div class="x-container" style="z-index: 20; padding-bottom: 0;">
  <div class="filter_wrap">
    <div class="resourses-filter ots-filter">
      <div class="resourses-filter__top">
        <button class="resourses-filter__drop js-filter-drop">Filter By</button>
        <?php if(!my_wp_is_mobile()) { ?>
          <div class="resourses-filter__active" style="display: block;"></div>
        <?php } ?>
        <div class="custom_search_outer desk_search">
          <form class="catalog_table_search_form" class="custom_searc_section ots_search_form" method="get" action="">
              <input type="text" class="frm_search" name="s" placeholder="Search" style="outline: none;">
              <button type="submit" class="btn btn-success">
                  <i class="la la-search"></i>
              </button>
          </form>
        </div>
      </div>
      <div class="menu-resources-filter-container js-filter-content">
        <ul class="menu">
          <li class="menu-item menu-item-has-children">
            <a data-category="aa">Product Type</a>
            <ul class="sub-menu">
              <li class="menu-item"><a data-category="product">Audio</a></li>
              <li class="menu-item"><a data-category="product">Image</a></li>
              <li class="menu-item"><a data-category="product">Text</a></li>
              <li class="menu-item"><a data-category="product">Video</a></li>
            </ul>
          </li>
          <li class="menu-item menu-item-has-children lang-menu-filter">
            <a data-category="aa">Language</a>
            <ul class="sub-menu three-part">
              <li class="menu-item"><a data-category="language">A</a></li>
              <li class="menu-item"><a data-category="language">B</a></li>
              <li class="menu-item"><a data-category="language">C</a></li>
              <li class="menu-item"><a data-category="language">D</a></li>
              <li class="menu-item"><a data-category="language">E</a></li>
              <li class="menu-item"><a data-category="language">F</a></li>
              <li class="menu-item"><a data-category="language">G</a></li>
              <li class="menu-item"><a data-category="language">H</a></li>
              <li class="menu-item"><a data-category="language">I</a></li>
              <li class="menu-item"><a data-category="language">J</a></li>
              <li class="menu-item"><a data-category="language">K</a></li>
              <li class="menu-item"><a data-category="language">L</a></li>
              <li class="menu-item"><a data-category="language">M</a></li>
              <li class="menu-item"><a data-category="language">N</a></li>
              <li class="menu-item"><a data-category="language">O</a></li>
              <li class="menu-item"><a data-category="language">P</a></li>
              <li class="menu-item"><a data-category="language">R</a></li>
              <li class="menu-item"><a data-category="language">S</a></li>
              <li class="menu-item"><a data-category="language">T</a></li>
              <li class="menu-item"><a data-category="language">U</a></li>
              <li class="menu-item"><a data-category="language">V</a></li>
              <li class="menu-item"><a data-category="language">W</a></li>
              <li class="menu-item"><a data-category="language">X</a></li>
              <li class="menu-item"><a data-category="language">Z</a></li>
            </ul>
          </li>
          <li class="menu-item menu-item-has-children use-menu-filter">
            <a data-category="aa">Common Use Case</a>
            <ul class="sub-menu">
              <li class="menu-item"><a data-category="use">ASR</a></li>
              <li class="menu-item"><a data-category="use">Action Classification</a></li>
              <li class="menu-item"><a data-category="use">Automatic Captioning</a></li>
              <li class="menu-item"><a data-category="use">Baby Monitor</a></li>
              <li class="menu-item"><a data-category="use">Call Centre</a></li>
              <li class="menu-item"><a data-category="use">Chatbot</a></li>
              <li class="menu-item"><a data-category="use">Content Classification</a></li>
              <li class="menu-item"><a data-category="use">Conversational AI</a></li>
              <li class="menu-item"><a data-category="use">Document Processing</a></li>
              <li class="menu-item"><a data-category="use">Document Search</a></li>
              <li class="menu-item"><a data-category="use">Facial Recognition</a></li>
              <li class="menu-item"><a data-category="use">Fitness Applications</a></li>
              <li class="menu-item"><a data-category="use">Gesture Recognition</a></li>
              <li class="menu-item"><a data-category="use">In Car HMI & Entertainment</a></li>
              <li class="menu-item"><a data-category="use">Keyword Spotting</a></li>
              <li class="menu-item"><a data-category="use">Language Modelling</a></li>
              <li class="menu-item"><a data-category="use">MT</a></li>
              <li class="menu-item"><a data-category="use">NER</a></li>
              <li class="menu-item"><a data-category="use">Search Engines</a></li>
              <li class="menu-item"><a data-category="use">Security & Other Consumer Applications</a></li>
              <li class="menu-item"><a data-category="use">Speech Analytics</a></li>
              <li class="menu-item"><a data-category="use">TTS</a></li>
              <li class="menu-item"><a data-category="use">Virtual Assistant</a></li>
            </ul>
          </li>
          <a class="js-reset-filter" style="display: none;">Reset Filter</a>
        </ul>
      </div>
    </div>
  </div>
  <?php if(my_wp_is_mobile()) { ?>
    <div class="resourses-filter__active mob_search"></div>
  <?php } ?>
</div>
<div class="table_head_mobile"></div>
<table id="productCatalog">
  <thead>
    <tr>
      <th></th>
      <th class="productCatalog__name">Dataset Name</th>
      <th class="productCatalog__products">Product Type</th>
      <th class="productCatalog__use">Common Use Cases</th>
      <th class="productCatalog__device">Recording Device</th>
      <th class="productCatalog__unit">Unit</th>
      <th class="productCatalog__quote text-hide"></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ots_catalog_2 ORDER BY `dataset_name` ASC" );
    if(!empty($results)) {
    foreach($results as $row) {
    ?>
    <tr>
      <td><?php echo $row->id; ?></td>
    <td>
        <div class="ots__name">
          <?php
          switch ($row->product_type) {
            case "Audio":
              $img_type = 'ots-sound';
              break;
            case "Video":
              $img_type = 'ots-video';
              break;
            case "Text":
              $img_type = 'ots-text';
              break;
            case "Image":
              $img_type = 'ots-image';
              break;
            default:
              $img_type = 'ots-na';
          }
          ?>
        <a class="ots__down" href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/custom/images/ots-down.png" alt="Down arrow"></a>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/custom/images/<?php echo $img_type; ?>.png" alt="Product Type <?php echo $img_type; ?>">
        <span><?php echo $row->dataset_name; ?></span>
          </div>
    </td>
    <td><?php echo $row->product_type; ?></td>
    <td>
      <?php
        if(!empty($row->common_use_cases)) {
          $common_use_cases = explode('|', $row->common_use_cases);
          echo implode(', ', $common_use_cases);
        }
      ?>      
    </td>
    <td><?php echo $row->recording_device; ?></td>
    <td><?php echo $row->unit; ?></td>
    <td>
      <?php if(!empty($_SESSION['catalog_cart'])) { ?>
        <?php if(!in_array($row->id, $_SESSION['catalog_cart'])) { ?>
          <a class="js-quote add_quote" data-id="<?php echo $row->id; ?>" href="#">Add</a>
        <?php } else { ?>
          <a class="js-quote remove_quote" data-id="<?php echo $row->id; ?>" href="#">Remove</a>
        <?php } ?>
      <?php } else { ?>
        <a class="js-quote add_quote" data-id="<?php echo $row->id; ?>" href="#">Add</a>
      <?php } ?>
    </td>
    <td><?php echo $row->dataset_id; ?></td>
    <td><?php echo $row->source; ?></td>
    <td><?php echo $row->detailed_product_type; ?></td>
    <td><?php echo $row->language; ?></td>
    <td><?php echo $row->country; ?></td>
    <td><?php echo $row->recording_condition; ?></td>
    <td><?php echo $row->contributors; ?></td>
    <td><?php echo $row->channels; ?></td>
    <td><?php echo $row->utterances; ?></td>
    <td><?php echo $row->unique_word; ?></td>
    <td><?php echo $row->sample_rate; ?></td>
    <td><?php echo $row->data_format; ?></td>
    <td><?php echo str_replace('|', '<br/>', $row->additional_info); ?></td>
    <td><?php echo $row->dataset_name; ?></td>
    </tr>
  <?php } } ?>
  </tbody>
</table>

<script>
  jQuery(document).ready(function() {
    var dataTableOptions;
    if(jQuery(window).width() >= 992) {
      dataTableOptions = {
        responsive: false,
        "ordering": false,
        "pagingType": "simple",
        "pageLength": 10,
        "columns": [
            { 
              "data": "id",
              "orderable": false,
              "visible": false
            },
            {
                "orderable": false,
                "data": "name"
            },
            { 
              "data": "product",
              "orderable": false,
            },
            { 
              "data": "use",
              "orderable": false,
            },
            { 
              "data": "device" ,
              "orderable": false,
            },
            { 
              "data": "unit",
              "orderable": false,
            },
            { 
              "data": "quote",
              "orderable": false,
            },
            { 
              "data": "dataset",
              "orderable": false,
              "visible": false
            },
            { 
              "data": "source",
              "orderable": false,
              "visible": false
            },
            { 
              "data": "detailed_product_type",
              "orderable": false,
              "visible": false
            },
            { 
              "data": "language",
              "orderable": false,
              "visible": false
            },
            { 
              "data": "country",
              "orderable": false,
              "visible": false
            },
            { 
              "data": "recording",
              "orderable": false,
              "visible": false
            },
            { 
              "data": "contributors",
              "orderable": false,
              "visible": false
            },
            { 
              "data": "channels",
              "orderable": false,
              "visible": false
            },
            { 
              "data": "utterances",
              "orderable": false,
              "visible": false
            },
            { 
              "data": "words",
              "orderable": false,
              "visible": false,
            },
            { 
              "data": "rate",
              "orderable": false,
              "visible": false
            },
            { 
              "data": "format",
              "orderable": false,
              "visible": false
            },
            { 
              "data": "info",
              "orderable": false,
              "visible": false
            },
            { 
              "data": "dataset_name",
              "orderable": false,
              "visible": false
            }
        ],
        columnDefs: [ 
          { responsivePriority: 1, targets: 0 },
          { responsivePriority: 2, targets: -1 } 
        ],
        //order: [ 1, 'asc' ]
      };
    } else {
      if(jQuery(window).width() >= 600) {
        dataTableOptions = {
          responsive: false,
          "ordering": false,
          "pagingType": "numbers",
          "pageLength": 10,
          "columns": [
              { 
                "data": "id",
                "orderable": false,
                "visible": false
              },
              {
                  "orderable": false,
                  "data": "name"
              },
              { 
                "data": "product",
                "orderable": false,
              },
              { 
                "data": "use",
                "orderable": false,
              },
              { 
                "data": "device" ,
                "orderable": true,
                "visible": false
              },
              { 
                "data": "unit",
                "orderable": false,
                "visible": false
              },
              { 
                "data": "quote",
                "orderable": false,
              },
              { 
                "data": "dataset",
                "orderable": false,
                "visible": false
              },
              { 
                "data": "source",
                "orderable": false,
                "visible": false
              },
              { 
                "data": "detailed_product_type",
                "orderable": false,
                "visible": false
              },
              { 
                "data": "language",
                "orderable": false,
                "visible": false
              },
              { 
                "data": "country",
                "orderable": false,
                "visible": false
              },
              { 
                "data": "recording",
                "orderable": false,
                "visible": false
              },
              { 
                "data": "contributors",
                "orderable": false,
                "visible": false
              },
              { 
                "data": "channels",
                "orderable": false,
                "visible": false
              },
              { 
                "data": "utterances",
                "orderable": false,
                "visible": false
              },
              { 
                "data": "words",
                "orderable": false,
                "visible": false,
              },
              { 
                "data": "rate",
                "orderable": false,
                "visible": false
              },
              { 
                "data": "format",
                "orderable": false,
                "visible": false
              },
              { 
                "data": "info",
                "orderable": false,
                "visible": false
              },
              { 
                "data": "dataset_name",
                "orderable": false,
                "visible": false
              }
          ],
          //order: [ 1, 'asc' ]
        };
      } else {
        if(jQuery(window).width() >= 400) {
          dataTableOptions = {
            responsive: false,
            "ordering": false,
            "pagingType": "numbers",
            "pageLength": 10,
            "columns": [
                { 
                  "data": "id",
                  "orderable": false,
                  "visible": false
                },
                {
                    "orderable": false,
                    "data": "name"
                },
                { 
                  "data": "product",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "use",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "device" ,
                  "orderable": true,
                  "visible": false
                },
                { 
                  "data": "unit",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "quote",
                  "orderable": false,
                  "visible": true
                },
                { 
                  "data": "dataset",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "source",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "detailed_product_type",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "language",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "country",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "recording",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "contributors",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "channels",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "utterances",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "words",
                  "orderable": false,
                  "visible": false,
                },
                { 
                  "data": "rate",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "format",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "info",
                  "orderable": false,
                  "visible": false
                },                
                { 
                  "data": "dataset_name",
                  "orderable": false,
                  "visible": false
                }
            ],
            //order: [ 1, 'asc' ]
          };
        } else {
          dataTableOptions = {
            responsive: false,
            "ordering": false,
            "pagingType": "numbers",
            "pageLength": 10,
            "columns": [
                { 
                  "data": "id",
                  "orderable": false,
                  "visible": false
                },
                {
                    "orderable": false,
                    "data": "name"
                },
                { 
                  "data": "product",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "use",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "device" ,
                  "orderable": true,
                  "visible": false
                },
                { 
                  "data": "unit",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "quote",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "dataset",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "source",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "detailed_product_type",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "language",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "country",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "recording",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "contributors",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "channels",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "utterances",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "words",
                  "orderable": false,
                  "visible": false,
                },
                { 
                  "data": "rate",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "format",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "info",
                  "orderable": false,
                  "visible": false
                },
                { 
                  "data": "dataset_name",
                  "orderable": false,
                  "visible": false
                }
            ],
            //order: [ 1, 'asc' ]
          };
        }
      }
    }
    var oTable = jQuery('#productCatalog').DataTable(dataTableOptions);

    jQuery('.paginate_button.previous').after("<strong>"+ (oTable.page.info().page+1) +" / "+ oTable.page.info().pages +"</strong>");
    jQuery('.table_head_mobile').text('Filter match '+ oTable.page.info().recordsDisplay +' - '+ oTable.page.info().recordsTotal);
    jQuery('.productCatalog__quote').text('Filter match '+ oTable.page.info().recordsDisplay +' - '+ oTable.page.info().recordsTotal);
    jQuery('#productCatalog img.lazy-hidden').each(function() {
        jQuery(this).removeClass('lazy-hidden');
        jQuery(this).attr("src", jQuery(this).attr("data-src"));
    });
    oTable.on( 'draw', function () {
        var current_page = oTable.page.info().page+1;
        var pages = oTable.page.info().pages;
        jQuery('.paginate_button.previous').after("<strong>"+ current_page +" / "+ pages +"</strong>");
        jQuery('.productCatalog__quote').text('Filter match '+ oTable.page.info().recordsDisplay +' - '+ oTable.page.info().recordsTotal);
        jQuery('.table_head_mobile').text('Filter match '+ oTable.page.info().recordsDisplay +' - '+ oTable.page.info().recordsTotal);
        jQuery('#productCatalog img.lazy-hidden').each(function() {
        jQuery(this).removeClass('lazy-hidden');
        jQuery(this).attr("src", jQuery(this).attr("data-src"));
    });
    } );


    function format ( d ) {
      if(jQuery(window).width() >= 992) {
        var data = '<div class="child-wrap"><div class="child-two"><span>Dataset ID: </span>'+d.dataset+'<br><span>Source: </span>'+d.source+'<br><span>Detailed Product Type: </span>'+d.detailed_product_type+'<br><span>Language: </span>'+d.language+'<br><span>Country: </span>'+d.country+'<br><span>Recording Condition: </span>'+d.recording+'<br></div><div class="child-two"><span>Contributors: </span>'+d.contributors+'<br/><span>Channels: </span>'+d.channels+'<br/><span>Utterances: </span>'+d.utterances+'<br/><span>Unique Words: </span>'+d.words+'<br/><span>Sample Rate (kHz): </span>'+d.rate+'<br/><span>Data Format: </span>'+d.format+'<br/></div></div><div class="child-wrap"><div class="child-one"><span>Additional Information: </span><br/>'+d.info+'</div></div>';
      } else {
        if(jQuery(window).width() >= 600) {
          var data = '<div class="child-wrap"><div class="child-two"><span>Dataset ID: </span>'+d.dataset+'<br><span>Source: </span>'+d.source+'<br><span>Detailed Product Type: </span>'+d.detailed_product_type+'<br><span>Language: </span>'+d.language+'<br><span>Country: </span>'+d.country+'<br><span>Recording Device: </span>'+d.device+'<br><span>Recording Condition: </span>'+d.recording+'<br></div><div class="child-two"><span>Unit: </span>'+d.unit+'<br><span>Contributors: </span>'+d.contributors+'<br/><span>Channels: </span>'+d.channels+'<br/><span>Utterances: </span>'+d.utterances+'<br/><span>Unique Words: </span>'+d.words+'<br/><span>Sample Rate (kHz): </span>'+d.rate+'<br/><span>Data Format: </span>'+d.format+'<br/></div></div><div class="child-wrap"><div class="child-one"><span>Additional Information: </span><br/>'+d.info+'</div></div>';
        } else {
          var data = '<div class="child-wrap"><div class="child-two"><span>Dataset ID: </span>'+d.dataset+'<br><span>Source: </span>'+d.source+'<br><span>Detailed Product Type: </span>'+d.detailed_product_type+'<br><span>Common Use Cases: </span>'+d.use+'<br><span>Language: </span>'+d.language+'<br><span>Country: </span>'+d.country+'<br><span>Recording Device: </span>'+d.device+'<br><span>Recording Condition: </span>'+d.recording+'<br></div><div class="child-two"><span>Unit: </span>'+d.unit+'<br><span>Contributors: </span>'+d.contributors+'<br/><span>Channels: </span>'+d.channels+'<br/><span>Utterances: </span>'+d.utterances+'<br/><span>Unique Words: </span>'+d.words+'<br/><span>Sample Rate (kHz): </span>'+d.rate+'<br/><span>Data Format: </span>'+d.format+'<br/></div></div><div class="child-wrap"><div class="child-one"><span>Additional Information: </span><br/>'+d.info+'<br/><br/>'+d.quote+'</div></div>';
        }
      }
      return data;
    }

    /*jQuery('body').on('click', 'a.ots__down', function(e) {
      e.preventDefault();
    })*/

    if(jQuery(window).width() >= 992) {
      jQuery('.js-filter-drop, .resourses-filter__active').on('mouseover', function() {
        jQuery(this).addClass('js-open');
        jQuery(this).closest('.resourses-filter').find('.js-filter-content').addClass('js-show');
        console.log('hover');
      });
      /*jQuery('.js-filter-drop, .resourses-filter__active').on('mouseout', function() {
        jQuery(this).removeClass('js-open');
        jQuery(this).closest('.resourses-filter').find('.js-filter-content').removeClass('js-show');
        console.log('out');
      });*/
      jQuery('.js-filter-content').on('mouseover', function() {
        jQuery(this).closest('.resourses-filter').find('.js-filter-drop').addClass('js-open');
        jQuery(this).addClass('js-show');
      });
      jQuery('.js-filter-content').on('mouseout', function() {
        jQuery(this).closest('.resourses-filter').find('.js-filter-drop').removeClass('js-open');
        jQuery(this).removeClass('js-show');
      });
    } else {
      jQuery('.js-filter-drop').on('click', function(e) {
        e.preventDefault();
        jQuery(this).toggleClass('js-open');
        jQuery(this).closest('.resourses-filter').find('.js-filter-content').toggleClass('js-show');
      });
      jQuery('.resourses-filter .menu>li a').on('click', function(e){
        e.preventDefault();
        jQuery(this).closest('li.menu-item-has-children').toggleClass('sub-open');
      });
    }
    jQuery('.resourses-filter .menu>li>ul a').on('click', function(e) {
      e.preventDefault();
      var name = jQuery(this).text().trim();
      var cat = jQuery(this).attr('data-category');
      if(jQuery(this).hasClass('filtered')) {
        jQuery(this).removeClass('filtered');
        jQuery('.resourses-filter__active').find('span[data-name="'+name+'"]').remove();
      } else {
        jQuery(this).addClass('filtered');
        jQuery('.resourses-filter__active').append('<span data-category="'+cat+'" data-name="'+name+'">'+name+'</span>');
      }
      if(jQuery(this).closest('.resourses-filter').find('.resourses-filter__active span').length > 0) {
        jQuery(this).closest('.resourses-filter').find('.js-reset-filter').show();
      }
      jQuery(this).closest('.resourses-filter').find('.js-filter-drop').removeClass('js-open');
      jQuery(this).closest('.resourses-filter').find('.js-filter-content').removeClass('js-show');
      if(jQuery(window).width() < 992) {
        jQuery('html, body').animate({
            scrollTop: jQuery("#ProductCatalogWrap").offset().top
        }, 3000);
      }
      var cat1 = '';
      if(cat == 'product') {
        cat1 = 'Product Type';
      }
      if(cat == 'language') {
        cat1 = 'Language';
      }
      if(cat == 'use') {
        cat1 = 'Common Use Case';
      }
      if ("ga" in window) {
          tracker = ga.getAll()[0];
          if (tracker)
              tracker.send("event", "Off the Shelf Datasets Filtering", cat1, name);
      }
      oTable.draw();
    });
    jQuery('body').on('click', '.resourses-filter__active span', function(e) {
      e.preventDefault();
      var thisElem = jQuery(this);
      var name = jQuery(this).attr('data-name');
      var cat = jQuery(this).attr('data-category');
      jQuery(this).closest('.resourses-filter').find('.menu>li>ul a').each(function() {
        if(jQuery(this).attr('data-category') == cat && jQuery(this).text().trim() == name) {
          jQuery(this).removeClass('filtered');         
        }
      });
      if(jQuery(window).width() < 992) {
        jQuery('.resourses-filter').find('.menu>li>ul a').each(function() {
          if(jQuery(this).attr('data-category') == cat && jQuery(this).text().trim() == name) {
            jQuery(this).removeClass('filtered');         
          }
        });
      }
      jQuery(thisElem).remove();
      oTable.draw();
    });
    jQuery('body').on('click', '.js-reset-filter', function(e) {
      e.preventDefault();
      var thisElem = jQuery(this);
      jQuery(this).closest('.resourses-filter').find('.menu>li>ul a').each(function() {
        jQuery(this).removeClass('filtered');
      })
      jQuery(thisElem).closest('.resourses-filter').find('.resourses-filter__active').html('');
      if(jQuery(window).width() < 992) {
        jQuery('.resourses-filter__active').html('');
        jQuery(this).removeClass('js-open');
        jQuery(this).closest('.resourses-filter').find('.js-filter-content').removeClass('js-show');
      }
      oTable.draw();
    })

    function inArray(needle, hatstack) {
      if(hatstack.length) {
        if(hatstack.includes(needle)) {
          return true;
        } else {
          return false;
        }
      } else {
        return true;
      }
    }

    function textContains(needle, hatstack) {
      if(hatstack.length) {
        var count = 0;
        hatstack.forEach(function(entry) {
          if(needle.indexOf(entry) !== -1) {
            count++;
          }
      });
        if(count > 0) {
          return true;
        } else {
          return false;
        }
      } else {
        return true;
      }
    }

    function checkFirst(needle, hatstack) {
      if(hatstack.length) {
        var count = 0;
        hatstack.forEach(function(entry) {
          if(needle.slice(0,1) == entry.toLocaleLowerCase()) {
            count++;
          }
        });
        if(needle == 'n/a') {
          return false;
        }
        if(count > 0) {
            return true;
        } else {
          return false;
        }
      } else {
        return true;
      }
    }

  jQuery.fn.dataTable.ext.search.push(
      function( settings, data, dataIndex ) {
      var product = [];
      var language = [];
      var use = [];
      if(jQuery('.resourses-filter__active span').length > 0 || jQuery('.frm_search').val() != '') {
        jQuery('.productCatalog__quote').removeClass('text-hide');
      } else {
        jQuery('.productCatalog__quote').addClass('text-hide');
      }
      jQuery('.resourses-filter__active span').each(function() {
        var cat = jQuery(this).attr('data-category');
        var name = jQuery(this).attr('data-name');
        if(cat == 'product') {
          product.push(name.toLocaleLowerCase());
        }
        if(cat == 'language') {
          language.push(name.toLocaleLowerCase());
        }
        if(cat == 'use') {
          use.push(name.toLocaleLowerCase());
        }
      })
      if(inArray(data[2].toLocaleLowerCase(), product) && checkFirst(data[20].toLocaleLowerCase(), language) && textContains(data[3].toLocaleLowerCase(), use)) {
        return true;
      } else {
        return false;
      }
    }
  );

  oTable.on('page.dt', function() {
    if(jQuery(window).width() >= 768) {
      jQuery('html, body').animate({
        scrollTop: jQuery(".ProductCatalogTopWrap").offset().top - 400
      }, 'slow');
    } else {
      jQuery('html, body').animate({
        scrollTop: jQuery(".ProductCatalogTopWrap").offset().top
      }, 'slow');
    }
  });


    jQuery('body').on('click', 'a.add_quote', function(e) {
      e.preventDefault();
      woopra.track("add_quote_click", {
      });
      var thisElement = jQuery(this);
      var id = jQuery(thisElement).attr('data-id');
      jQuery.ajax({
          url: '<?php echo admin_url('admin-ajax.php'); ?>',
          type: 'post',
          data: {
            action: 'add_to_catalog_cart',
            item_id: jQuery(thisElement).attr('data-id')
          },
          success: function( data, textStatus, jQxhr ){              
          jQuery(thisElement).text('Remove')
                            .addClass('remove_quote')
                            .removeClass('add_quote')
                            .closest('tr').addClass('js-selected');
          jQuery('a.add_quote[data-id="'+id+'"]').text('Remove')
                            .addClass('remove_quote')
                            .removeClass('add_quote')
                            .closest('tr').addClass('js-selected');
          jQuery('.request-quote span').text(parseInt(jQuery('.request-quote span').text()) + 1);
              var text = jQuery(thisElement).closest('tr').find('td:nth-child(1) span').text();
              if ("ga" in window) {
                  tracker = ga.getAll()[0];
                  if (tracker)
                      tracker.send("event", "Off the Shelf Datasets Add to Cart", "Add to Cart", text);
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
      var id = jQuery(thisElement).attr('data-id');
      jQuery.ajax({
          url: '<?php echo admin_url('admin-ajax.php'); ?>',
          type: 'post',
          data: {
            action: 'remove_to_catalog_cart',
            item_id: jQuery(thisElement).attr('data-id')
          },
          success: function( data, textStatus, jQxhr ){
          jQuery(thisElement).text('Add')
                            .addClass('add_quote')
                            .removeClass('remove_quote')
                            .closest('tr').removeClass('js-selected');
          jQuery('a.remove_quote[data-id="'+id+'"]').text('Add to quote')
                            .addClass('add_quote')
                            .removeClass('remove_quote')
                            .closest('tr').removeClass('js-selected');
          if(parseInt(jQuery('.request-quote span').text()) > 0) {
            jQuery('.request-quote span').text(parseInt(jQuery('.request-quote span').text()) - 1);
          }
              jQuery(thisElement).text('Add')
                                 .addClass('add_quote')
                                 .removeClass('remove_quote')
                                 .closest('tr').removeClass('js-selected');
          },
          error: function( jqXhr, textStatus, errorThrown ){
              console.log( errorThrown );
          }
      });
    });

    jQuery('body').on('submit', '.catalog_table_search_form', function(e){
      e.preventDefault();
      //jQuery('<a class="clear_search" href="#"><i class="la la-times" aria-hidden="true"></i></a>').insertAfter(jQuery(this).find('.frm_search'));
      if(jQuery(this).find('.frm_search').val() != '') {
        if(!jQuery(this).hasClass('searched')) {
          jQuery('.productCatalog__quote').removeClass('text-hide');
          jQuery(this).addClass('searched');
          oTable.search(jQuery(this).find('.frm_search').val()).draw();
          if ("ga" in window) {
              tracker = ga.getAll()[0];
              if (tracker)
                  tracker.send("event", "Off the Shelf Datasets Search", "Search", jQuery(this).find('.frm_search').val());
          }
        } else {
          jQuery(this).removeClass('searched');
          jQuery('.productCatalog__quote').addClass('text-hide');
          jQuery(this).find('.frm_search').val('');
          oTable.search('').draw();
        }
      }   
    });
    jQuery('body').on('click', 'a.clear_search', function(e) {
      e.preventDefault();
      jQuery(this).parent().find('.frm_search').val('');
      jQuery(this).remove();
      oTable.search('').draw();
    });

    /*jQuery('#productCatalog tbody').on('click', 'a.ots__down', function (e) {
      e.preventDefault();
      console.log('test');
      var tr = jQuery(this).closest('tr');
      var row = oTable.row( tr );

      if ( row.child.isShown() ) {
          row.child.hide();
          tr.toggleClass('parent');
          tr.toggleClass('js-hide');
      }
      else {
          row.child( format(row.data()) ).show();
          var classes = tr.attr('class');
          row.child().find('tr.fc td a').contents().unwrap();
          row.child().addClass(classes);
          row.child().addClass('child');
          tr.addClass('parent');
      }
    });*/

    if(jQuery(window).width() >= 768) {
      jQuery('body').on('click', '#productCatalog tbody tr td:not(.child):not(:last-child)', function (e) {
        e.preventDefault();
        var tr = jQuery(this).closest('tr');
        var row = oTable.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.toggleClass('parent');
            tr.toggleClass('js-hide');
        }
        else {
            row.child( format(row.data()) ).show();
            var classes = tr.attr('class');
            row.child().find('tr.fc td a').contents().unwrap();
            row.child().addClass(classes);
            row.child().addClass('child');
            tr.addClass('parent');
            var text = jQuery(tr).find('td:nth-child(1) span').text();
            if ("ga" in window) {
                tracker = ga.getAll()[0];
                if (tracker)
                    tracker.send("event", "Off the Shelf Datasets More Information", "More Information", text);
            }
        }
      });
    } else {
      jQuery('body').on('click', '#productCatalog tbody tr td', function (e) {
        e.preventDefault();
        var tr = jQuery(this).closest('tr');
        var row = oTable.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.toggleClass('parent');
            tr.toggleClass('js-hide');
        }
        else {
            row.child( format(row.data()) ).show();
            var classes = tr.attr('class');
            row.child().find('tr.fc td a').contents().unwrap();
            row.child().addClass(classes);
            row.child().addClass('child');
            tr.addClass('parent');
            var text = jQuery(tr).find('td:nth-child(1) span').text();
            if ("ga" in window) {
                tracker = ga.getAll()[0];
                if (tracker)
                    tracker.send("event", "Off the Shelf Datasets More Information", "More Information", text);
            }
        }
      });
    }

    });

    jQuery('body').on('click', 'a.request-quote', function(e) {
        if(parseInt(jQuery(this).find('span').text()) <= 0) {
            e.preventDefault();
        } else {
            window.location.href = jQuery(this).attr('href');
        }
    })
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
  if(!empty($_SESSION['catalog_cart'])) {
    global $wpdb;
    ?>
    <script>
      /*function cart_data() {
        jQuery.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'post',
            data: {
              action: 'cart_data'
            },
            success: function( data, textStatus, jQxhr ){
                var obj = jQuery.parseJSON(data);
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });
      }
      jQuery('document').ready(function() {
        cart_data();
      });*/
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
                jQuery(thisElement).closest('tr').remove();
                //cart_data();
                location.reload();
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
        /*unset($_SESSION['catalog_cart']);
        unset($_SESSION['gf_submit']);*/
      } else {
    ?>
    <h1 class="catalog_head">Datasets Inquiry Submission</h1>
    <div class="catalog_cart_list">
      <table>
        <thead>
          <tr>
            <th class="catalog__cart__name">Dataset Name</th>
            <th>Dataset ID</th>
            <th>Product Type</th>
            <th>Unit</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php
        /*$languagesRequested = [];
        $corpusType = [];
        $dbName = [];*/

        foreach($_SESSION['catalog_cart'] as $cart_item) {
          ?>
            <tr>
            <?php
              $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}ots_catalog_2 WHERE id = ".$cart_item );
              if(!empty($row)) {
                /*array_push($languagesRequested, $row->language);
                if ( isset($row->corpus_type) && !in_array($row->corpus_type, $corpusType) ) array_push($corpusType, $row->corpus_type);
                if ( isset($row->db_name) && !in_array($row->db_name, $dbName) ) array_push($dbName, $row->db_name);*/
            ?>
            <td><?php echo $row->dataset_name; ?></td>
            <td><?php echo $row->dataset_id; ?></td>
            <td><?php echo $row->product_type; ?></td>
            <td><?php echo $row->unit; ?></td>
            <td><input type="hidden" name="catalog_cart_pro[]" value="<?php echo $cart_item; ?>" />
            <a class="catalog_cart_list_delete" data-id="<?php echo $row->id; ?>" href="#"></a></td>
          </tr>
          <?php
          }
        }
        ?>
      </tbody>
    </table>
    </div>
    <?php } ?>
    <div class="catalog_cart_form">
      <script defer src="//app-ab14.marketo.com/js/forms2/js/forms2.min.js"></script>
      <form id="mktoForm_1979"></form>
      <?php
        /*$languagesRequestedCleared = [];
        foreach ( $languagesRequested as $lang ) {
          $langCleared = preg_replace( '/ \(.*?\)/', '', $lang );
          if ( !in_array( $langCleared, $languagesRequestedCleared ) ) array_push( $languagesRequestedCleared, $langCleared );
        }*/
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
            //form.vals({ "languagesRequested":"<?php //echo implode(', ', $languagesRequestedCleared); ?>"});
            //form.vals({ "languageforwebuse":"<?php //echo implode(', ', $languagesRequested); ?>"});
            //form.vals({ "corpusType":"<?php //echo implode(', ', $corpusType); ?>"});
            //form.vals({ "dBName":"<?php //echo implode(', ', $dbName); ?>"});
            jQuery.ajax({
              url: '<?php echo admin_url('admin-ajax.php'); ?>',
              type: 'post',
              data: {
                action: 'cart_data'
              },
              success: function( data, textStatus, jQxhr ){
                  var obj = jQuery.parseJSON(data);
                  form.vals({ "OTS_Dataset_Name__c": obj.catalog_cart});
              },
              error: function( jqXhr, textStatus, errorThrown ){
                  console.log( errorThrown );
              }
            });

            form.onSuccess(function(values, followUpUrl) {
              if ("ga" in window) {
                  tracker = ga.getAll()[0];
                  if (tracker)
                      tracker.send("event", "Off the Shelf Datasets Inquiry Submission", "Inquiry Submission", jQuery('input[name="OTS_Dataset_Name__c"]').val());
              }
            });
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
    header("Location: ".site_url()."/off-the-shelf-datasets/#ProductCatalog");
  }
  return ob_get_clean();
}

add_action('wp_head','ots_info_load');
function ots_info_load() {
  add_shortcode('ots-info', 'ots_info');
}

function catalog_admin_menu_setup(){
    add_menu_page( 
        'OTS Catalog',
        'OTS Catalog',
        'manage_options',
        'otf-catalog-admin',
        'otf_catalog_admin_menu_page',
        'dashicons-editor-ul',
        10
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
              $row = $wpdb->get_row( "SELECT id FROM {$wpdb->prefix}ots_catalog_2 WHERE id = '".$column[0]."'" );
              if(count((array)$row) == 0) {
                $wpdb->insert($wpdb->prefix."ots_catalog_2",array(
                    "id" => $column[0],
                    "language" => $column[1],
                    "country" => $column[2],
                    "language_code" => $column[3],
                    "country_code" => $column[4],
                    "dataset_name" => $column[5],
                    "dataset_id" => $column[6],
                    "product_type" => $column[7],
                    "detailed_product_type" => $column[8],
                    "common_use_cases" => $column[9],
                    "unit" => $column[10],
                    "recording_device" => $column[11],
                    "recording_condition" => $column[12],
                    "contributors" => $column[13],
                    "utterances" => $column[14],
                    "unique_word" => $column[15],
                    "sample_rate" => $column[16],
                    "channels" => $column[17],
                    "data_format" => $column[18],
                    "source" => $column[19],
                    "additional_info" => $column[20]
                  )
                );
                $wpdb->print_error();
              } else {
                $wpdb->update($wpdb->prefix."ots_catalog_2",array(
                    "language" => $column[1],
                    "country" => $column[2],
                    "language_code" => $column[3],
                    "country_code" => $column[4],
                    "dataset_name" => $column[5],
                    "dataset_id" => $column[6],
                    "product_type" => $column[7],
                    "detailed_product_type" => $column[8],
                    "common_use_cases" => $column[9],
                    "unit" => $column[10],
                    "recording_device" => $column[11],
                    "recording_condition" => $column[12],
                    "contributors" => $column[13],
                    "utterances" => $column[14],
                    "unique_word" => $column[15],
                    "sample_rate" => $column[16],
                    "channels" => $column[17],
                    "data_format" => $column[18],
                    "source" => $column[19],
                    "additional_info" => $column[20]

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
        <th>Dataset Name</th>
    <th>Product Type</th>
    <th>Common Use Cases</th>
    <th>Recording Device</th>
    <th>Unit</th>
      </tr>
    </thead>
    <tbody>
      <?php
        global $wpdb;
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ots_catalog_2" );
        if(!empty($results)) {
          foreach ($results as $key => $value) {
            ?>
            <tr>
              <td><?php echo $value->id; ?></td>
              <td>
                <strong><?php echo $value->dataset_name; ?></strong>
                <br/>
                <a href="<?php echo admin_url('admin.php'); ?>?page=otf-catalog-edit&otf_id=<?php echo $value->id; ?>">Edit</a> | <a href="<?php echo admin_url('admin.php'); ?>?page=otf-catalog-delete&otf_id=<?php echo $value->id; ?>&page_text=otf-catalog-admin">Delete</a>
              </td>
              <td><?php echo $value->product_type; ?></td>
              <td><?php echo $value->common_use_cases; ?></td>
              <td><?php echo $value->recording_device; ?></td>
              <td><?php echo $value->unit; ?></td>
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
    $wpdb->update($wpdb->prefix."ots_catalog_2", 
        array(
      "language" => $_POST["language"],
      "country" => $_POST["country"],
      "language_code" => $_POST["language_code"],
      "country_code" => $_POST["country_code"],
      "dataset_name" => $_POST["dataset_name"],
      "dataset_id" => $_POST["dataset_id"],
      "product_type" => $_POST["product_type"],
      "detailed_product_type" => $_POST["detailed_product_type"],
      "common_use_cases" => $_POST["common_use_cases"],
      "unit" => $_POST["unit"],
      "recording_device" => $_POST["recording_device"],
      "recording_condition" => $_POST["recording_condition"],
      "contributors" => $_POST["contributors"],
      "utterances" => $_POST["utterances"],
      "unique_word" => $_POST["unique_word"],
      "sample_rate" => $_POST["sample_rate"],
      "channels" => $_POST["channels"],
      "data_format" => $_POST["data_format"],
      "source" => $_POST["source"],
      "additional_info" => $_POST["additional_info"]
        ),
        array('id'=>$_POST['ots_id'])
    );
    echo '<div>Update Successfull</div>';
  }
  if(isset($_GET['otf_id'])) {
    global $wpdb;
    $row = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}ots_catalog_2 WHERE id = ".$_GET['otf_id'] );
    if($row) {
    ?>
    <h1>Edit OTS Catalog </h1>
    <form method="POST" action="">
      <p>
        <input type="hidden" name="ots_id" value="<?php echo $row->id; ?>" />
        <label>Language:</label><br/> <input type="text" name="language" value="<?php echo $row->language; ?>" /><br/>
        <label>Country:</label><br/> <input type="text" name="country" value="<?php echo $row->country; ?>" /><br/>
        <label>Language Code:</label><br/> <input type="text" name="language_code" value="<?php echo $row->language_code; ?>" /><br/>
        <label>Country Code:</label><br/> <input type="text" name="country_code" value="<?php echo $row->country_code; ?>" /><br/>
        <label>Dataset Name:</label><br/> <input type="text" name="dataset_name" value="<?php echo $row->dataset_name; ?>" /><br/>
        <label>Dataset ID:</label><br/> <input type="text" name="dataset_id" value="<?php echo $row->dataset_id; ?>" /><br/>
        <label>Product Type:</label><br/> <input type="text" name="product_type" value="<?php echo $row->product_type; ?>" /><br/>
        <label>Detailed Product Type:</label><br/> <input type="text" name="detailed_product_type" value="<?php echo $row->detailed_product_type; ?>" /><br/>
        <label>Common Use Cases:</label><br/> <input type="text" name="common_use_cases" value="<?php echo $row->common_use_cases; ?>" /><br/>
        <label>Unit:</label><br/> <input type="text" name="unit" value="<?php echo $row->unit; ?>" /><br/>
        <label>Recording Device:</label><br/> <input type="text" name="recording_device" value="<?php echo $row->recording_device; ?>" /><br/>
        <label>Recording Condition:</label><br/> <input type="text" name="recording_condition" value="<?php echo $row->recording_condition; ?>" /><br/>
        <label>Contributors:</label><br/> <input type="text" name="contributors" value="<?php echo $row->contributors; ?>" /><br/>
        <label>Utterances:</label><br/> <input type="text" name="utterances" value="<?php echo $row->utterances; ?>" /><br/>
        <label>Unique Words:</label><br/> <input type="text" name="unique_word" value="<?php echo $row->unique_word; ?>" /><br/>
        <label>Sample Rate (kHz):</label><br/> <input type="text" name="sample_rate" value="<?php echo $row->sample_rate; ?>" /><br/>
        <label>Channels:</label><br/> <input type="text" name="channels" value="<?php echo $row->channels; ?>" /><br/>
        <label>Data Format:</label><br/> <input type="text" name="data_format" value="<?php echo $row->data_format; ?>" /><br/>
        <label>Source:</label><br/> <input type="text" name="source" value="<?php echo $row->source; ?>" /><br/>
        <label>Additional Information</label><br/> <textarea name="additional_info"><?php echo $row->additional_info; ?></textarea>
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
    $table = "ots_catalog_2";
    $wpdb->delete( $wpdb->prefix.$table, array( 'id' => $_GET['otf_id'] ) );
  }
  header('Location: '.admin_url('admin.php').'?page='.$_GET['page_text']);
  //exit;
}



add_action( 'admin_post_print.csv', 'print_csv' );

function print_csv() {
    if ( ! current_user_can( 'manage_options' ) )
        return;

    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename=OTS-Catalog-'.date('Y-m-d').'.csv');
    header('Pragma: no-cache');
    global $wpdb;
    $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ots_catalog_2",  ARRAY_A);
    if(!empty($results)) {
      $output = fopen("php://output", "wb");
      
      fputcsv($output, array(
          'Unique ID',
          'Language','Country',
          'Language Code',
          'Country Code',
          'Dataset Name',
          'Dataset ID',
          'Product Type',
          'Detailed Product Type',
          'Common Use Cases',
          'Unit',
          'Recording Device',
          'Recording Condition',
          'Contributors',
          'Utterances',
          'Unique Words',
          'Sample Rate (kHz)',
          'Channels',
          'Data Format',
          'Source',
          'Additional Information'
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