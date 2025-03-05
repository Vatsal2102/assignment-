<?php
/**
 * Weather Widget Script for Twin Cities Web Application
 *
 * This script generates a responsive weather widget for two cities, 
 * dynamically styling the display based on current weather conditions 
 * and time of day.
 *
 * @package TwinCitiesWeather
 * @subpackage WeatherWidget
 * @author: 
 * @version 1.0.0
 */

/**
 * Determines the appropriate weather condition based on the current weather data
 *
 * This function analyzes the weather data to return a standardized 
 * weather condition string used for styling and icon selection. It considers:
 * - Main weather type (clear, clouds, rain, etc.)
 * - Time of day (day or night for clear conditions)
 *
 * @param array $formattedWeather Associative array containing current weather information
 * @return string Standardized weather condition (clear-day, clear-night, clouds, rain, snow)
 */
function getWeatherCondition($formattedWeather) {
    // Default to clear day if no weather data is provided
    $weatherCondition = 'clear-day';

    // Check if weather main type is available
    if (isset($formattedWeather['weather_main'])) {
        $weatherMain = strtolower($formattedWeather['weather_main']);

        // Determine weather condition based on main weather type
        if ($weatherMain == 'clear') {
            // Check if it's day or night based on current time vs sunrise/sunset
            $currentTime = strtotime($formattedWeather['date']);
            $sunriseTime = strtotime($formattedWeather['sunrise']);
            $sunsetTime = isset($formattedWeather['sunset']) ? strtotime($formattedWeather['sunset']) : null;

            // Set condition based on time relative to sunrise and sunset
            if ($currentTime < $sunriseTime || ($sunsetTime !== null && $currentTime > $sunsetTime)) {
                $weatherCondition = 'clear-night';
            } else {
                $weatherCondition = 'clear-day';
            }
        } elseif ($weatherMain == 'clouds' || $weatherMain == 'mist' || $weatherMain == 'fog') {
            $weatherCondition = 'clouds';
        } elseif ($weatherMain == 'rain' || $weatherMain == 'drizzle' || $weatherMain == 'thunderstorm') {
            $weatherCondition = 'rain';
        } elseif ($weatherMain == 'snow') {
            $weatherCondition = 'snow';
        }
    }
    return $weatherCondition;
}

// Retrieve and process weather conditions for both cities
/**
 * Determine weather display parameters for each city
 * 
 * This section prepares weather-related display attributes for 
 * each city, including weather condition, time of day, and 
 * additional weather details.
 */
// Weather condition for first city
$weatherCondition1 = getWeatherCondition($weatherDataCity1['current']);

// Weather condition for second city
$weatherCondition2 = getWeatherCondition($weatherDataCity2['current']);

/**
 * Determine daytime status for each city
 * 
 * Calculates whether it's currently daytime or nighttime based 
 * on current time, sunrise, and sunset times.
 */
// Daytime calculation for first city
$currentTime1 = strtotime($weatherDataCity1['current']['date']);
$sunriseTime1 = strtotime($weatherDataCity1['current']['sunrise']);
$sunsetTime1 = isset($weatherDataCity1['current']['sunset']) ? strtotime($weatherDataCity1['current']['sunset']) : null;
$isDaytime1 = ($currentTime1 >= $sunriseTime1 && ($sunsetTime1 === null || $currentTime1 <= $sunsetTime1));

// Daytime calculation for second city
$currentTime2 = strtotime($weatherDataCity2['current']['date']);
$sunriseTime2 = strtotime($weatherDataCity2['current']['sunrise']);
$sunsetTime2 = isset($weatherDataCity2['current']['sunset']) ? strtotime($weatherDataCity2['current']['sunset']) : null;
$isDaytime2 = ($currentTime2 >= $sunriseTime2 && ($sunsetTime2 === null || $currentTime2 <= $sunsetTime2));

/**
 * Prepare precipitation data with fallback to 0 if not available
 * 
 * Ensures a default value of 0 is used if precipitation data 
 * is missing from the weather information.
 */
$precipitation1 = isset($weatherDataCity1['current']['precipitation']) ? $weatherDataCity1['current']['precipitation'] : '0';
$precipitation2 = isset($weatherDataCity2['current']['precipitation']) ? $weatherDataCity2['current']['precipitation'] : '0';

