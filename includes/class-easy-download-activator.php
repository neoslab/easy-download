<?php
/**
 * Fired during plugin activation
 *
 * @link https://neoslab.com
 * @since 1.0.0
 *
 * @package Easy_Download
 * @subpackage Easy_Download/includes
*/

/**
 * Class `Easy_Download_Activator`
 * This class defines all code necessary to run during the plugin's activation
 * @since 1.0.0
 * @package Easy_Download
 * @subpackage Easy_Download/includes
 * @author NeosLab <support@neoslab.com>
*/
class Easy_Download_Activator
{
	/**
	 * Activate plugin
	 * @since 1.0.0
	*/
	public static function activate()
	{
		$option = add_option('_easy_download_options', false);
        $option = add_option('_easy_download_links', false);
	}
}

?>