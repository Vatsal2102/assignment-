<?php
/**
 * Twin Cities Web Application - Main Index Controller
 *
 * This script serves as the primary entry point for the Twin Cities web application,
 * responsible for coordinating the display of city information, maps, and weather data.
 *
 * @package TwinCitiesWebApp
 * @subpackage Controllers
 * @author: 
 * @version 1.0.0
 */

namespace dsa_twin_cities;

/**
 * Include Critical Application Configuration and Utility Files
 * 
 * These files provide essential configuration settings, database connections,
 * and utility functions for weather data processing.
 */
// Absolute path inclusions for configuration and utility scripts
include_once('C:\laragon\www\Twin-cities-web-app\config.php');
include_once('C:\laragon\www\Twin-cities-web-app\Main\weather.php');

/**
 * Extracts and returns structured city data from configuration
 * 
 * This function transforms raw city configuration into a standardized 
 * array with essential geographical and display information. It processes
 * predefined city configurations, extracting key details for further use.
 * 
 * @param array $cityConfig Raw configuration array for a specific city
 * @return array Structured city data containing:
 *  - 'name': City name (string)
 *  - 'country': Country name (string)
 *  - 'latitude': Geographical latitude (float)
 *  - 'longitude': Geographical longitude (float)
 *  - 'markers': Array of map markers for points of interest
 * 
 * @throws \InvalidArgumentException If required city configuration keys are missing
 */
function getCityData($cityConfig) {
    // Validate required configuration keys
    $requiredKeys = ['NAME', 'COUNTRY', 'LATITUDE', 'LONGITUDE', 'MARKERS'];
    foreach ($requiredKeys as $key) {
        if (!isset($cityConfig[$key])) {
            throw new \InvalidArgumentException("Missing required city configuration key: $key");
        }
    }

    return [
        'name' => $cityConfig['NAME'],
        'country' => $cityConfig['COUNTRY'],
        'latitude' => $cityConfig['LATITUDE'],
        'longitude' => $cityConfig['LONGITUDE'],
        'markers' => json_decode($cityConfig['MARKERS'], true)
    ];
}

/**
 * Retrieve and process city data for both cities from global configuration
 * 
 * Uses the getCityData() function to transform raw configuration into
 * structured city information for Birmingham and Frankfurt.
 */
// Retrieve structured city data from global configuration constants
$city1 = getCityData(CITY1);
$city2 = getCityData(CITY2);

/**
 * Fetches and formats comprehensive weather data for a given city
 * 
 * This function orchestrates the weather data retrieval process by:
 * 1. Fetching current weather information
 * 2. Formatting current weather data
 * 3. Fetching weather forecast
 * 4. Formatting forecast data
 * 
 * @param array $city City details array containing name and country
 * @return array Comprehensive weather data with current and forecast information
 * 
 * @uses getCurrentWeather() to retrieve raw current weather data
 * @uses formatCurrentWeather() to process current weather information
 * @uses getForecastWeather() to retrieve raw forecast data
 * @uses formatForecastWeather() to process forecast information
 * 
 * @throws \RuntimeException If weather data retrieval fails
 */
function getFormattedWeatherData($city) {
    try {
        // Fetch and format current weather data
        $currentWeather = getCurrentWeather($city['name'], $city['country']);
        $formattedCurrentWeather = formatCurrentWeather($currentWeather);

        // Fetch and format forecast weather data
        $forecastWeather = getForecastWeather($city['name'], $city['country']);
        $formattedForecastWeather = formatForecastWeather($forecastWeather);

        return [
            'current' => $formattedCurrentWeather,
            'forecast' => $formattedForecastWeather
        ];
    } catch (\Exception $e) {
        // Log error and provide fallback data or rethrow
        error_log("Weather data retrieval failed for {$city['name']}: " . $e->getMessage());
        throw new \RuntimeException("Unable to retrieve weather data", 0, $e);
    }
}

/**
 * Retrieve and process weather data for both cities
 * 
 * Uses getFormattedWeatherData() to fetch and format weather information
 * for Birmingham and Frankfurt.
 */
// Fetch comprehensive weather data for both cities
$weatherDataCity1 = getFormattedWeatherData($city1);
$weatherDataCity2 = getFormattedWeatherData($city2);

/**
 * Include HTML Template Components
 * 
 * Load essential template files that define the structure and 
 * common elements of the web application's pages.
 */
// Include head, navigation, and other template components
include_once('C:\laragon\www\Twin-cities-web-app\Templates\head.php');
include_once('C:\laragon\www\Twin-cities-web-app\Templates\nav.php');

/**
 * Displays an interactive Google Map for a specified city
 * 
 * This function prepares map data and includes the map display template,
 * which will render an interactive map with city markers using Google Maps API.
 * 
 * @param array $city Structured city data containing geographical information
 * 
 * @uses displaymap.php Template for rendering Google Maps
 */
function displayMap($city) {
    $mapData = [
        'name' => $city['name'],
        'lat' => $city['latitude'],
        'lng' => $city['longitude'],
        'markers' => $city['markers']
    ];
    include('C:\laragon\www\Twin-cities-web-app\Templates\displaymap.php');
}

/**
 * Render Maps for Both Cities
 * 
 * Calls displayMap() to generate interactive maps for Birmingham and Frankfurt
 */
// Display interactive maps for both cities
displayMap($city1);
displayMap($city2);

/**
 * Include Weather Widget Template
 * 
 * Renders a dynamic, responsive weather display for both cities
 */
// Display combined weather widget template
include('C:\laragon\www\Twin-cities-web-app\Templates\weatherwidget.php');

/**
 * Include Footer Template
 * 
 * Adds standard footer content and closes HTML document
 */
// Include footer template to complete the page
include_once('C:\laragon\www\Twin-cities-web-app\Templates\footer.php');
?>

<script>
    /**
     * Google Maps Initialization Function
     * 
     * Callback function triggered after Google Maps JavaScript API loads.
     * Initializes map instances for both cities dynamically.
     * 
     * @global
     * @function
     * @name initializeMaps
     * 
     * @description
     * This function is designed to be called by the Google Maps API after 
     * successful script loading. It triggers individual map initialization 
     * functions for each city, which are dynamically generated.
     */
    function initializeMaps() {
        // Dynamically call map initialization functions for each city
        initMap<?php echo $city1['name']; ?>();
        initMap<?php echo $city2['name']; ?>();
    }
</script>
