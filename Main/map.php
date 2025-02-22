<?php
namespace dsa_twin_cities;

include_once('C:\laragon\www\Twin-cities-web-app\config.php');

// Function to fetch map data using GoogleAPI
function getMapData($latitude, $longitude) {
    $apiKey = GOOGLE_API_KEY;
    $url = "https://maps.googleapis.com/maps/api/staticmap?center={$latitude},{$longitude}&zoom=12&size=600x300&key={$apiKey}";
    return $url;
}   



?>