<?php 

namespace Drupal\location_time\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DrupalDateTime;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\location_time\LocationtimezoneService;

/** 
 * @Block(
 * 	id = "location_time",
 *  admin_label = @Translation("Location Time"),
 *  category = @Translation("Custom block for location time")
 * )
 * 
 */

class locationtimeBlock extends BlockBase {

	public function build() {
		$config = \Drupal::config('locationtime.adminsettings');
		$country = $config->get('country');
		$city = $config->get('city');

		$loadData = \Drupal::service('location_time.timezone')->getTimezone();
		$date = new DrupalDateTime("now", $loadData);
		$finaldate = $date->format('l, d F Y');
		$finaltime = $date->format('h:i a');

		\Drupal::service('page_cache_kill_switch')->trigger();

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