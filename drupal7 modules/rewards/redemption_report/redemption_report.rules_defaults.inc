<?php
/**
 * @file
 * propco_redemption_report.rules_defaults.inc
 */

/**
 * Implements hook_default_rules_configuration().
 */
function propco_redemption_report_default_rules_configuration() {
  $items = array();
  $items['rules_propco_agent_login'] = entity_import('rules_config', '{ "rules_propco_agent_login" : {
      "LABEL" : "Propco Agent Login",
      "PLUGIN" : "reaction rule",
      "OWNER" : "rules",
      "REQUIRES" : [ "rules" ],
      "ON" : { "user_login" : [] },
      "IF" : [
        { "user_has_role" : { "account" : [ "account" ], "roles" : { "value" : { "6" : "6" } } } }
      ],
      "DO" : [ { "redirect" : { "url" : "admin\\/redemption-report" } } ]
    }
  }');
  return $items;
}
