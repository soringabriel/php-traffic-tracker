<?php 

  /**
   * Setup
   *
   * This is just the basic setup of the library
   *
   * @category Components
   * @package  PHP-Traffic-Tracker
   * @author   Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link     https://github.com/soringabriel/php-traffic-tracker
   * @since    1.0.0
   */

require 'src/database.php';

/**
 * Checks if a table exists
 *
 * @param string $table The table for whom we check the existence
 *
 * @return boolean
 */
function checkIfTableExists($table)
{
    $sql = $GLOBALS['connection']->query('SELECT COUNT(*) FROM ' . $table);
    return !is_bool($sql);
}

$setup_state = 2;
if (!checkIfTableExists('internal_links')) {
    $sql = $GLOBALS['connection']->query(
        'CREATE TABLE internal_links (
            `id` int(6) AUTO_INCREMENT PRIMARY KEY,
            `from` VARCHAR(100),
            `to` VARCHAR(100),
            `ip` VARCHAR(20),
            `date` TIMESTAMP
        )'
    );
    if (!$sql) {
        echo 'Error creating table internal_links: ' . $GLOBALS['connection']->error;
        $setup_state = 0;
    }
} else {
    $setup_state = 1;
}

if (!checkIfTableExists('external_links')) {
    $sql = $GLOBALS['connection']->query(
        'CREATE TABLE external_links (
            `id` int(6) AUTO_INCREMENT PRIMARY KEY,
            `from` VARCHAR(100),
            `to` VARCHAR(100),
            `ip` VARCHAR(20),
            `type` VARCHAR(10),
            `date` TIMESTAMP
        )'
    );
    if (!$sql) {
        echo 'Error creating table external_links: ' . $GLOBALS['connection']->error;
        $setup_state = 0;
    }
} else {
    $setup_state = 1;
}

if ($setup_state == 2) {
    echo 'Setup was completed succesfully';
} else if ($setup_state == 1) {
    echo 'The php-traffic-tracker is already installed';
} else {
    echo 'Setup failed';
}