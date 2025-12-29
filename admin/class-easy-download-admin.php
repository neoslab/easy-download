<?php
/**
 * The admin-specific functionality of the plugin
 *
 * @link https://neoslab.com
 * @since 1.0.0
 * @package Easy_Download
 * @subpackage Easy_Download/admin
*/

/**
 * Class `Easy_Download_Admin`
 * @package Easy_Download
 * @subpackage Easy_Download/admin
 * @author NeosLab <support@neoslab.com>
*/
class Easy_Download_Admin
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
	 * @param string $pluginName the name of this plugin
	 * @param string $version the version of this plugin
	*/
	public function __construct($pluginName, $version)
	{
		$this->pluginName = $pluginName;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area
	 * @since 1.0.0
	*/
	public function enqueue_styles()
	{
		wp_register_style($this->pluginName.'-fontawesome', plugin_dir_url(__FILE__).'assets/fonts/fontawesome/css/all.min.css', array(), $this->version, 'all');
		wp_register_style($this->pluginName.'-datatables', plugin_dir_url(__FILE__).'assets/styles/datatables.min.css', array(), $this->version, 'all');
		wp_register_style($this->pluginName.'-dashboard', plugin_dir_url(__FILE__).'assets/styles/easy-download-admin.min.css', array(), $this->version, 'all');
		wp_enqueue_style($this->pluginName.'-fontawesome');
		wp_enqueue_style($this->pluginName.'-datatables');
		wp_enqueue_style($this->pluginName.'-dashboard');
	}

	/**
	 * Register the JavaScript for the admin area
	 * @since 1.0.0
	*/
	public function enqueue_scripts()
	{
		wp_register_script($this->pluginName.'-datatables', plugin_dir_url(__FILE__).'assets/javascripts/datatables.min.js', array('jquery'), $this->version, false);
		wp_register_script($this->pluginName.'-script', plugin_dir_url(__FILE__).'assets/javascripts/easy-download-admin.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script($this->pluginName.'-datatables');
		wp_enqueue_script($this->pluginName.'-script');
	}

	/**
	 * Add custom CSS to dashboard
	 * @since 1.0.0
	*/
	public function return_custom_css()
	{
		echo '<style>.download-stat-bars{margin-top:25px;overflow:hidden}.download-stat-bar{margin:0 1%;background-color:#2ea2cc;border-top-color:#fff;border-top-style:solid;float:left}.download-stat-labels{overflow:hidden}.download-stat-label{float:left;margin:0 1%;padding:5px 0;text-align:center}.download-stat-caption{text-align:center;margin:11px 0;font-style:italic}</style>';
	}

	/**
	 * Return the header
	*/
	public function return_plugin_header()
	{
		$html = '<div class="wpdx-header"><span class="header-icon"><i class="fas fa-sliders-h"></i></span> <span class="header-text">'.__('Easy Download', 'easy-download').'</span></div>';
		return $html;
	}

	/**
	 * Return the tabs menu
	*/
	public function return_tabs_menu($tab)
	{
		$link = admin_url('admin.php');
		$list = array
		(
			array('tab1', 'easy-download-options', 'fa-gear', __('Settings', 'easy-download')),
			array('tab2', 'easy-download-form', 'fa-plus', __('Add Form', 'easy-download')),
			array('tab3', 'easy-download-links', 'fa-link', __('Links', 'easy-download'))
		);

		$menu = null;
		foreach($list as $item => $value)
		{
			$html = array('div' => array('class' => array()), 'a' => array('href' => array()), 'i' => array('class' => array()), 'p' => array(), 'span' => array());
			$menu ='<div class="tab-label '.$value[0].' '.(($tab === $value[0]) ? 'active' : '').'"><a href="'.$link.'?page='.$value[1].'"><p><i class="fas '.$value[2].'"></i><span>'.$value[3].'</span></p></a></div>';
			echo wp_kses($menu, $html);
		}
	}

	/**
 	 * Return Widget Download Display
 	*/
	public function widget_downloads_display()
	{
		global $wpdb;

	    $sqlc = "SELECT SUM(`count`) as `count` FROM `".$wpdb->prefix."downloads` GROUP BY `date` ORDER BY `id` DESC LIMIT 5";
	    $resc = $wpdb->get_results($sqlc);

	    if(!empty($resc))
	    {
	    	$total = array();
	        foreach($resc as $row)
	        {
				$total[] = $row->count;
			}

			$counts = array_reverse($total);
		}
		else
		{
			$counts = array(0, 0, 0, 0, 0);
		}

		$hv = max($counts);
		$dp = count($counts);
		$bw = 100 / $dp - 2;
		$th = 120;
		?>
		<div class="download-stat-bars" style="height:<?php echo esc_html($th); ?>px;">
			<?php
			foreach($counts as $count)
			{
				if($hv < 1)
				{
					$hv = 1;
				}

				$cp = $count/$hv;
				$bh = $th * $cp;
				$bd = $th - $bh;
				?>
				<div class="download-stat-bar" style="height:<?php echo esc_html($th); ?>px;border-top-width:<?php echo esc_html($bd); ?>px;width:<?php echo esc_html($bw); ?>%;"></div>
				<?php
			}
			?>
		</div>
		<div class='download-stat-labels'>
			<?php
			foreach($counts as $count)
			{
				?>
				<div class="download-stat-label" style="width:<?php echo esc_html($bw); ?>%;"><?php echo esc_html($count); ?></div>
				<?php
			}
			?>
		</div>
		<div class='download-stat-caption'><?php echo __('Downloads in the past 5 days', 'wpbs'); ?></div>
		<?php
	}

	/**
	 * Return Widget Download Stats
    */
	public function widget_downloads_stats() 
	{
		wp_add_dashboard_widget('download_stats_widget', 'Download Stats', array($this, 'widget_downloads_display'));
	}

	/**
	 * Create Record Database
	*/
	public function create_downloads_database()
	{
		global $wpdb;

		$table = $wpdb->prefix.'downloads';
		if($wpdb->get_var("SHOW TABLES LIKE '$table'") !== $table)
		{
			$charset = $wpdb->get_charset_collate();
			$query = "CREATE TABLE $table(
			id bigint(20) NOT NULL AUTO_INCREMENT,
			uuid varchar(55) NOT NULL,
			date date NOT NULL DEFAULT '0000-00-00',
			count varchar(10) DEFAULT '0' NOT NULL,
			PRIMARY KEY (id)
			) $charset;";
			$fetch = $wpdb->query($query);
		}
	}

	/**
	 * Generate UUID
	*/
	public function generate_uuid()
	{
	    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000, mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
	}
	
	/**
	 * Update `Options` on form submit
	*/
	public function return_update_options()
	{
		if((isset($_POST['edw-update-option'])) && ($_POST['edw-update-option'] === 'true')
		&& check_admin_referer('edw-referer-form', 'edw-referer-option'))
		{
			$opts = array('stats' => 'off', 'widget' => 'off');

			if(isset($_POST['_easy_download_options']['stats']))
			{
				$opts['stats'] = sanitize_text_field($_POST['_easy_download_options']['stats']);
				if($opts['stats'] !== 'on')
				{
					header('location:'.admin_url('admin.php?page=easy-download-options').'&output=error&type=stats');
					die();
				}
			}
			else
			{
				$opts['status'] = 'off';
			}

			if(isset($_POST['_easy_download_options']['widget']))
			{
				$opts['widget'] = sanitize_text_field($_POST['_easy_download_options']['widget']);
				if($opts['widget'] !== 'on')
				{
					header('location:'.admin_url('admin.php?page=easy-download-options').'&output=error&type=widget');
					die();
				}
			}
			else
			{
				$opts['widget'] = 'off';
			}

			$data = update_option('_easy_download_options', $opts);
			header('location:'.admin_url('admin.php?page=easy-download-options').'&output=updated');
			die();
		}
	}

	/**
	 * Update `Link` on form submit
	*/
	public function return_update_links()
	{
		if((isset($_POST['edw-update-links'])) && ($_POST['edw-update-links'] === 'true')
		&& check_admin_referer('edw-referer-form', 'edw-referer-links'))
		{
			if(isset($_POST['_easy_download_links']['url']))
			{
				$uuid = $this->generate_uuid();
				$load = unserialize(get_option('_easy_download_links'));
				$link = sanitize_url($_POST['_easy_download_links']['url']);

				if(wp_http_validate_url($link) === false)
				{
					header('location:'.admin_url('admin.php?page=easy-download-form').'&output=error&type=url');
					die();
				}

				$opts[$uuid] = $link;
				if(is_array($load))
				{
					foreach($load as $key => $val)
					{
						$opts[$key] = $val;
					}
				}

				$data = update_option('_easy_download_links', serialize($opts));
				header('location:'.admin_url('admin.php?page=easy-download-links').'&output=updated');
				die();
			}
		}
	}

	/**
	 * Delete `Link` on form submit
	*/
	public function return_delete_link()
	{
		if((isset($_POST['edw-delete-links'])) && ($_POST['edw-delete-links'] === 'true')
		&& check_admin_referer('edw-referer-form', 'edw-referer-delete'))
		{
			if(isset($_POST['_easy_download_links']['uuid']))
			{
				$load = unserialize(get_option('_easy_download_links'));
				$uuid = sanitize_text_field($_POST['_easy_download_links']['uuid']);

				$opts = array();
				if(is_array($load))
				{
					foreach($load as $key => $val)
					{
						if($key !== $uuid)
						{
							$opts[$key] = $val;
						}						
					}
				}

				$data = update_option('_easy_download_links', serialize($opts));
				header('location:'.admin_url('admin.php?page=easy-download-links').'&output=deleted');
				die();
			}
		}
	}

	/**
	 * Return the `Options` page
	*/
	public function return_options_page()
	{
		$opts = get_option('_easy_download_options');
		require_once plugin_dir_path(__FILE__).'partials/easy-download-admin-options.php';
	}

	/**
	 * Return the `Add Form` page
	*/
	public function return_addform_page()
	{
		require_once plugin_dir_path(__FILE__).'partials/easy-download-admin-form.php';
	}

	/**
	 * Return the `Links` page
	*/
	public function return_links_page()
	{
		global $wpdb;
		$opts = get_option('_easy_download_links');
		require_once plugin_dir_path(__FILE__).'partials/easy-download-admin-links.php';
	}

	/**
	 * Return Backend Menu
	*/
	public function return_admin_menu()
	{
		add_menu_page('Easy Download', 'Easy Download', 'administrator', 'easy-download-admin', array($this, 'return_options_page'), 'dashicons-download');
		add_submenu_page('easy-download-admin', 'Settings', 'Settings', 'administrator', 'easy-download-options', array($this, 'return_options_page'));
		add_submenu_page('easy-download-admin', 'Add Form', 'Add Form', 'administrator', 'easy-download-form', array($this, 'return_addform_page'));
		add_submenu_page('easy-download-admin', 'Links', 'Links', 'administrator', 'easy-download-links', array($this, 'return_links_page'));
		remove_submenu_page('easy-download-admin', 'easy-download-admin');
	}
}

?>