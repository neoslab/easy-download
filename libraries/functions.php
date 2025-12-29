<?php
/**
 * Return total downloads
 * @param $uuid the file unique identifier
 * @return void
 * @author NeosLab
*/
if(!function_exists('easy_download_total'))
{
    function easy_download_total($uuid) 
    {
    	global $wpdb;
    	
    	$uuid = esc_sql($uuid);
	    $sql = "SELECT SUM(`count`) as `count` FROM `".$wpdb->prefix."downloads` WHERE `uuid` = '".$uuid."'";
	    $res = $wpdb->get_results($sql);
	    if(empty($res))
	    {
	    	/**
		     * Redirect
		    */
	        header('location:'.get_site_url());
	    	die();
	    }
	    else
	    {
	    	/**
		     * Retrieve Download information
		    */
	    	$file = $res[0];
	    	return $file->count;
		}
	}
}

?>