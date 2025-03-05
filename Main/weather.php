<?php

/**
 * Processes and formats weather data for current conditions and forecast.
 *
 * This script provides two primary functions:
 * 1. formatCurrentWeather(): Transforms raw current weather data into a structured format
 * 2. formatForecastWeather(): Processes forecast data, limiting entries to prevent data overload
 *
 * Key transformations include:
 * - Temperature conversion from Kelvin to Celsius
 * - Extracting relevant weather attributes
 * - Limiting forecast entries
 *
 * @file weather.php
 * @package WeatherAPI
 * @subpackage WeatherProcessing
 *
 * @uses OpenWeatherMap External weather data API
 *
 * @return array Formatted weather data for current conditions and forecast
 *
 * @throws DataProcessingException If weather data cannot be processed
 *
 * @version 1.0.0
 */

// Weather utility functions for fetching and processing weather data from OpenWeatherMap API
namespace dsa_twin_cities;

include_once('C:\laragon\www\Twin-cities-web-app\config.php');

/**
 * Fetches current weather data for a given city using OpenWeatherMap API
 * 
 * @param string $city City name to retrieve weather for
 * @return array|null Parsed JSON weather data or null if request fails
 */
function getCurrentWeather($city)
{
    $apiKey = OPENWEATHER_API_KEY;
    $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}";
    $response = file_get_contents($url);
    if ($response === FALSE) {
        return null;
    }
    return json_decode($response, true);
}

/**
 * Retrieves weather forecast data for a given city using OpenWeatherMap API
 * 
 * @param string $city City name to retrieve forecast for
 * @return array|null Parsed JSON forecast data or null if request fails
 */
function getForecastWeather($city)
{
    $apiKey = OPENWEATHER_API_KEY;
    $url = "http://api.openweathermap.org/data/2.5/forecast?q={$city}&appid={$apiKey}";
    $response = file_get_contents($url);
    if ($response === FALSE) {
        return null;
    }
    return json_decode($response, true);
}

// Convert timestamps to correct timezone
// Perform temperature conversion from Kelvin to Celsius
function formatCurrentWeather($currentWeatherData)
{
    if (!$currentWeatherData) {
        return "Weather data not available.";
    }

    // Get timezone offset (in seconds) from API response
    $timezoneOffset = $currentWeatherData['timezone'];

    // Convert timestamps to the correct timezone
    $sunrise = gmdate('H:i', $currentWeatherData['sys']['sunrise'] + $timezoneOffset);
    $sunset = gmdate('H:i', $currentWeatherData['sys']['sunset'] + $timezoneOffset);
    $date = gmdate('F j, H:i:s', $currentWeatherData['dt'] + $timezoneOffset);

    return [
        'name' => $currentWeatherData['name'],
        'temp' => $currentWeatherData['main']['temp'] - 273.15, // Convert from Kelvin to Celsius
        'description' => $currentWeatherData['weather'][0]['description'],
        'icon' => $currentWeatherData['weather'][0]['icon'],
        'humidity' => $currentWeatherData['main']['humidity'],
        'wind' => $currentWeatherData['wind']['speed'],
        'pressure' => $currentWeatherData['main']['pressure'],
        'sunrise' => $sunrise,
        'sunset' => $sunset,
        'date' => $date,
        'feels_like' => $currentWeatherData['main']['feels_like'] - 273.15 // Convert from Kelvin to Celsius
    ];
}

// Limit forecast to 20 entries to prevent overwhelming data
// Convert temperatures and format forecast data
function formatForecastWeather($forecastWeatherData)
{
    if (!$forecastWeatherData) {
        return "Forecast data not available.";
    }

    $formattedData = [];
    $count = 0;

    foreach ($forecastWeatherData['list'] as $forecast) {
        if ($count >= 20) { // Limit to 20 forecasts
            break;
        }

        $formattedData[] = [
            'date' => date('F j, H:i:s', $forecast['dt']),
            'temp' => $forecast['main']['temp'] - 273.15, // Convert from Kelvin to Celsius
            'description' => $forecast['weather'][0]['description'],
            'icon' => $forecast['weather'][0]['icon'],
            'humidity' => $forecast['main']['humidity'],
            'wind' => $forecast['wind']['speed'],
            'pressure' => $forecast['main']['pressure']
        ];

        $count++;
    }

    return $formattedData;
}
