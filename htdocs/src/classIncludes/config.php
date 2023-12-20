<?php

// Global variable to store database credentials
global $__config_details;

/*
Store the 'config.json' outside the document root for security purposes.
*/
$__site_config_path = $_SERVER['DOCUMENT_ROOT'] .'/../project/pixletconf.json';

echo $__site_config_path;
// Read the content of the configuration file
$__config_details = file_get_contents($__site_config_path);

function get_config($key, $default = null)
{
    global $__config_details;
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