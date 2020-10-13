<?php
/**
 * @file
 * propco_redemption_report.views_default.inc
 */

/**
 * Implements hook_views_default_views().
 */
function propco_redemption_report_views_default_views() {
  $export = array();

  $view = new view();
  $view->name = 'redemption_report';
  $view->description = '';
  $view->tag = 'default';
  $view->base_table = 'node';
  $view->human_name = 'Redemption Report';
  $view->core = 7;
  $view->api_version = '3.0';
  $view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['use_ajax'] = TRUE;
  $handler->display->display_options['use_more_always'] = FALSE;
  $handler->display->display_options['access']['type'] = 'role';
  $handler->display->display_options['access']['role'] = array(
    3 => '3',
    4 => '4',
    6 => '6',
  );
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['pager']['options']['items_per_page'] = '20';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['pager']['options']['id'] = '0';
  $handler->display->display_options['pager']['options']['quantity'] = '9';
  $handler->display->display_options['pager']['options']['expose']['items_per_page'] = TRUE;
  $handler->display->display_options['pager']['options']['expose']['items_per_page_options_all'] = TRUE;
  $handler->display->display_options['style_plugin'] = 'table';
  $handler->display->display_options['style_options']['columns'] = array(
    'views_bulk_operations' => 'views_bulk_operations',
    'field_redemption_date' => 'field_redemption_date',
    'field_redemption_pin' => 'field_redemption_pin',
    'field_awards_selected' => 'field_awards_selected',
    'field_confirmation_number' => 'field_confirmation_number',
    'field_first_name' => 'field_first_name',
    'field_last_name' => 'field_last_name',
    'field_phone' => 'field_phone',
    'field_email' => 'field_email',
    'field_address' => 'field_address',
    'field_redemption_program' => 'field_redemption_program',
    'field_redemption_status' => 'field_redemption_status',
    'field_vendors' => 'field_vendors',
  );
  $handler->display->display_options['style_options']['default'] = '-1';
  $handler->display->display_options['style_options']['info'] = array(
    'views_bulk_operations' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_redemption_date' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_redemption_pin' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_awards_selected' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_confirmation_number' => array(
      'sortable' => 0,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_first_name' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_last_name' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_phone' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_email' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_address' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_redemption_program' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_redemption_status' => array(
      'sortable' => 1,
      'default_sort_order' => 'asc',
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
    'field_vendors' => array(
      'align' => '',
      'separator' => '',
      'empty_column' => 0,
    ),
  );
  /* Field: Bulk operations: Content */
  $handler->display->display_options['fields']['views_bulk_operations']['id'] = 'views_bulk_operations';
  $handler->display->display_options['fields']['views_bulk_operations']['table'] = 'node';
  $handler->display->display_options['fields']['views_bulk_operations']['field'] = 'views_bulk_operations';
  $handler->display->display_options['fields']['views_bulk_operations']['label'] = '';
  $handler->display->display_options['fields']['views_bulk_operations']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['display_type'] = '1';
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['enable_select_all_pages'] = 1;
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['force_single'] = 0;
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_settings']['entity_load_capacity'] = '10';
  $handler->display->display_options['fields']['views_bulk_operations']['vbo_operations'] = array(
    'rules_component::rules_resend_email' => array(
      'selected' => 1,
      'postpone_processing' => 0,
      'skip_confirmation' => 0,
      'override_label' => 1,
      'label' => 'ReSend Email',
    ),
  );
  /* Field: Content: Redemption Date */
  $handler->display->display_options['fields']['field_redemption_date']['id'] = 'field_redemption_date';
  $handler->display->display_options['fields']['field_redemption_date']['table'] = 'field_data_field_redemption_date';
  $handler->display->display_options['fields']['field_redemption_date']['field'] = 'field_redemption_date';
  $handler->display->display_options['fields']['field_redemption_date']['label'] = 'Date';
  $handler->display->display_options['fields']['field_redemption_date']['settings'] = array(
    'format_type' => 'mysql',
    'fromto' => 'both',
    'multiple_number' => '',
    'multiple_from' => '',
    'multiple_to' => '',
  );
  /* Field: Content: Redemption Pin */
  $handler->display->display_options['fields']['field_redemption_pin']['id'] = 'field_redemption_pin';
  $handler->display->display_options['fields']['field_redemption_pin']['table'] = 'field_data_field_redemption_pin';
  $handler->display->display_options['fields']['field_redemption_pin']['field'] = 'field_redemption_pin';
  $handler->display->display_options['fields']['field_redemption_pin']['label'] = 'Pin Code';
  $handler->display->display_options['fields']['field_redemption_pin']['settings'] = array(
    'link' => 0,
  );
  /* Field: Content: Awards Selected */
  $handler->display->display_options['fields']['field_awards_selected']['id'] = 'field_awards_selected';
  $handler->display->display_options['fields']['field_awards_selected']['table'] = 'field_data_field_awards_selected';
  $handler->display->display_options['fields']['field_awards_selected']['field'] = 'field_awards_selected';
  $handler->display->display_options['fields']['field_awards_selected']['settings'] = array(
    'link' => 0,
  );
  $handler->display->display_options['fields']['field_awards_selected']['delta_offset'] = '0';
  $handler->display->display_options['fields']['field_awards_selected']['separator'] = ';';
  /* Field: Content: Confirmation Number */
  $handler->display->display_options['fields']['field_confirmation_number']['id'] = 'field_confirmation_number';
  $handler->display->display_options['fields']['field_confirmation_number']['table'] = 'field_data_field_confirmation_number';
  $handler->display->display_options['fields']['field_confirmation_number']['field'] = 'field_confirmation_number';
  $handler->display->display_options['fields']['field_confirmation_number']['label'] = 'Order Number';
  /* Field: Content: First Name */
  $handler->display->display_options['fields']['field_first_name']['id'] = 'field_first_name';
  $handler->display->display_options['fields']['field_first_name']['table'] = 'field_data_field_first_name';
  $handler->display->display_options['fields']['field_first_name']['field'] = 'field_first_name';
  /* Field: Content: Last Name */
  $handler->display->display_options['fields']['field_last_name']['id'] = 'field_last_name';
  $handler->display->display_options['fields']['field_last_name']['table'] = 'field_data_field_last_name';
  $handler->display->display_options['fields']['field_last_name']['field'] = 'field_last_name';
  /* Field: Content: Phone */
  $handler->display->display_options['fields']['field_phone']['id'] = 'field_phone';
  $handler->display->display_options['fields']['field_phone']['table'] = 'field_data_field_phone';
  $handler->display->display_options['fields']['field_phone']['field'] = 'field_phone';
  /* Field: Field: Email */
  $handler->display->display_options['fields']['field_email']['id'] = 'field_email';
  $handler->display->display_options['fields']['field_email']['table'] = 'field_data_field_email';
  $handler->display->display_options['fields']['field_email']['field'] = 'field_email';
  /* Field: Content: Redemption Program */
  $handler->display->display_options['fields']['field_redemption_program']['id'] = 'field_redemption_program';
  $handler->display->display_options['fields']['field_redemption_program']['table'] = 'field_data_field_redemption_program';
  $handler->display->display_options['fields']['field_redemption_program']['field'] = 'field_redemption_program';
  $handler->display->display_options['fields']['field_redemption_program']['label'] = 'Program';
  $handler->display->display_options['fields']['field_redemption_program']['settings'] = array(
    'link' => 0,
  );
  /* Field: Content: Redemption Status */
  $handler->display->display_options['fields']['field_redemption_status']['id'] = 'field_redemption_status';
  $handler->display->display_options['fields']['field_redemption_status']['table'] = 'field_data_field_redemption_status';
  $handler->display->display_options['fields']['field_redemption_status']['field'] = 'field_redemption_status';
  $handler->display->display_options['fields']['field_redemption_status']['label'] = 'Status';
  /* Field: Content: Vendors */
  $handler->display->display_options['fields']['field_vendors']['id'] = 'field_vendors';
  $handler->display->display_options['fields']['field_vendors']['table'] = 'field_data_field_vendors';
  $handler->display->display_options['fields']['field_vendors']['field'] = 'field_vendors';
  $handler->display->display_options['fields']['field_vendors']['settings'] = array(
    'link' => 0,
  );
  $handler->display->display_options['fields']['field_vendors']['delta_offset'] = '0';
  /* Field: Content: Address - Thoroughfare (i.e. Street address) */
  $handler->display->display_options['fields']['field_address_thoroughfare']['id'] = 'field_address_thoroughfare';
  $handler->display->display_options['fields']['field_address_thoroughfare']['table'] = 'field_data_field_address';
  $handler->display->display_options['fields']['field_address_thoroughfare']['field'] = 'field_address_thoroughfare';
  $handler->display->display_options['fields']['field_address_thoroughfare']['label'] = 'Address 1';
  /* Field: Content: Address - Premise (i.e. Apartment / Suite number) */
  $handler->display->display_options['fields']['field_address_premise']['id'] = 'field_address_premise';
  $handler->display->display_options['fields']['field_address_premise']['table'] = 'field_data_field_address';
  $handler->display->display_options['fields']['field_address_premise']['field'] = 'field_address_premise';
  $handler->display->display_options['fields']['field_address_premise']['label'] = 'Address 2';
  /* Field: Content: Address - Locality (i.e. City) */
  $handler->display->display_options['fields']['field_address_locality']['id'] = 'field_address_locality';
  $handler->display->display_options['fields']['field_address_locality']['table'] = 'field_data_field_address';
  $handler->display->display_options['fields']['field_address_locality']['field'] = 'field_address_locality';
  $handler->display->display_options['fields']['field_address_locality']['label'] = 'City';
  /* Field: Content: Address - Administrative area (i.e. State / Province) */
  $handler->display->display_options['fields']['field_address_administrative_area']['id'] = 'field_address_administrative_area';
  $handler->display->display_options['fields']['field_address_administrative_area']['table'] = 'field_data_field_address';
  $handler->display->display_options['fields']['field_address_administrative_area']['field'] = 'field_address_administrative_area';
  $handler->display->display_options['fields']['field_address_administrative_area']['label'] = 'State';
  /* Field: Content: Address - Postal code */
  $handler->display->display_options['fields']['field_address_postal_code']['id'] = 'field_address_postal_code';
  $handler->display->display_options['fields']['field_address_postal_code']['table'] = 'field_data_field_address';
  $handler->display->display_options['fields']['field_address_postal_code']['field'] = 'field_address_postal_code';
  $handler->display->display_options['fields']['field_address_postal_code']['label'] = 'Postal Code';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['label'] = '';
  $handler->display->display_options['fields']['title']['exclude'] = TRUE;
  $handler->display->display_options['fields']['title']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['title']['link_to_node'] = FALSE;
  /* Field: Content: OTS Sync Date */
  $handler->display->display_options['fields']['field_ots_sync_date']['id'] = 'field_ots_sync_date';
  $handler->display->display_options['fields']['field_ots_sync_date']['table'] = 'field_data_field_ots_sync_date';
  $handler->display->display_options['fields']['field_ots_sync_date']['field'] = 'field_ots_sync_date';
  $handler->display->display_options['fields']['field_ots_sync_date']['label'] = 'Fulfillment Creation Date';
  $handler->display->display_options['fields']['field_ots_sync_date']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['field_ots_sync_date']['settings'] = array(
    'format_type' => 'short',
    'fromto' => 'both',
    'multiple_number' => '',
    'multiple_from' => '',
    'multiple_to' => '',
  );
  /* Field: Content: Order Number */
  $handler->display->display_options['fields']['field_ots_order_number']['id'] = 'field_ots_order_number';
  $handler->display->display_options['fields']['field_ots_order_number']['table'] = 'field_data_field_ots_order_number';
  $handler->display->display_options['fields']['field_ots_order_number']['field'] = 'field_ots_order_number';
  $handler->display->display_options['fields']['field_ots_order_number']['element_label_colon'] = FALSE;
  /* Field: Content: Item Status */
  $handler->display->display_options['fields']['field_ots_item_status']['id'] = 'field_ots_item_status';
  $handler->display->display_options['fields']['field_ots_item_status']['table'] = 'field_data_field_ots_item_status';
  $handler->display->display_options['fields']['field_ots_item_status']['field'] = 'field_ots_item_status';
  $handler->display->display_options['fields']['field_ots_item_status']['label'] = 'Order Status';
  $handler->display->display_options['fields']['field_ots_item_status']['element_label_colon'] = FALSE;
  /* Field: Content: Item Status Date */
  $handler->display->display_options['fields']['field_ots_item_status_date']['id'] = 'field_ots_item_status_date';
  $handler->display->display_options['fields']['field_ots_item_status_date']['table'] = 'field_data_field_ots_item_status_date';
  $handler->display->display_options['fields']['field_ots_item_status_date']['field'] = 'field_ots_item_status_date';
  $handler->display->display_options['fields']['field_ots_item_status_date']['label'] = 'Order Creation Date';
  $handler->display->display_options['fields']['field_ots_item_status_date']['element_label_colon'] = FALSE;
  $handler->display->display_options['fields']['field_ots_item_status_date']['settings'] = array(
    'format_type' => 'long',
    'fromto' => 'both',
    'multiple_number' => '',
    'multiple_from' => '',
    'multiple_to' => '',
  );
  /* Sort criterion: Content: Post date */
  $handler->display->display_options['sorts']['created']['id'] = 'created';
  $handler->display->display_options['sorts']['created']['table'] = 'node';
  $handler->display->display_options['sorts']['created']['field'] = 'created';
  $handler->display->display_options['sorts']['created']['order'] = 'DESC';
  /* Filter criterion: Global: Combine fields filter */
  $handler->display->display_options['filters']['combine']['id'] = 'combine';
  $handler->display->display_options['filters']['combine']['table'] = 'views';
  $handler->display->display_options['filters']['combine']['field'] = 'combine';
  $handler->display->display_options['filters']['combine']['operator'] = 'contains';
  $handler->display->display_options['filters']['combine']['group'] = 1;
  $handler->display->display_options['filters']['combine']['exposed'] = TRUE;
  $handler->display->display_options['filters']['combine']['expose']['operator_id'] = 'combine_op';
  $handler->display->display_options['filters']['combine']['expose']['label'] = 'Search';
  $handler->display->display_options['filters']['combine']['expose']['operator'] = 'combine_op';
  $handler->display->display_options['filters']['combine']['expose']['identifier'] = 'combine';
  $handler->display->display_options['filters']['combine']['expose']['remember_roles'] = array(
    2 => '2',
    1 => 0,
    3 => 0,
    5 => 0,
    4 => 0,
  );
  $handler->display->display_options['filters']['combine']['fields'] = array(
    'field_redemption_pin' => 'field_redemption_pin',
    'field_confirmation_number' => 'field_confirmation_number',
    'field_first_name' => 'field_first_name',
    'field_last_name' => 'field_last_name',
    'field_phone' => 'field_phone',
    'field_email' => 'field_email',
    'title' => 'title',
  );
  /* Filter criterion: Content: Type */
  $handler->display->display_options['filters']['type']['id'] = 'type';
  $handler->display->display_options['filters']['type']['table'] = 'node';
  $handler->display->display_options['filters']['type']['field'] = 'type';
  $handler->display->display_options['filters']['type']['value'] = array(
    'redemption' => 'redemption',
  );
  $handler->display->display_options['filters']['type']['group'] = 1;
  /* Filter criterion: Content: OTS Sync Date (field_ots_sync_date) */
  $handler->display->display_options['filters']['field_ots_sync_date_value']['id'] = 'field_ots_sync_date_value';
  $handler->display->display_options['filters']['field_ots_sync_date_value']['table'] = 'field_data_field_ots_sync_date';
  $handler->display->display_options['filters']['field_ots_sync_date_value']['field'] = 'field_ots_sync_date_value';
  $handler->display->display_options['filters']['field_ots_sync_date_value']['operator'] = 'not empty';
  $handler->display->display_options['filters']['field_ots_sync_date_value']['year_range'] = '-0:+0';

  /* Display: Redemption Report */
  $handler = $view->new_display('page', 'Redemption Report', 'page_2');
  $handler->display->display_options['defaults']['title'] = FALSE;
  $handler->display->display_options['title'] = 'Redemption Report';
  $handler->display->display_options['defaults']['arguments'] = FALSE;
  $handler->display->display_options['path'] = 'admin/redemption-report';
  $handler->display->display_options['menu']['type'] = 'normal';
  $handler->display->display_options['menu']['title'] = 'Redemption Report';
  $handler->display->display_options['menu']['weight'] = '-20';
  $handler->display->display_options['menu']['name'] = 'management';
  $handler->display->display_options['menu']['context'] = 0;
  $handler->display->display_options['menu']['context_only_inline'] = 0;

  /* Display: Data export */
  $handler = $view->new_display('views_data_export', 'Data export', 'views_data_export_1');
  $handler->display->display_options['defaults']['title'] = FALSE;
  $handler->display->display_options['title'] = 'Redemption Report';
  $handler->display->display_options['pager']['type'] = 'none';
  $handler->display->display_options['pager']['options']['offset'] = '0';
  $handler->display->display_options['style_plugin'] = 'views_data_export_csv';
  $handler->display->display_options['style_options']['provide_file'] = 1;
  $handler->display->display_options['style_options']['parent_sort'] = 0;
  $handler->display->display_options['style_options']['quote'] = 1;
  $handler->display->display_options['style_options']['trim'] = 0;
  $handler->display->display_options['style_options']['replace_newlines'] = 0;
  $handler->display->display_options['style_options']['header'] = 1;
  $handler->display->display_options['style_options']['keep_html'] = 0;
  $handler->display->display_options['path'] = 'admin/redemption-report/export.csv';
  $handler->display->display_options['displays'] = array(
    'page_2' => 'page_2',
    'default' => 0,
  );
  $handler->display->display_options['sitename_title'] = 0;
  $handler->display->display_options['use_batch'] = 'batch';
  $handler->display->display_options['segment_size'] = '100';
  $export['redemption_report'] = $view;

  return $export;
}
