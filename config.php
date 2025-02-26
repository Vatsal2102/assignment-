<?php
namespace dsa_twin_cities;
@date_default_timezone_set("GMT");

// API keys
define('OPENWEATHER_API_KEY', '5650daa88753c0c07f4d5c532ee48bbd');
define('GOOGLE_API_KEY', 'AIzaSyDDV8nwoJy6_mPUxZAuMjnrCGIwI6tUaBk');
define('FLICKR_API_KEY', 'f33d5ce38ae62686553faa01881b59af');

// Database connection
define('DBMS', [
    'HOST' => 'localhost',
    'USER' => 'root',
    'PASSWORD' => '',
    'DBNAME' => 'twincities'
]);

// City1' data
define('CITY1', [
    'NAME' => 'Birmingham',
    'COUNTRY' => 'GB',
    'LATITUDE' => 52.4862,
    'LONGITUDE' => -1.8904,
    'POPULATION' => 1141816,
    'MARKERS' => json_encode([
        ['name' => 'Birmingham Museum and Art Gallery', 'lat' => 52.4796, 'lng' => -1.9036, 'icon' => './Images/museum.png', 'open' => '09:00', 'close' => '17:00'],
        ['name' => 'Bullring Shopping Centre', 'lat' => 52.4775, 'lng' => -1.8944, 'icon' => './Images/shopping.png', 'open' => '10:00', 'close' => '20:00'],
        ['name' => 'Cadbury World', 'lat' => 52.4308, 'lng' => -1.9323, 'icon' => './Images/park.png', 'open' => '10:00', 'close' => '16:00'],
        ['name' => 'Birmingham Botanical Gardens', 'lat' => 52.4557, 'lng' => -1.9149, 'icon' => './Images/garden.png', 'open' => '10:00', 'close' => '17:00'],
        ['name' => 'Library of Birmingham', 'lat' => 52.4814, 'lng' => -1.9033, 'icon' => './Images/library.png', 'open' => '09:00', 'close' => '20:00'],
        ['name' => 'Thinktank, Birmingham Science Museum', 'lat' => 52.4773, 'lng' => -1.9097, 'icon' => './Images/museum.png', 'open' => '10:00', 'close' => '17:00']
    ])
]);

// City2' data
define('CITY2', [
    'NAME' => 'Frankfurt',
    'COUNTRY' => 'DE',
    'LATITUDE' => 50.1109,
    'LONGITUDE' => 8.6821,
    'POPULATION' => 763380,
    'MARKERS' => json_encode([
        ['name' => 'Römerberg', 'lat' => 50.1109, 'lng' => 8.6821, 'icon' => './Images/shopping.png', 'open' => '09:00', 'close' => '18:00'],
        ['name' => 'Palmengarten', 'lat' => 50.1233, 'lng' => 8.6507, 'icon' => './Images/shopping.png', 'open' => '09:00', 'close' => '18:00'],
        ['name' => 'Goethe House', 'lat' => 50.1106, 'lng' => 8.6825, 'icon' => './Images/house.png', 'open' => '10:00', 'close' => '18:00'],
        ['name' => 'Main Tower', 'lat' => 50.1106, 'lng' => 8.6754, 'icon' => './Images/tower.png', 'open' => '10:00', 'close' => '21:00'],
        ['name' => 'Senckenberg Natural History Museum', 'lat' => 50.1175, 'lng' => 8.6527, 'icon' => './Images/museum.png', 'open' => '09:00', 'close' => '17:00'],
        ['name' => 'Frankfurt Zoo', 'lat' => 50.1219, 'lng' => 8.7163, 'icon' => './Images/zoo.png', 'open' => '09:00', 'close' => '18:00']
    ])
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

