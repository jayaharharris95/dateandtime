<?php

  namespace Drupal\dateandtime\Services;

  use Drupal\Component\Datetime\DateTimePlus;

  /**
  * Class getTimeFromTimeZone.
  */
  class getTimeFromTimeZone {
    /**
    * Show the current time of the selected Timezone.
    *
    * @param int $timezone
    * The selected Timezone.
    * @return string 
    */
    public function showCurrentTime($timezone) {
      $date = new DateTimePlus("now", $timezone);
      $time = $date->format('jS M Y - g:i a');
      return $time;
    }
  }
?>