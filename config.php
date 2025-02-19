<?php
namespace dsa_twin_cities;
@date_default_timezone_set("GMT");

// API keys
define('OPENWEATHER_API_KEY', 'YOUR_OPENWEATHER_API_KEY');
define('GOOGLE_API_KEY', 'YOUR_GOOGLE_API_KEY');
define('FLICKR_API_KEY', 'YOUR_FLICKR_API_KEY');

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
