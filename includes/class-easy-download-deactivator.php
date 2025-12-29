<?php
/**
 * Fired during plugin deactivation
 *
 * @link https://neoslab.com
 * @since 1.0.0
 *
 * @package Easy_Download
 * @subpackage Easy_Download/includes
*/

/**
 * Class `Easy_Download_Deactivator`
 * This class defines all code necessary to run during the plugin's deactivation
 * @since 1.0.0
 * @package Easy_Download
 * @subpackage Easy_Download/includes
 * @author NeosLab <support@neoslab.com>
*/
class Easy_Download_Deactivator
{
	/**
	 * Deactivate plugin
	 * @since 1.0.0
	*/
	public static function deactivate()
	{
        global $wpdb;
        
        $table = $wpdb->prefix.'downloads';
        $query = "DROP TABLE IF EXISTS `".$table."`";
        $fetch = $wpdb->query($query);

		$option = delete_option('_easy_download_options');
        $option = delete_option('_easy_download_links');
	}
}

?>