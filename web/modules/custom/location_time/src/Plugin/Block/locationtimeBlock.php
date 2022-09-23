<?php 

namespace Drupal\location_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DrupalDateTime;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\location_time\LocationtimezoneService;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Cache\CacheBackendInterface;
use	Drupal\Core\PageCache\ResponsePolicy\KillSwitch;


/** 
 * @Block(
 * 	id = "location_time",
 *  admin_label = @Translation("Location Time"),
 *  category = @Translation("Custom block for location time")
 * )
 * 
 */

class locationtimeBlock extends BlockBase implements ContainerFactoryPluginInterface {

	protected $timezone;
	protected $configFactory;
	protected $staticCache;
	protected $killCache;

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
	      $container->get('location_time.timezone'),
	      $container->get('config.factory'),
	      $container->get('cache.default'),
	      $container->get('page_cache_kill_switch')
	    );
  	}

	/**
	* @param array $configuration
	* @param string $plugin_id
	* @param mixed $plugin_definition
	* @param Drupal\location_time\LocationtimezoneService $timezone
	* @param Drupal\Core\Config\ConfigFactory $configFactory
	* @param Drupal\Core\PageCache\ResponsePolicy\KillSwitch $killCache
	*/

	public function __construct(array $configuration, $plugin_id, $plugin_definition, LocationtimezoneService $timezone, ConfigFactory $configFactory, CacheBackendInterface $staticCache, KillSwitch $killCache) {
	    parent::__construct($configuration, $plugin_id, $plugin_definition);
	    $this->timezone = $timezone;
	    $this->configFactory = $configFactory;
	    $this->staticCache = $staticCache;
	    $this->killCache = $killCache;
	}

	public function build() {
		$config = $this->configFactory->get('locationtime.adminsettings');
		$country = $config->get('country');
		$city = $config->get('city');

		$loadData = $this->timezone->getTimezone();
		$date = new DrupalDateTime("now", $loadData);
		$finaldate = $date->format('l, d F Y');
		$finaltime = $date->format('h:i a');

		$this->killCache->trigger();

		return [
			'#theme' => 'my_template',
			'#country' => $country,
			'#city' => $city,
			'#time' => $finaltime,
			'#date' => $finaldate,
			'#cache' => ['max-age' => 0]
		];
	}
}