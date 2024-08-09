<?php

namespace Drupal\dhlapi\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Provides a 'DhlApiBlock' block.
 *
 * @Block(
 *  id = "dhl_api_block",
 *  admin_label = @Translation("Dhl api block"),
 * )
 */
class DhlApiBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $dhlApiClient;

  /**
   * CatFacts constructor.
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param $dhl_api_client \Drupal\dhlapi\DhlApiClient
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, $dhl_api_client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->dhlApiClient = $dhl_api_client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('dhlapi_location_client')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['#theme'] = 'dhl_api_block';
    $build['dhl_api_block']['#markup'] = 'Implement DhlApiBlock.';

    $request = \Drupal::request()->query->all();
    // $country = $this->request()->query->get('country');
    // $city = $this->request()->query->get('city');
    // $postcode = $this->request()->query->get('postcode');
    dpm($request );
    if(isset($request['country']) && isset($request['city'])) {
      //params: Countrycode, City, Postcode
      $dhlapiLocations = $this->dhlApiClient->location_finder($request['country'], $request['city'], $request['postcode']);
      if($dhlapiLocations['locations']) {
        $build['#content'] = $dhlapiLocations['locations'];
      }
    }

    $build['#text'] = 'Record not found!';
    $build['#cache'] = [ 'max-age' => 0 ];

    /*dump($dhlapiLocations);

    return [
      '#theme' => 'item_list',
      '#items' => $dhlapiLocations['locations'],
    ];*/

    return $build;
  }

}
