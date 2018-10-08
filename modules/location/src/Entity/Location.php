<?php
/**
 * @file
 * Contains \Drupal\location\Entity\Location
 */

namespace Drupal\location\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\location\LocationInterface;
use Drupal\user\UserInterface;

/**
 *Defines the Location entity
 *
 * @ingroup location
 *
 * @ContentEntityType (
 *   id = "location",
 *   label = @Translation("Location"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\location\Entity\Controller\LocationListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\location\Form\LocationForm",
 *       "edit" = "Drupal\location\Form\LocationForm",
 *       "delete" = "Drupal\location\Form\LocationDeleteForm.php",
 *     },
 *     "access" = "Drupal\location\LocationAccessControlHandler",
 *   },
 *   base_table = "location",
 *   entity_keys = {
 *    "id" = "id",
 *    "label" = "name",
 *    "uuid" = "uuid",
 *   },
 *   admin_permission = "administer location entity",
 *   links = {
 *    "canonical" = "/location/{location}",
 *    "edit_form" = "/location/{location}/edit",
 *    "delete_form" = "/location/{location}/delete",
 *    "list" = "/location/list",
 *   },
 *   fiels_ui_base_route = "location.settings",
 * )
 */

class Location extends ContentEntityBase implements LocationInterface {

  /**
   * {@inheritdoc}
   *
   * When a new entity instance is added, set user_id entity reference to
   * the current user as creator of the instance.
   */

  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCreateTime() {
      return $this->get('created')->value;
  }

  public function getChangedTime() {
    return $this->get('changed')->value;
  }

  public function setChangedTime($timestamp) {
    $this->set('changed', $timestamp);
    return $this;
  }

  public function getChangedTimeAcrossTranslations() {
    $changed = $this->getUntranslated()->getChangedTime();
//    foreach ($this->getTranslationLanguages(FALSE) as $language) {
//      $translation_changed = $this->getTranslation($language->getId())->getChangedTime();
//      $changed = max($translation_changed, $changed);
//    }
    return $changed;
  }

  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   *
   * Define the base table fields properties here.
   *
   * Field name, type and size determine the table structure.
   *
   * In addition, we can define how the field and its content can be manipulated
   * in the GUI, The behaviour of the widgets used can be determinated here.
   */

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    // Standard field, used as unique if primary index.
    $field['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Location entity.'))
      ->setReadOnly(TRUE);

    //Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Location entity.'))
      ->setReadOnly(TRUE);

    // Name field for the location.
    //We set display options for the view as well as the form.
    //Users with correct privilieges can change the view and edit configurations.
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the location entity'))
      ->setSettings(array(
        'default_value' => '',
        'max_lenght' => 255,
      ))
      ->setDisplayOptions('view', array(
        'label' =>'above',
        'type' => 'string',
        'weight' => -6,
      ))
      ->setDisplayOptions('form',array(
        'type' => 'string_textfield',
        'weight' => -6,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Type field for the location
    // ListTextType with a drop down menu widget
    // The Values shown in the widget are 'Point' and 'Area'
    // In the view the field content is shown as string
    // In the form the choices are presented as options list.
    $fields['type'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Location type'))
      ->setDescription(t('The type of the location Entity.'))
      ->setSettings(array(
        'allowed_values' =>array(
          'point' => 'Point',
          'area' => 'Area',
        ),
      ))
      ->setDisplayOptions('view', array(
        'label'=> 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['phone'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Location main phone number'))
      ->setDescription(t('The main phone number of the location entity.'))
      ->setSettings(array(
        'default_value' => '',
        'max_lenght' => 255,
      ))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -5,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -5
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Creator field of the location.
    // Entity reference field, holds the reference to the user object.
    // The view shows the user name field of the user
    // The form presents an auto complete field for the user name.
    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Owner user name'))
      ->setDescription(t('The name of the owner user.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'entity_reference',
        'weight' => -3,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'autocomplete_type' => 'tags',
          'placeholder' => ''
        ),
        'weight' => -3,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code of Location entity'));

    $fields['created'] = BaseFieldDefinition::create(t('created'))
      ->setLabel(t('Created'))
      ->setDescription(t('The time thatthe entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }
}
