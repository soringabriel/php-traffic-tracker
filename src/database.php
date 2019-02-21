<?php

  /**
   * Database connection
   *
   * This class is meant to create and return a MySQLI connection
   *
   * @category Components
   * @package  PHP-Traffic-Tracker
   * @author   Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link     [url]
   * @since    1.0.0
   */

define('DB_HOST', 'localhost');
define('DB_USER', 'ebicla');
define('DB_PASS', '1a2b3c');
define('DB_NAME', 'test');

$GLOBALS['connection'] = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($GLOBALS['connection']->connect_errno) {
    echo 'Error: ' . $GLOBALS['connection']->connect_error;
}