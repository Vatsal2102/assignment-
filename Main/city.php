<?php

/**
 * City Comparison and Information Rendering Script
 *
 * This script handles the dynamic rendering of a twin cities comparison page,
 * performing several critical functions:
 * - Validates and processes city parameter from URL
 * - Retrieves city-specific configuration data
 * - Fetches and formats current and forecast weather data
 * - Generates interactive map with city markers
 * - Renders weather widget and page templates
 *
 * The script supports a predefined set of twin cities, swapping their order
 * based on the selected city parameter to maintain consistent comparative display.
 *
 * @file city.php
 * @package TwinCitiesWebApp
 * @subpackage CityComparison
 *
 * @namespace dsa_twin_cities
 *
 * @uses config.php For city configuration constants
 * @uses weather.php For weather data retrieval and formatting
 * @uses head.php Renders page head section
 * @uses nav.php Renders navigation
 * @uses displaymap.php Generates interactive city map
 * @uses weatherwidget.php Displays combined weather information
 * @uses footer.php Renders page footer
 *
 * @method getFormattedWeatherData() Retrieves and formats weather data for a city
 * @method displayMap() Renders interactive map for a given city
 *
 * @param string $_GET['city'] URL parameter specifying the primary city
 *
 * @return void Renders the complete twin cities comparison page
 *
 * @throws HeaderException If invalid city is provided (redirects to 404.php)
 *
 * @version 1.0.0
 * @author: 
 *
 * @see config.php
 * @see weather.php
 */

namespace dsa_twin_cities;

include_once('C:\laragon\www\Twin-cities-web-app\config.php');
include_once('C:\laragon\www\Twin-cities-web-app\Main\weather.php');

// Validate and sanitize city parameter
// Ensure only predefined cities are allowed
// Redirect to 404 if city is invalid
if (isset($_GET['city'])) {
    $cityName = $_GET['city'];

    if ($cityName == CITY1['NAME']) {
        $city1 = [
            'name' => CITY1['NAME'],
            'country' => CITY1['COUNTRY'],
            'latitude' => CITY1['LATITUDE'],
            'longitude' => CITY1['LONGITUDE'],
            'markers' => json_decode(CITY1['MARKERS'], true)
        ];

        $city2 = [
            'name' => CITY2['NAME'],
            'country' => CITY2['COUNTRY'],
            'latitude' => CITY2['LATITUDE'],
            'longitude' => CITY2['LONGITUDE'],
            'markers' => json_decode(CITY2['MARKERS'], true)
        ];
    } elseif ($cityName == CITY2['NAME']) {
        $city1 = [
            'name' => CITY2['NAME'],
            'country' => CITY2['COUNTRY'],
            'latitude' => CITY2['LATITUDE'],
            'longitude' => CITY2['LONGITUDE'],
            'markers' => json_decode(CITY2['MARKERS'], true)
        ];

        $city2 = [
            'name' => CITY1['NAME'],
            'country' => CITY1['COUNTRY'],
            'latitude' => CITY1['LATITUDE'],
            'longitude' => CITY1['LONGITUDE'],
            'markers' => json_decode(CITY1['MARKERS'], true)
        ];
    } else {
        header("Location: 404.php");
        die();
    }

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

    include_once('C:\laragon\www\Twin-cities-web-app\Templates\head.php');
    include_once('C:\laragon\www\Twin-cities-web-app\Templates\nav.php');

    function displayMap($city) {
        $mapData = [
            'name' => $city['name'],
            'lat' => $city['latitude'],
            'lng' => $city['longitude'],
            'markers' => $city['markers']
        ];
        include('C:\laragon\www\Twin-cities-web-app\Templates\displaymap.php');
    }

    // Display map only for the selected city
    displayMap($city1);

    // Display combined weather widget
    include('C:\laragon\www\Twin-cities-web-app\Templates\weatherwidget.php');

    include_once('C:\laragon\www\Twin-cities-web-app\Templates\footer.php');

    ?>
    <script>
        function initializeMaps() {
            initMap<?php echo $city1['name']; ?>();
        }
    </script>
    <?php
} else {
    header("Location: 404.php");
    die();
}
?>

