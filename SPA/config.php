<?php
namespace dsa_twin_cities;
@date_default_timezone_set("GMT");

// API keys
define('OpenWeatherAPI', '5650daa88753c0c07f4d5c532ee48bbd');
define('GoogleAPI', 'AIzaSyDDV8nwoJy6_mPUxZAuMjnrCGIwI6tUaBk');
define('FlickrAPI', 'f33d5ce38ae62686553faa01881b59af');

// Database connection
define('DBMS', [
    'Host' => 'localhost',
    'DB' => 'twincities',
    'User' => 'root',
    'Password' => ''
]);

// Error handling
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
});
set_exception_handler(function ($e) {
    echo "An error occurred: " . $e->getMessage();
});
register_shutdown_function(function () {
    $error = error_get_last();
    if ($error !== null) {
        echo "An error occurred: " . $error['message'];
    }
});
?>

