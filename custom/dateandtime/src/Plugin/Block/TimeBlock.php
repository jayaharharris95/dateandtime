<?php

namespace Drupal\dateandtime\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\dateandtime\Services\getTimeFromTimeZone;

/**
 * Provides a 'TimeZone' block.
 *
 * @Block(
 *   id = "time_block",
 *   admin_label = @Translation("Time Block"),
 * )
 */
class TimeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
  * @var $currenttime \Drupal\dateandtime\Services\getTimeFromTimeZone
  */
  protected $currenttime;


  /**
  * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
  * @param array $configuration
  * @param string $plugin_id
  * @param mixed $plugin_definition
  *
  * @return static
  */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('currenttime')
    );
  }

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\dateandtime\Services\getTimeFromTimeZone $currenttime
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, getTimeFromTimeZone $currenttime) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currenttime = $currenttime;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $block_data = [];
    $dateandtime_config = \Drupal::config('dateandtime.settings');
    $block_data['country'] = $dateandtime_config->get('country');
    $block_data['city'] = $dateandtime_config->get('city');
    $timezone = $dateandtime_config->get('time_zone');
    $block_data['time'] = $this->currenttime->showCurrentTime($timezone);
    $build = [
      '#theme' => 'dateandtime__time_zone',
      '#country' => $block_data['country'],
      '#city' => $block_data['city'],
      '#time' => $block_data['time'],
    ];
    return $build;
  }

  //prevent block from caching.
  public function getCacheMaxAge() {
    return 0;
  }
}