<?php

require_once 'primarycontact.civix.php';
// phpcs:disable
use CRM_Primarycontact_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function primarycontact_civicrm_config(&$config) {
  _primarycontact_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function primarycontact_civicrm_install() {
  _primarycontact_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function primarycontact_civicrm_postInstall() {
  _primarycontact_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function primarycontact_civicrm_uninstall() {
  _primarycontact_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function primarycontact_civicrm_enable() {
  _primarycontact_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function primarycontact_civicrm_disable() {
  _primarycontact_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function primarycontact_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _primarycontact_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function primarycontact_civicrm_entityTypes(&$entityTypes) {
  _primarycontact_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function primarycontact_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function primarycontact_civicrm_navigationMenu(&$menu) {
//  _primarycontact_civix_insert_navigation_menu($menu, 'Mailings', [
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ]);
//  _primarycontact_civix_navigationMenu($menu);
//}

/**
 * When a new Primary Contact relationship is being made for an Organization,
 * this code makes previous Primary Contacts for that Organization inactive,
 * with an ending date of the creation date of the new relationship
 * so that there is only one Primary Contact per Organization.
 */
function primarycontact_civicrm_postCommit($op, $objectName, $objectId, &$objectRef) {
  if ($op === 'create' && $objectName === 'Relationship') {
    $primaryRelationshipId = current(\Civi\Api4\RelationshipType::get(FALSE)
      ->addSelect('id')
      ->addWhere('name_b_a', '=', 'Primary Contact is')
      ->execute()
      ->first());
    if ($objectRef->relationship_type_id == $primaryRelationshipId) {
      $today = (new \DateTime())->format('Y-m-d');
      \Civi\Api4\Relationship::update(FALSE)
        ->addValue('is_active', FALSE)
        ->addValue('end_date', $today)
        ->addWhere('contact_id_b', '=', $objectRef->contact_id_b)
        ->addWhere('relationship_type_id', '=', $primaryRelationshipId)
        ->addWhere('id', '!=', $objectId)
        ->execute();
    }
  }
}
