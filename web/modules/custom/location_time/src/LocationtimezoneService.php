<?php

namespace Drupal\location_time;

use Drupal\Core\Datetime\DrupalDateTime;

class LocationtimezoneService {

	
	protected $timezone;

	/** 
	 * 	Set timezon acoording to selected timezone from backend config form
	 */

	public function setTimezone() {
		$config = \Drupal::config('locationtime.adminsettings');
		$this->timezone = $config->get('timezone');
	}

	/** 
	 * 	Get timezon acoording to selected timezone from backend config form
	 */

	public function getTimezone() {
		if(empty($this->timezone)) {
			$this->setTimezone();
		}
		return $this->timezone;
	}

	/** 
	 * 	Get current date and time acoording to selected timezone from backend config form
	 */

	public function getLocationTime() {
		$date = new DrupalDateTime("now", $this->getTimezone());
		$new_date = $date->format('dS M Y - H:i A');
		
		return $new_date;
	}


}