/**
 * Format weather descriptions with proper capitalization
 * 
 * Ensures the first letter of the weather description is capitalized 
 * for consistent display.
 */
$weatherDesc1 = ucfirst($weatherDataCity1['current']['description']);
$weatherDesc2 = ucfirst($weatherDataCity2['current']['description']);
?>

<!-- 
Weather Widget HTML Template 

This template creates a responsive, dynamically styled weather 
widget for two cities, with detailed weather information and 
weather-condition-based visual styling.
-->
<div class="combined-weather-container">
    <div class="row">
        <!-- First City Weather Column -->
        <div class="col-md-6 city-column" data-weather="<?php echo $weatherCondition1; ?>" data-time="<?php echo $isDaytime1 ? 'day' : 'night'; ?>">
            <div class="weather-bg-overlay"></div>
            <div class="city-content">
                <!-- City Header with Name and Current Time -->
                <div class="city-header">
                    <h1 class="city-name"><?php echo $weatherDataCity1['current']['name']; ?></h1>
                    <div class="current-time"><?php echo date('H:i', strtotime($weatherDataCity1['current']['date'])); ?></div>
                </div>

                <!-- Main Weather Information -->
                <div class="weather-main-info">
                    <div class="temperature">
                        <span class="temp-value"><?php echo round($weatherDataCity1['current']['temp']); ?></span>
                        <span class="temp-unit">°</span>
                    </div>
                    <div class="feels-like">Feels Like <?php echo round($weatherDataCity1['current']['feels_like']); ?>°</div>
                </div>

                <!-- Weather Description -->
                <div class="weather-description"><?php echo $weatherDesc1; ?></div>

                <!-- Detailed Weather Information -->
                <div class="weather-details">
                    <div class="detail-item">
                        <span class="detail-label">Precip:</span>
                        <span class="detail-value"><?php echo $precipitation1; ?>%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Humidity:</span>
                        <span class="detail-value"><?php echo $weatherDataCity1['current']['humidity']; ?>%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Wind:</span>
                        <span class="detail-value"><?php echo $weatherDataCity1['current']['wind']; ?> km/h</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Sunrise:</span>
                        <span class="detail-value"><?php echo $weatherDataCity1['current']['sunrise']; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second City Weather Column -->
        <div class="col-md-6 city-column" data-weather="<?php echo $weatherCondition2; ?>" data-time="<?php echo $isDaytime2 ? 'day' : 'night'; ?>">
            <div class="weather-bg-overlay"></div>
            <div class="city-content">
                <!-- City Header with Name and Current Time -->
                <div class="city-header">
                    <h1 class="city-name"><?php echo $weatherDataCity2['current']['name']; ?></h1>
                    <div class="current-time"><?php echo date('H:i', strtotime($weatherDataCity2['current']['date'])); ?></div>
                </div>

                <!-- Main Weather Information -->
                <div class="weather-main-info">
                    <div class="temperature">
                        <span class="temp-value"><?php echo round($weatherDataCity2['current']['temp']); ?></span>
                        <span class="temp-unit">°</span>
                    </div>
                    <div class="feels-like">Feels Like <?php echo round($weatherDataCity2['current']['feels_like']); ?>°</div>
                </div>

                <!-- Weather Description -->
                <div class="weather-description"><?php echo $weatherDesc2; ?></div>

                <!-- Detailed Weather Information -->
                <div class="weather-details">
                    <div class="detail-item">
                        <span class="detail-label">Precip:</span>
                        <span class="detail-value"><?php echo $precipitation2; ?>%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Humidity:</span>
                        <span class="detail-value"><?php echo $weatherDataCity2['current']['humidity']; ?>%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Wind:</span>
                        <span class="detail-value"><?php echo $weatherDataCity2['current']['wind']; ?> km/h</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Sunrise:</span>
                        <span class="detail-value"><?php echo $weatherDataCity2['current']['sunrise']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 
CSS Styling for Weather Widget 

Provides responsive and dynamic styling based on weather conditions 
and time of day, with mobile-friendly design and interactive elements.
-->

<style>
/* Main container for the combined weather widget */
.combined-weather-container {
    width: 100%;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    margin-bottom: 2rem;
    color: white;
}

