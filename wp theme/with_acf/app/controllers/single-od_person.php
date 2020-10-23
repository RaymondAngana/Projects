<?php

namespace App;

use Sober\Controller\Controller;

class SingleOdPerson extends Controller
{
  const LEARN_MORE_ACCORDIONS = array(
    'Experience' => array('experience'),
    'Education & Admittance to Practice' => array('education', 'bar_admission'),
    'Professional Activities & Speeches' => array('professional_activities', 'speeches'),
    'Published Works' => array('published_works'),
    'Media Quotes' => array('media_quotes'),
    'Honors & Awards' => array('honors_and_awards'),
    'Past Cases' => array('past_cases')
  );
  private const TOP_ACCORDIONS = array(
    'Practice Groups' => array('practice_groups'),
    'Industry Groups' => array('industry_groups')
  );
  public static function other_print_components() {
    return array(
      'Insights' => array(
        'name' => 'Insights',
        'fields' => array(),
        'selectors' => array('#insights'),
        'visible' => false,
        'render' => (isset($_REQUEST['toggled_components']) && isset($_REQUEST['toggled_components']['Insights']))
          ? self::should_render('Insights', $_REQUEST['toggled_components'])
          : false
      ),
      'Webinars & Seminars' => array(
        'name' => 'Webinars & Seminars',
        'fields' => array(),
        'selectors' => array('#webinars-seminars'),
        'visible' => false,
        'render' => (isset($_REQUEST['toggled_components']) && isset($_REQUEST['toggled_components']['Webinars & Seminars']))
          ? self::should_render('Webinars & Seminars', $_REQUEST['toggled_components'])
          : false
      )
    );
  }
  private static function accordions() { 
    return array_merge(
      self::TOP_ACCORDIONS,
      self::LEARN_MORE_ACCORDIONS
    );
  }
  public static function should_render($component_name, $toggled_components){
    if($component_name === 'Education & Admittance to Practice' && $toggled_components['One Page Bio'] == '1'){
      return true;
    }
    return isset($toggled_components[$component_name])
      && $toggled_components[$component_name] == '1';
  }
  public static function accordion_print_components() {
    $result = array();
    foreach(self::accordions() as $title => $fields) {
      $result = array_merge(
        $result,
        array(
          $title => array(
            'name' => $title,
            'fields' => $fields,
            'selectors' => array(
              '#heading-' . sanitize_title($title),
              '#content-' . sanitize_title($title)
            ),
            'visible' => true,
            'render' => isset($_REQUEST['toggled_components'])
              ? self::should_render($title, $_REQUEST['toggled_components'])
              : true
          )
        )
      );
    }
    return $result;
  }
  public static function print_components() {
    return array_merge(
      array(
        'One Page Bio' => array(
          'name' => 'One Page Bio',
          'fields' => array(),
          'selectors' => array(''),
          'visible' => false,
          'render' => true 
        )
      ),
      self::accordion_print_components(),
      self::other_print_components()
    );
  }
  public static function has_rendered_component($components) {
    foreach($components as $component) {
      if($component['render']) {
        return true;
      }
    }
    return false;
  }
  function __construct() {
  }
}
