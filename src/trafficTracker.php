<?php

  /**
   * Tracker
   *
   * This class does all the magic
   *
   * @category Components
   * @package  Php-Traffic-Tracker
   * @author   Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link     https://github.com/soringabriel/php-traffic-tracker
   * @since    1.0.0
   */

require 'database.php';

  /**
   * Tracker
   *
   * This class does all the magic
   *
   * @category Components
   * @package  Php-Traffic-Tracker
   * @author   Marica Sorin-Gabriel <sorinmarica4@gmail.com>
   * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
   * @link     https://github.com/soringabriel/php-traffic-tracker
   * @since    1.0.0
   */
class TrafficTracker
{

    private $_currentUrl;
    public $succes;
    public $error;

    /**
     * Constructor
     *
     * @return type
     */
    public function __construct()
    {
        $this->_currentUrl = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $this->_memorizeIp();
        if (isset($_SERVER['HTTP_REFERER'])) {
            if (strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']) !== false) {
                $this->succes = $this->_registerInternalLink();
            } else {
                $this->succes = $this->_registerExternalLink();
            }
        }
    }

    /**
     * Sets the IP in a cookie. This is needed for users with dinamic IP.
     *
     * @return bool
     */
    private function _memorizeIp()
    {
        if (!isset($_COOKIE['php-tracker-ip'])) {
            setCookie(
                'php-tracker-ip', 
                $_SERVER['REMOTE_ADDR'], 
                3600 * 24 * 1000, 
                '/'
            );
        }
    }
    /**
     * Retrieves an array with the internal links
     *
     * @return array
     */
    public function getInternalLinks()
    {   
        $sql = $GLOBALS['connection']->query("SELECT * FROM internal_links");
        $result = $sql->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    /**
     * Retrieves an array with the external links
     *
     * @return array
     */
    public function getExternalLinks()
    {
        $sql = $GLOBALS['connection']->query("SELECT * FROM external_links");
        $result = $sql->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    /**
     * Adds records in the internal links table from the database
     *
     * @return bool
     */
    private function _registerInternalLink()
    {
        if (isset($_COOKIE['php-tracker-ip'])) {
            $sql = $GLOBALS['connection']->prepare(
                "INSERT INTO internal_links (`from`, `to`, `ip`)
                VALUES (?, ?, ?)"
            );
            $sql->bind_param(
                'sss', 
                $_SERVER['HTTP_REFERER'], 
                $this->_currentUrl, 
                $_COOKIE['php-tracker-ip']
            );
            if ($sql->execute()) {
                return true;
            } else {
                $this->error = $sql->error;
                return false;
            }
        } else {
            $this->error = 'Failed to track the IP';
            $this->succes = false;
            return false;
        }
    }

    /**
     * Adds records in the internal links table from the database
     *
     * @return bool
     */
    private function _registerExternalLink()
    {
        if (iseet($_COOKIE['php-tracker-ip'])) {
            $sql = $GLOBALS['connection']->prepare(
                "INSERT INTO external (`from`, `to`, `ip`)
                VALUES (?, ?, ?)"
            );
            $sql->bind_param(
                'sss', 
                $_SERVER['HTTP_REFERER'], 
                $this->_currentUrl, 
                $_COOKIE['php-tracker-ip']
            );
            if ($sql->execute()) {
                return true;
            } else {
                $this->error = $sql->error;
                return false;
            }
        } else {
            $this->error = 'Failed to track the IP';
            $this->succes = false;
            return false;
        }
    }

}