<?php

  namespace Drupal\dateandtime\Services;

  use Drupal\Component\Serialization\Json;

  /**
  * Class getTimeFromTimeZone.
  */
  class getWeatherData {

    /**
    * @var \GuzzleHttp\Client
    */
    protected $client;

    /**
    * CatFactsClient constructor.
    *
    * @param $http_client_factory \Drupal\Core\Http\ClientFactory
    */
    public function __construct($http_client_factory) {
      $this->client = $http_client_factory->fromOptions([
        'base_uri' => 'http://api.weatherapi.com/',
      ]);
    }

    /**
   * Get Weather Data.
   *
   * @param int $amount
   *
   * @return array
   */
  public function showWeather($city) {
    $response = $this->client->get('v1/current.json', [
      'query' => [
        'key' => '651626f96f5249f1836151020211207',
        'q' => $city,
        'aqi' => 'no'
      ]
    ]);

    return Json::decode($response->getBody());
  }

  }
?>