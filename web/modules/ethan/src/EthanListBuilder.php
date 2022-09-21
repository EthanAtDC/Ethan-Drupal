<?php

namespace Drupal\ethan;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Entity;
use Symfony\Component\DependencyInjection\ContainerInterface;

// Creating a list controller for the my-content entity
class EthanListBuilder extends EntityListBuilder {

    // Class variables
    protected $dateFormatter;

    // Constructor
    public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, DateFormatterInterface $date_formatter)
    {
        parent::__construct($entity_type, $storage);
        $this->dateFormatter = $date_formatter;
    }

    // Create container instance
    public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type)
    {
        return new static(
            $entity_type,
            $container->get('entity_type.manager')->getStorage($entity_type->id()),
            $container->get('date.formatter')
        );
    }

    public function render()
    {
        $build['table'] = parent::render();

        $total = $this->getStorage()
            ->getQuery()
            ->accessCheck(FALSE)
            ->count()
            ->execute();
        
        $build['summary']['#markup'] = $this->t('Total my-contents: @total', ['@total' => $total]);

        return $build;

    }

    public function buildHeader()
    {
        $header['id'] = $this->t('ID');
        $header['label'] = $this->t('Label');
        $header['status'] = $this->t('Status');
        $header['uid'] = $this->t('Author');
        $header['created'] = $this->t('Created');
        $header['changed'] = $this->t('Updated');

        return $header + parent::buildHeader();
    }

    public function buildRow(EntityInterface $entity)
    {
        $row['id'] = $entity->id();
        $row['label'] = $entity->toLink();
        $row['status'] = $entity->get('status')->value ? $this->t('Enabled') : $this->t('Disabled');
        $row['uid']['data'] = [
            '#theme' => 'username',
            '#account' => $entity->getOwner(),
        ];

        $row['created'] = $this->dateFormatter->format($entity->get('created')->value);
        $row['changed'] = $this->dateFormatter->format($entity->getChangedTime());
        return $row + parent::buildRow($entity);
        
    }

}