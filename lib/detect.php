<?php

/**
 * Detect 
 *
 * This class is a system feature detection helper
 * to check for installed packages and software
 * 
 * @package   Kirby Toolkit 
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      http://getkirby.com
 * @copyright Bastian Allgeier
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Detect {

  /**
   * Checks if the mb string extension is installed
   * 
   * @return boolean
   */
  static public function mbstring() { 
    return function_exists('mb_split');
  }

  /**
   * Checks if the required php version is installed
   * 
   * @param mixed $min
   * @return boolean
   */
  static public function php($min = '5.3') {
    return version_compare(PHP_VERSION, $min, '>=');
  }

  /**
   * Checks if PHP is running on Apache
   * 
   * @return boolean
   */
  static public function apache() {
    return apache_get_version() ? true : false;
  }

  /**
   * Checks if the site is running on Windows
   * 
   * @return boolean
   */
  static public function windows() {
    return DS == '/' ? false : true;
  }

  /**
   * Checks if the site is running on IIS
   * 
   * @return boolean
   */
  static public function iis() {
    return isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'],'IIS') !== false ? true : false;  
  }    

  /**
   * Checks if mysql installed with the minimum required version
   * 
   * @param mixed $min
   * @return boolean
   */
  static public function mysql($min = '5') {
    $extensions = get_loaded_extensions();
    if(!in_array('mysql', $extensions)) return false;      
    $version = preg_replace('#(^\D*)([0-9.]+).*$#', '\2', mysql_get_client_info());
    return version_compare($version, $min, '>=');  
  }
  
  /**
   * Checks if SQLite 3 is installed
   * 
   * @return boolean
   */
  static public function sqlite() {
    return in_array('sqlite3', get_loaded_extensions());                          
  }

  /**
   * Checks if safe mode is enabled
   * 
   * @return boolean
   */
  static public function safemode() {
    return ini_get('safe_mode');
  }
  
  /**
   * Checks if gdlib is installed
   * 
   * @return boolean
   */
  static public function gdlib() {
    return function_exists('gd_info');
  }

  /**
   * Checks if imageick is installed
   * 
   * @return boolean
   */
  static public function imagick() {
    return class_exists('Imagick');    
  }

  /**
   * Checks if CURL is installed
   * 
   * @return boolean
   */
  static public function curl() {
    return in_array('curl', get_loaded_extensions());                          
  }  

  /**
   * Check if APC cache is installed
   * 
   * @return boolean
   */
  static public function apc() {
    return function_exists('apc_add');
  }

  /**
   * Check if the Memcache extension is installed
   * 
   * @return boolean
   */
  static public function memcache() {
    return class_exists('Memcache');
  }

  /**
   * Check if the Memcached extension is installed
   * 
   * @return boolean
   */
  static public function memcached() {
    return class_exists('Memcached');
  }

  /**
   * Check if the imap extension is installed
   * 
   * @return boolean
   */
  static public function imap() {
    return function_exists('imap_body');
  }

  /**
   * Check if the mcrypt extension is installed
   * 
   * @return boolean
   */
  static public function mcrypt() {
    return function_exists('mcrypt_encrypt');
  }

  /**
   * Check if the exif extension is installed
   * 
   * @return boolean
   */
  static public function exif() {
    return function_exists('read_exif_data');
  }

  /**
   * Detect if the script is installed in a subfolder
   * 
   * @return string
   */
  static public function subfolder() {
    return trim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
  }

  /**
   * Detects the current path 
   * 
   * @return string
   */
  static public function path() {
    $uri    = explode('/', url::path());
    $script = explode('/', trim($_SERVER['SCRIPT_NAME'], '/\\'));    
    $parts  = array_diff_assoc($uri, $script);
    if(empty($parts)) return false;
    return implode('/', $parts);
  }

  /**
   * Detect the document root
   * 
   * @return string
   */
  static public function documentRoot() {    
    $local    = $_SERVER['SCRIPT_NAME'];
    $absolute = $_SERVER['SCRIPT_FILENAME'];
    return substr($absolute, 0, strpos($absolute, $local));     
  }

  /**
   * Returns the max accepted upload size
   * defined in the php.ini
   *
   * @return int
   */
  static public function maxUploadSize() {

    $size = ini_get('post_max_size');
    $size = trim($size);
    $last = strtolower($size[strlen($size)-1]);
    switch($last) {
      case 'g':
        $size *= 1024;
      case 'm':
        $size *= 1024;
      case 'k':
        $size *= 1024;
    }
    return $size;    

  }

  /**
   * Dirty browser sniffing for an ios device
   * 
   * @return boolean
   */
  static public function ios() {
    $ua = visitor::ua();
    return (str::contains($ua, 'iPod') || str::contains($ua, 'iPhone') || str::contains($ua, 'iPad'));
  }
  
}