<?php
/**
*	Form builder. Import Propco Reward Pins
*
*	@ingroup forms
*
*
*/

function propco_pin_import_pin_import_page($node){

	$module_path = drupal_get_path('module', 'propco_pin_import');

	//get the program id, pass to the import form
	$program_id = $node->nid;

	$form = drupal_get_form('propco_pin_import_pin_import_form', $program_id);

	$output = "<p>Program Pin Import</p>";
	$output .= drupal_render($form);

	return $output;
}

function propco_pin_import_pin_import_form($form, $form_state , $program_id){

	$form = array();

	$form['#attributes'] = array(
		'enctype' => 'multipart/form-data'
	);

	$form['pin_file'] = array(
		'#title' => t('PIN File'),
		'#type'  => 'file',
		'#description' => ($max_size = parse_size(ini_get('upload_max_filesize'))) ? t('Due to server restrictions, the <strong>maximum upload file size is !max_size</strong>. Files that exceed this size will be disregarded.', array('!max_size' => format_size($max_size))) : '',
	);

	$form['pin_program_nid'] = array(
		'#type' => 'hidden',
		'#value' => $program_id,
	);


	$format = "d-m-Y";
	$date = date("d-m-Y");

	$form['pin_start_date'] = array(
		'#type' => 'date_select',
		'#title' => t('Pin Start Date'),
		'#default_value' => !empty($form_state['values']['pin_start_date']) ? $form_state['values']['pin_start_date'] : $date,
		'#date_format' => $format,
		'#date_label_position' => 'within',
		'#date_year_range' => '-3:+3',
	);

	$form['pin_expire_date'] = array(
		'#type' => 'date_select',
		'#title' => t('Pin Expiration Date'),
		'#date_format' => $format,
		'#default_value' => !empty($form_state['values']['pin_expire_date']) ? $form_state['values']['pin_expire_date'] : '',
		'#date_label_position' => 'within',
		'#date_year_range' => '0:+3',
	);

	$form['submit'] = array(
		'#type' => 'submit',
		'#value' => t('Import'),
	);
	$form['#validate'] = array(
		'propco_pin_import_pin_import_validate_fileupload',
		'propco_pin_import_pin_import_form_validate',
	);
	return $form ;
}

function propco_pin_import_pin_import_validate_fileupload(&$form, &$form_state) {
	$validators = array(
		'file_validate_extensions' => array( 'csv' ),
	);
	if ( $file = file_save_upload('pin_file', $validators, "private://", FILE_EXISTS_REPLACE) ){
		$form_state['values']['pin_fileupload'] = $file->destination;
	}
	else {
		form_set_error('Pin Imports', t('Unable to copy upload file to !dest', array('!dest' => $destination)));
	}
}

function propco_pin_import_pin_import_form_validate(&$form, &$form_state) {

  if ( isset( $form_state['values']['pin_fileupload'] ) ) {
    if ( $handle = fopen($form_state['values']['pin_fileupload'], 'r') ) {
      $line_count = 0 ;
      $first = TRUE;
      if ( $line = fgetcsv($handle, 4096) ) {

          if(count($line) < 1){
            form_set_error('csvfile', t('This file has the incorrect number of columns. Expecting at least 1'));
          }
      }
      fclose($handle);
    }
    else {
      form_set_error('pin_file', t('Unable to read uploaded file !filepath', array('!filepath' => $form_state['values']['pin'])));
    }
  }
}
function propco_pin_import_pin_import_form_submit(&$form, &$form_state) {
	$batch = array(
		'title' => t('Importing Pins ...'),
		'operations' => array(),
		'init_message' => t('Commencing'),
		'progress_message' => t('Processed @current out of @total.'),
		'error_message' => t('An error occurred during processing'),
		'finished' => 'propco_pin_import_pin_import_finished',
 		'file' => drupal_get_path('module', 'propco_pin_import') . '/propco_pin_import_pin_import.inc',
	);

	if(isset($form_state['values']['pin_fileupload'])){
		if ($handle = fopen($form_state['values']['pin_fileupload'], 'r')){

			/*$batch['operations'][] = array('_propco_pin_import_pin_import_remember_info', array( $form_state['values']['pin_fileupload'],
				$form_state['values']['pin_start_date'],
				$form_state['values']['pin_expire_date'],
				$form_state['values']['pin_program_nid'],
				)
			);*/

			$line_count = 0 ;
			$first = FALSE ;
			//$line = fgetcsv($handle, 4096);
			while ( $line = fgetcsv($handle, 4096) ) {
				/**
				* we use base64_encode to ensure we don't overload the batch
				* processor by stuffing complex objects into it
				*/
				if(!empty($line)){
        			$batch['operations'][] = array('_propco_pin_import_pin_import_pin', array(array_map('base64_encode', $line),
        				$form_state['values']['pin_start_date'],
						$form_state['values']['pin_expire_date'],
						$form_state['values']['pin_program_nid']));
        		}
			}
			fclose($handle);
		} // we caught this in propco_pin_import_pin_import_form_validate()
	} // we caught this in propco_pin_import_pin_import_form_validate()
	batch_set($batch);
}
function propco_pin_import_pin_import_finished($success, $results, $operations) {

  drupal_set_message(t("Import complete"), 'status', FALSE);

  return t('The Pin import has completed.');
}

