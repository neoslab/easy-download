<?php
/**
 * The public-facing functionality of the plugin
 *
 * @link https://neoslab.com
 * @since 1.0.0
 * @package Maintenance_Work
 * @subpackage Maintenance_Work/public
*/

/**
 * Class `Easy_Download_Public`
 * @package Maintenance_Work
 * @subpackage Maintenance_Work/public
 * @author NeosLab <support@neoslab.com>
*/
class Easy_Download_Public
{
	/**
	 * The ID of this plugin
	 * @since 1.0.0
	 * @access private
	 * @var string $pluginName the ID of this plugin
	*/
	private $pluginName;

	/**
	 * The version of this plugin
	 * @since 1.0.0
	 * @access private
	 * @var string $version the current version of this plugin
	*/
	private $version;

	/**
	 * Initialize the class and set its properties
	 * @since 1.0.0
	 * @param string $pluginName the name of the plugin
	 * @param string $version the version of this plugin
	*/
	public function __construct($pluginName, $version)
	{
		$this->pluginName = $pluginName;
		$this->version = $version;
	}

	/**
	 * Return the `front-end` output
	*/
	public function return_frontend_output()
	{
		global $wpdb;

		$easydownload = get_option('_easy_download_options');
	    if((isset($easydownload['stats'])) && ($easydownload['stats'] === 'on'))
	    {
	    	if(((isset($_GET['action'])) && ($_GET['action'] === 'download'))
	    	&& ((isset($_GET['uuid'])) && (!empty($_GET['uuid']))))
	    	{
	    		$uuid = esc_sql(sanitize_text_field($_GET['uuid']));
	    		$load = unserialize(get_option('_easy_download_links'));
	    		if(!isset($load[$uuid]))
	    		{
	    			/**
				     * Redirect
				    */
			        header('location:'.get_site_url());
			    	die();
			    }
			    else
			    {
				    $sqlc = "SELECT `count` FROM `".$wpdb->prefix."downloads` WHERE `uuid` = '".$uuid."' AND `date` = '".date('Y-m-d')."'";
				    $resc = $wpdb->get_results($sqlc);
				    if(empty($resc))
				    {
				    	$sqlh = "INSERT INTO `".$wpdb->prefix."downloads` (`uuid`, `date`, `count`) VALUES ('".$uuid."', '".date('Y-m-d')."', '1')";
				        $resh = $wpdb->query($sqlh);
				    }
				    else
				    {
						$stat = esc_sql($resc[0]->count + 1);
				    	$sqlp = "UPDATE `".$wpdb->prefix."downloads` SET `count` = '".$stat."' WHERE `uuid` = '".$uuid."' AND `date` = '".date('Y-m-d')."'";
				        $resp = $wpdb->query($sqlp);
				    }

				    /**
				     * Redirect
				    */
			        header("Location:".$load[$uuid]);
			        die();
			    }
	    	}
	    }
	}
}

?>