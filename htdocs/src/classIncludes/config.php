<?php

// Global variable to store database credentials
global $__config_details;

/* 
Store the 'config.json' outside the document root for security purposes.
*/
$__site_config_path = $_SERVER['DOCUMENT_ROOT'] . '../project/config.json';

// Read the content of the configuration file
$__config_details = file_get_contents($__site_config_path);

/**
 * Get a configuration value based on the provided key.
 *
 * @param string $key The key for the configuration value.
 * @param mixed $default The default value to return if the key is not found (default is null).
 *
 * @return mixed The database credentials value or the default value if the key is not found.
 */

 function get_config($key, $default = null)
{   global $__config_details;
    // credentials details check != true
    if ($__config_details === false) {
        // Handle the error, such as logging or throwing an exception
        return $default;
    }

    // Decode the JSON configuration
    $array = json_decode($__config_details, true);

    // Check if the key exists in the configuration
    if (isset($array[$key])) {
        // Return the credentials value for the specified key
        return $array[$key];
    } else {
        // Return the default value if the key is not found
        return $default;
    }
}
?>
