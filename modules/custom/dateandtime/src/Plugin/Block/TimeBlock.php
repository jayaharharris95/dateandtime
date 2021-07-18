<?php

namespace Drupal\dateandtime\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\dateandtime\Services\getTimeFromTimeZone;
use Drupal\dateandtime\Services\getWeatherData;

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
  * @var $weather \Drupal\dateandtime\Services\getWeatherData
  */
  protected $weather;


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
      $container->get('currenttime'),
      $container->get('weather_service')
    );
  }

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\dateandtime\Services\getTimeFromTimeZone $currenttime
   * @param \Drupal\dateandtime\Services\getWeatherData $weather
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, getTimeFromTimeZone $currenttime, getWeatherData $weather) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currenttime = $currenttime;
    $this->weather = $weather;
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
    $block_data['weather'] = $this->weather->showWeather($block_data['city']);
    
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