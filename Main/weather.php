<?php

namespace dsa_twin_cities;

include_once('C:\laragon\www\Twin-cities-web-app\config.php');

// Function to fetch current weather data using OpenWeatherAPI
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

// Function to fetch forecast weather data using OpenWeatherAPI
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

// Function to format the current weather data
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

// Function to format the forecast weather data
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
