<?php
/*
Plugin Name: Move Site Files
Plugin URI: http://www.synology.com/
Description: You can change your site URL in general settings, and it will take effect immediately without manually changing the folder name of WordPress site. 
Version: 1.1
Author: Synology Inc.
Author URI: http://www.synology.com
*/

if (! defined("WP_SITEURL") || !strstr(WP_SITEURL, '/wordpress')) {
  die;  // Silence is golden, direct call is prohibited
}

define('DIRECTORY_SEPARATOR','/');

$GLOBALS['move-site-files'] = new move_site_files();
class move_site_files {
	var $root_dir = '/var/services/web';
	var $arr_invalid = array('/[\:\\\?\|\*<>]/','/^\.\//', '/\.\.\//','/^._/');
	function move_site_files() {
		//Set the directory
		$this->basename = plugin_basename(__FILE__);
		$this->folder = dirname($this->basename);

		//Register general hooks.
		add_action('admin_init', array(&$this, 'admin_init'));
		register_activation_hook(__FILE__, array(&$this, 'activate'));
		register_deactivation_hook(__FILE__, array(&$this, 'deactivate'));
	}

	function activate() {
		global $wp_version;
		if ( ! version_compare( $wp_version, '3.0', '>=') ) {
			if ( function_exists('deactivate_plugins') )
				deactivate_plugins(__FILE__);
			die(__('<strong>Move Site Files:</strong> Sorry, This plugin requires WordPress 3.0+'));
		}

		//check if index.php  exist in site url
		$siteDomain = substr(get_option('siteurl'), 0, -9);
		$folderName = substr(get_option('home'), strlen($siteDomain));

		$sitePath = $this->root_dir . "/wordpress";
		$homePath = $this->root_dir . "/" . $folderName;

		if (file_exists($homePath."/index.php")) {
			rename($homePath."/index.php", $homePath."/index.php." . date("Y.m.d.H.i.s"));
		}

		if (!$this->isFolderNameValid($folderName) || !$this->make_path($homePath)) {
			if ( function_exists('deactivate_plugins') )
				deactivate_plugins(__FILE__);
			die(__('A valid URL was not provided.'));
		}

		if (null == $fp = fopen($homePath."/index.php", 'w')) {
			if ( function_exists('deactivate_plugins') )
				deactivate_plugins(__FILE__);
			die(__('A valid URL was not provided.'));
		}

		fwrite($fp, "<?php \ndefine('WP_USE_THEMES', true);\nrequire('/var/services/web/wordpress/wp-blog-header.php');\n?>");
		fclose($fp);

		if ("wordpress" != $folderName) {
			$fp = fopen($this->root_dir . '/wordpress/index.php', 'w');
			$content = file_get_contents(dirname(__FILE__) . '/index.tpl');
			fwrite($fp, $content);
			fclose($fp);
		}

	}

	function deactivate() {
	}

	function isFolderNameValid($name) {
		if ('' == $name) {
			return true;
		}
		
		if (strstr(strtolower($name), "@eadir")) {
			return false;
		}

		if ("." == $name) {
			return false;
		}

		if (".." == $name) {
			return false;
		}

		if ("photo" == $name) {
			return false;
		}

		if ("blog" == $name) {
			return false;
		}

		if ("mail" == $name){
			return false;
		}

		foreach ($this->arr_invalid as $pattern) {
			if (0 != preg_match($pattern, $name, $match)) {
				return false;
			}
		}

		return true;

	}
	function removeFolder($folder) {
		$result = true;
		if (!$dir_handle = opendir($folder)){
			return false;
		}

		while ($file = readdir($dir_handle)) {
			if ("." == $file|| ".." == $file ) {continue;}
			if (is_dir($folder ."/" . $file)) {
				$result = $this->removeFolder($folder ."/" . $file);				
			} else {
				$result = unlink($folder ."/" . $file);
			}
			if (!$reslut) {break;}
		}
		if ($result) {
			rmdir($folder);
		}
		return $result;
	}

	function move_files($whitelist_options) {
		$move_files = array('index.php', '.htaccess');

		if (!in_array('home', $whitelist_options['general']) || !isSet($_POST['home']) || !strcmp(get_option('home'), $_POST['home'])) {
			return $whitelist_options;
		}

		$siteDomain = substr(get_option('siteurl'), 0, -9);
		if (!strstr($_POST['home'], $siteDomain) && !strstr($siteDomain, $_POST['home'])) {
			unset($_POST['home']);
			return $whitelist_options;
		}

		$folderName = substr($_POST['home'], strlen($siteDomain));
		if (!$this->isFolderNameValid($folderName) || !$this->make_path($this->root_dir . "/" . $folderName)) {
			add_settings_error('home', 'invalid_home', __('A valid URL was not provided.'));
			$whitelist_options['general'] = array_diff($whitelist_options['general'], array('home'));
			return $whitelist_options;
		}
		
		$orig_folderName = substr(get_option('home'), strlen($siteDomain)); 

		foreach ($move_files as $filename) {

			$old_file = $this->root_dir . "/" . $orig_folderName ."/" . $filename;  
			$new_file = $this->root_dir . "/" . $folderName ."/" . $filename;  

			if ('.htaccess' == $filename && !file_exists($old_file)) {
				continue;
			}

			if (file_exists($new_file)) {
				rename($new_file, $new_file . "." . date("Y.m.d.H.i.s"));
			}
			if (!file_exists($old_file) || !file_exists($this->root_dir . "/" . $folderName) || !rename($old_file, $new_file) ) {
				$this->removeFolder($this->root_dir . "/" . $folderName);
				$whitelist_options['general'] = array_diff($whitelist_options['general'], array('home'));
				add_settings_error('home', 'invalid_home', __('Could not create directory.'));
				return $whitelist_options;
			}
		}

		if ('' == $orig_folderName) {
			foreach ($move_files as $filename) {
				if (file_exists($this->root_dir . "/" .$filename) && !is_dir($this->root_dir . "/" . $filename)) {
                   	unlink($this->root_dir . "/" . $filename);
				}
			}
			return $whitelist_options;
		}

		if (strstr(get_option('siteurl'), get_option('home'))) {
			$fp = fopen($this->root_dir . '/wordpress/index.php', 'w');
			$content = file_get_contents(dirname(__FILE__) . '/index.tpl');
			fwrite($fp, $content);
			fclose($fp);
		} else {
			$this->removeFolder($this->root_dir . "/" . $orig_folderName);
		}

		return $whitelist_options;
	}

	function show($content){
		$fp = fopen('/tmp/log', 'a');
		fwrite($fp, json_encode($content));
		fclose($fp);
	}

	function admin_init() {
		add_filter('whitelist_options', array(&$this, 'move_files'), 10, 3);
	}

	function make_path($pathname, $mode=0755, $is_filename=false){
		if($is_filename){
			$pathname = substr($pathname, 0, strrpos($pathname, '/'));
		}

		if (is_dir($pathname) || empty($pathname)) {
			return true;
		}

		$pathname = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $pathname);
		if (is_file($pathname)) {
			trigger_error('mkdirr() File exists', E_USER_WARNING);
			return false;
		}

		$next_pathname = substr($pathname, 0, strrpos($pathname, DIRECTORY_SEPARATOR));
		if ($this->make_path($next_pathname, $mode)) {
			if (!file_exists($pathname)) {
				return mkdir($pathname, $mode);
			}
		}
		return false;
	}

}//end class
?>
