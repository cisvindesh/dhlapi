<?php

namespace Drupal\dhlapi;

use Drupal\Component\Serialization\Json;

class DhlApiClient {

  /**
   * @var \GuzzleHttp\Client
   */
  protected $client;
  protected $config;

  /**
   * DhlApiClient constructor.
   *
   * @param $http_client_factory \Drupal\Core\Http\ClientFactory
   */
  public function __construct($http_client_factory) {
    $this->config = \Drupal::config('dhlapi.dhlapiconfig');
    $this->client = $http_client_factory->fromOptions([
      'base_uri' => $this->config?$this->config->get('base_url'):'',
    ]);

  }

  /**
   * Get some random cat facts.
   *
   * @param string $countryCode
   *
   * @param string $addressLocality
   *
   * @param string $postalCode
   *
   * @return array
   */
  public function location_finder($countryCode = 'GB', $addressLocality = 'London', $postalCode = 'E1 6BD') {
    if($this->config) {
      try {
        $response = $this->client->get($this->config->get('endpoint'),   [
          'headers' => [
            'DHL-API-Key' => $this->config->get('api_key'),
            'Content-Type' => 'application/json'
          ],
          'query' => [
            'countryCode' => $countryCode,
            'addressLocality' => $addressLocality,
            'postalCode' => $postalCode,
          ],
        ]);
        $data = $response->getBody();
      }
      catch (RequestException $e) {
        watchdog_exception('dhlapi', $e->getMessage());
      }
      return Json::decode($data);
    }else{
      return null;
    }
  }
}