function _propco_pin_import_pin_import_remember_info($filename,$pinstart, $pinexpire, $programnid, &$context) {
  	$context['results']['uploaded_filename'] = $filename;
  	$context['results']['pin_start_date'] = $pinstart;
  	$context['results']['pin_expire_date'] = $pinexpire;
  	$context['results']['pin_program_nid'] = $programnid;

}

function _propco_pin_import_pin_import_pin($line, $pinstart, $pinexpire, $programnid) {

	if(!empty($context['results']['rows_imported'])){

		$context['results']['rows_imported']++;

	}
	else{
		$context['results']['rows_imported'] = 0;
	}

	$line = $cleaned_line = array_map('base64_decode', $line);

	//Show the row count by default
	$context['message'] = t('Importing row !c', array( '!c' => $context['results']['rows_imported'] ));

	$context['message'] = t('Importing %title', array('%title' => $line[0]));

	//create our pin with the defualt values specified in the form
    if (propco_pin_import_pin_import_check_duplicate($line[0])) {

    	if(empty($line[1])){
			propco_pin_import_pin_import_create($line[0], $programnid, $pinstart, $pinexpire);

		}
		else{
			propco_pin_import_pin_import_create($line[0],$programnid, $pinstart, $line[1]);

		}
  	}
  	else{

	    $context['results']['failed_rows'][] = $line ;
  		drupal_set_message(t('Pin %title was already imported , skipping', array('%title' => $line[0])), 'status', FALSE);
	}
}

function propco_pin_import_pin_import_create($title , $program, $start, $expire){
	global $user;

	$values = array(
	  'type' => 'pin',
	  'uid' => $user->uid,
	  'status' => 1,
	  'comment' => 0,
	  'promote' => 0,
	  'title' => _propco_encryption_pin_encrypt_decrypt($title, 'encrypt'),
	);

	$pin = entity_create('node', $values);

	$pinwrapper = entity_metadata_wrapper('node', $pin);

	$ref_program = node_load($program);

	$pinwrapper->field_program->set($ref_program);

	// Entity API cannot set date field values so the 'old' method must
	// be used

	$start_date = new DateTime($start);

	$pin->field_pin_start[LANGUAGE_NONE][0] = array(
	   'value' => date_format($start_date, 'Y-m-d'),
	   'timezone' => 'UTC',
	   'timezone_db' => 'UTC',
	 );

	if(!empty($expire)){
		$expire_date = new DateTime($expire);

		$pin->field_pin_expire[LANGUAGE_NONE][0] = array(
	   	'value' => date_format($expire_date, 'Y-m-d'),
	   	'timezone' => 'UTC',
	   	'timezone_db' => 'UTC',
	 	);
	}

	$pinwrapper->save();



}

function propco_pin_import_pin_import_check_duplicate($title){
	$title = _propco_encryption_pin_encrypt_decrypt($title, 'encrypt');
	$query = new EntityFieldQuery();
	$result = $query->entityCondition('entity_type','node')
  	->entityCondition('bundle', 'pin')
  	->propertyCondition('title', $title)
 	->execute();

	return empty($result['node']);

}
