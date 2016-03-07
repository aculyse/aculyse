<?php
/**
 * Set the environment variables for the application
 * @author Blessing Mashoko <projects@bmashoko.com>
 * @copyright (c) 2016, Blessing Mashoko
 * @package Install
 * 
 */

namespace Aculyse\Install;

use Dotenv;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Exception\OperationNotPermitedException;

require_once dirname(dirname(dirname((__DIR__)))) . "/vendor/autoload.php";


const MINIMUM_PHP_VERSION="5.6.3";


class Environment extends Dotenv
{

    private static $env_file;
    private static $base_path;

    /**
     * Initialise the static variables needed by the class
     */
    private static function init()
    {
        self::$base_path = dirname(dirname(dirname(((__DIR__)))));
        self::$env_file = self::$base_path . "/config.php";
    }

    /**
     * Create the .env file to store the configuration settings
     * of the application
     * @param array $config_vars
     * @return type
     */
    public static function create(array $config_vars = [])
    {
        self::init();

        self::$env_file = self::$env_file;
        $FileSystem = new Filesystem();

        return $FileSystem->put(self::$env_file, self::parseConfigs($config_vars));

    }

    /**
     * Convert an array into code
     * @param array $config_vars
     * @return string
     */
    private function parseConfigs(array $config_vars = [])
    {

        $config_string = "<?php\n\n";
        foreach ($config_vars as $key => $value) {
            $config_string .= "define('$key','$value');\n";
        }
        return $config_string;
    }

    public static function configFileExists(){
        return (file_exists(self::env_file));
    }

    /**
     * Check if the version of PHP is minimum for the application install
     * @return type
     */
    public static function isPhpVersionOk(){
        return (phpversion()>=MINIMUM_PHP_VERSION);
    }
}
