<?php

namespace Drupal\ethan\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Drupal\ethan\Entity\Ethan;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for ethan routes.
 */
class EthanController extends EntityListBuilder {

  protected $urlGenerator;


  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, UrlGeneratorInterface $url_generator) {
    parent::__construct($entity_type, $storage);
    $this->urlGenerator = $url_generator;
  }

  public function render() {
    $build['description'] = [
      '#markup' => $this->t('Content Entity Example', [
        '@adminlink' => $this->urlGenerator->generateFromRoute('/ethan-form'),
      ]),
    ];
    $build['table'] = parent::render();
    return $build;
  }

  public function buildHeader() {
    $header['content'] = $this->t('Content');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\content_entity_example\Entity\Contact */
    $row['content'] = $entity->toLink()->toString();
    return $row + parent::buildRow($entity);
  }


}
