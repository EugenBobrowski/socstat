<?php
/**
 * @package Hello_Dolly
 * @version 1.6
 */
/*
Plugin Name: Soc Stat
Plugin URI: http://wordpress.org/plugins/soc-stat/
Description:
Author: Eugen Bobrowski
Version: 1.0
Author URI: http://ma.tt/
*/

class Soc_Stat_Chart
{

	protected static $instance;

	private function __construct()
	{

	}

	public function shortcode ($atts) {
		return 'chart';
	}

	public static function get_instance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

Soc_Stat_Chart::get_instance();