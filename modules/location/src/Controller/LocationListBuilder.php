<?php

namespace Drupal\location\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a list controller for location entity.
 *
 * @ingroup location
 */
class LocationListBuilder extends EntityListBuilder {
  /**
   * The url generator.
   *
   * @var \Drupal\Core\Routing\UrlGeneratorInterface
   */
  protected $urlGenerator;

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity.manager')->getStorage($entity_type->id()),
      $container->get("url_generator")
    );
  }

  /**
   * Constructs a new LocationListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Routing\UrlGeneratorInterface $url_generator
   *   The url generator.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, UrlGeneratorInterface $url_generator) {
    parent::__construct($entity_type, $storage);
    $this->urlGenerator = $url_generator;
  }

  /**
   * {@inheritdoc}
   *
   * We override ::render() so that we can add our own content above the table.
   * parent::render() is where EntityListBuilder creates the table using our
   * buildHeader() and buildRow() implemetations.
   */
  public function render() {
    $build['description'] = [
      '#markup' => $this->t('Location Entity implements a location model. These locations are fieldable entities. You can manage the fields on the <a href="@adminlink"> Locations admin page</a>.', [
        '@adminlink' => \Drupal::urlGenerator()->generateFromRoute('location.settings'),
      ]),
    ];
    $build['table'] = parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   *
   * Building the header and content lines for the location list.
   *
   * Calling the parent::buildHeader() adds a column for the possible actions
   * and insert the 'edit' and 'delete' links as defined for the entity type.
   */
  public function buildHeader() {
    $header['name'] = $this->t('Location name');
    $header['type'] = $this->t('Location type');
    $header['phone'] = $this->t('Phone');
    $header['id'] = $this->t('Loc ID');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\location\Entity\Location */
    $row['name'] = $entity->link();
    $row['type'] = $entity->type->value;
    $row['phone'] = $entity->phone->value;
    $row['id'] = $entity->id();
    return $row + parent::buildRow($entity);
  }

}