/* City column styling */
.city-column {
    position: relative;
    min-height: 400px;
    padding: 2rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

/* Background overlay for weather conditions */
.weather-bg-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    background-size: cover;
    background-position: center;
    transition: background 0.5s ease;
}

/* Default background colors based on time of day */
.city-column[data-time="day"] .weather-bg-overlay {
    background: linear-gradient(180deg, #4a90e2 0%, #87CEEB 100%);
}

.city-column[data-time="night"] .weather-bg-overlay {
    background: linear-gradient(180deg, #1e2637 0%, #2d3748 100%);
}

/* Adds a visible weather icon in the top-right corner */
.city-column::before {
    content: '';
    position: absolute;
    top: 20px;
    right: 20px;
    width: 80px;
    height: 80px;
    background-size: contain;
    background-repeat: no-repeat;
    z-index: 1;
    opacity: 0.9;
}

.city-column[data-weather="clear-day"]::before {
    background-image: url('https://cdn.jsdelivr.net/gh/basmilius/weather-icons/production/fill/all/clear-day.svg');
}

.city-column[data-weather="clear-night"]::before {
    background-image: url('https://cdn.jsdelivr.net/gh/basmilius/weather-icons/production/fill/all/clear-night.svg');
}

.city-column[data-weather="clouds"]::before {
    background-image: url('https://cdn.jsdelivr.net/gh/basmilius/weather-icons/production/fill/all/cloudy.svg');
}

.city-column[data-weather="rain"]::before {
    background-image: url('https://cdn.jsdelivr.net/gh/basmilius/weather-icons/production/fill/all/rain.svg');
}

.city-column[data-weather="snow"]::before {
    background-image: url('https://cdn.jsdelivr.net/gh/basmilius/weather-icons/production/fill/all/snow.svg');
}

/* Night sky stars effect */
.city-column[data-time="night"] .weather-bg-overlay::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image:
            radial-gradient(1px 1px at 25% 15%, white, transparent),
            radial-gradient(1px 1px at 50% 30%, white, transparent),
            radial-gradient(2px 2px at 75% 10%, white, transparent),
            radial-gradient(1px 1px at 10% 40%, white, transparent),
            radial-gradient(1.5px 1.5px at 35% 45%, white, transparent),
            radial-gradient(1px 1px at 60% 60%, white, transparent),
            radial-gradient(2px 2px at 85% 75%, white, transparent);
    opacity: 0.4;
    z-index: 0;
}

/* City content positioning */
.city-content {
    position: relative;
    z-index: 2;
}

/* City header with name and time */
.city-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.city-name {
    font-size: 2rem;
    font-weight: 400;
    margin: 0;
}

.current-time {
    font-size: 1.2rem;
    opacity: 0.9;
}

/* Main weather information */
.weather-main-info {
    text-align: center;
    margin-bottom: 1rem;
}

.temperature {
    display: inline-flex;
    align-items: flex-start;
}

.temp-value {
    font-size: 4rem;
    font-weight: 300;
    line-height: 1;
}

.temp-unit {
    font-size: 2rem;
    vertical-align: super;
    margin-top: 0.5rem;
}

.feels-like {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-top: 0.5rem;
}

/* Weather description */
.weather-description {
    text-align: center;
    font-size: 1.8rem;
    font-weight: 300;
    margin-bottom: 1.5rem;
}

/* Weather details grid */
.weather-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-top: 1.5rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    font-size: 1rem;
    padding: 0.5rem;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 5px;
}

.detail-label {
    font-weight: 500;
}

.detail-value {
    font-weight: 400;
}

/* Adds separator between columns */
@media (min-width: 768px) {
    .col-md-6:first-child {
        border-right: 1px solid rgba(255, 255, 255, 0.2);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .city-column {
        min-height: 350px;
        padding: 1.5rem;
    }

    .city-name {
        font-size: 1.5rem;
    }

    .temp-value {
        font-size: 3rem;
    }

    .temp-unit {
        font-size: 1.5rem;
    }

    .weather-description {
        font-size: 1.5rem;
    }

    .detail-item {
        font-size: 0.9rem;
    }

    .col-md-6:first-child {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }
}
</style>
