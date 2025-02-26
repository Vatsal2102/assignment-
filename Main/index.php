<?php

namespace dsa_twin_cities;

include_once('C:\laragon\www\Twin-cities-web-app\config.php');
include_once('C:\laragon\www\Twin-cities-web-app\Main\weather.php');

// Function to get city data from configuration
function getCityData($cityConfig) {
    return [
        'name' => $cityConfig['NAME'],
        'country' => $cityConfig['COUNTRY'],
        'latitude' => $cityConfig['LATITUDE'],
        'longitude' => $cityConfig['LONGITUDE'],
        'markers' => json_decode($cityConfig['MARKERS'], true)
    ];
}

// Get city data
$city1 = getCityData(CITY1);
$city2 = getCityData(CITY2);

// Function to fetch and format weather data
function getFormattedWeatherData($city) {
    $currentWeather = getCurrentWeather($city['name'], $city['country']);
    $formattedCurrentWeather = formatCurrentWeather($currentWeather);

    $forecastWeather = getForecastWeather($city['name'], $city['country']);
    $formattedForecastWeather = formatForecastWeather($forecastWeather);

    return [
        'current' => $formattedCurrentWeather,
        'forecast' => $formattedForecastWeather
    ];
}

// Fetch and format weather data for both cities
$weatherDataCity1 = getFormattedWeatherData($city1);
$weatherDataCity2 = getFormattedWeatherData($city2);

// Include the templates
include_once('C:\laragon\www\Twin-cities-web-app\Templates\head.php');
include_once('C:\laragon\www\Twin-cities-web-app\Templates\nav.php');

// Function to display map
function displayMap($city) {
    $mapData = [
        'name' => $city['name'],
        'lat' => $city['latitude'],
        'lng' => $city['longitude'],
        'markers' => $city['markers']
    ];
    include('C:\laragon\www\Twin-cities-web-app\Templates\displaymap.php');
}

// Display maps for both cities
displayMap($city1);
displayMap($city2);

// Function to display weather
function displayWeather($formattedWeather) {
    include('C:\laragon\www\Twin-cities-web-app\Templates\weatherwidget.php');
}

// Display weather for both cities
displayWeather($weatherDataCity1['current']);
displayWeather($weatherDataCity2['current']);

include_once('C:\laragon\www\Twin-cities-web-app\Templates\footer.php');

?>
<script>
    // Function to initialize all maps
    function initializeMaps() {
        initMap<?php echo $city1['name']; ?>();
        initMap<?php echo $city2['name']; ?>();
    }
</script>