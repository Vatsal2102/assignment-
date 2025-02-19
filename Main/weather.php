<?php
namespace dsa_twin_cities;

include_once('C:\laragon\www\twincities\Twin-cities-web-app\config.php');

// Function to fetch current weather data using OpenWeatherAPI
function getCurrentWeather($city) {
    $apiKey = OPENWEATHER_API_KEY;
    $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}";
    $response = file_get_contents($url);
    if ($response === FALSE) {
        return null;
    }
    return json_decode($response, true);
}

// Function to fetch forecast weather data using OpenWeatherAPI
function getForecastWeather($city) {
    $apiKey = OPENWEATHER_API_KEY;
    $url = "http://api.openweathermap.org/data/2.5/forecast?q={$city}&appid={$apiKey}";
    $response = file_get_contents($url);
    if ($response === FALSE) {
        return null;
    }
    return json_decode($response, true);
}

// Function to format the data
function formatCurrentWeather($currentweatherdata) {
    if (!$currentweatherdata) {
        return "Weather data not available.";
    }
    return [
        'name' => $currentweatherdata['name'],
        'temp' => $currentweatherdata['main']['temp'] - 273.15, // Convert from Kelvin to Celsius
        'description' => $currentweatherdata['weather'][0]['description'],
        'icon' => $currentweatherdata['weather'][0]['icon'],
        'humidity' => $currentweatherdata['main']['humidity'],
        'wind' => $currentweatherdata['wind']['speed'],
        'pressure' => $currentweatherdata['main']['pressure'],
        'sunrise' => date('H:i', $currentweatherdata['sys']['sunrise']),
        'sunset' => date('H:i', $currentweatherdata['sys']['sunset']),
        'date' => date('F j, H:i:s')
    ];
}
function formatForecastWeather($forecastweatherdata) {
    if (!$forecastweatherdata) {
        return "Forecast data not available.";
    }
    $formattedData = []; // Forecast data can have multiple values
    $count = 0;
    foreach ($forecastweatherdata['list'] as $forecast) {
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
?>