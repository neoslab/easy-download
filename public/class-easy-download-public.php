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
	 * Helper function to get content type based on file extension
	*/
	private function get_file_type($extension)
	{
		$file_types = [
			'deb' => 'application/vnd.debian.binary-package',
			'exe' => 'application/x-msdownload',
			'zip' => 'application/zip',
			'tar' => 'application/x-tar',
			'gz' => 'application/gzip',
			'pdf' => 'application/pdf',
			'jpg' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png' => 'image/png',
			'gif' => 'image/gif',
			'txt' => 'text/plain',
			'html' => 'text/html',
			'php' => 'text/plain',
			'css' => 'text/css',
			'js' => 'application/javascript',
			'json' => 'application/json',
			'xml' => 'application/xml',
			'csv' => 'text/csv',
		];
		
		return isset($file_types[$extension]) ? $file_types[$extension] : 'application/octet-stream';
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

					$file_link = $load[$uuid];
					$file_name = basename($file_link);
					$file_extn = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
					$file_type = $this->get_file_type($file_extn);
					
					header('Content-Type: '.$file_type);
					header('Content-Disposition: attachment; filename="'.$file_name.'"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					
					if(filter_var($file_link, FILTER_VALIDATE_URL)) 
					{
						$context = stream_context_create([
							'ssl' => [
								'verify_peer' => false,
								'verify_peer_name' => false,
							],
							'http' => [
								'follow_location' => true,
								'timeout' => 30,
							]
						]);
						
						$handle = fopen($file_link, 'rb', false, $context);
						if($handle) 
						{
							while(!feof($handle)) 
							{
								echo fread($handle, 8192);
								flush();
							}
							fclose($handle);
						} 
						else 
						{
							header('Location: '.$file_link);
						}
					} 
					else 
					{
						if(file_exists($file_link)) 
						{
							header('Content-Length: '.filesize($file_link));
							readfile($file_link);
						} 
						else 
						{
							header('Location: '.$file_link);
						}
					}
					
					die();
				}
			}
		}
	}
}

?>