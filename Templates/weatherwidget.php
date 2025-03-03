<?php
// Get weather conditions for styling
function getWeatherCondition($formattedWeather) {
    $weatherCondition = 'clear-day'; // Default value
    if (isset($formattedWeather['weather_main'])) {
        $weatherMain = strtolower($formattedWeather['weather_main']);

        // Set weather condition based on main weather and time of day
        if ($weatherMain == 'clear') {
            // Check if it's day or night based on current time vs sunrise/sunset
            $currentTime = strtotime($formattedWeather['date']);
            $sunriseTime = strtotime($formattedWeather['sunrise']);
            $sunsetTime = isset($formattedWeather['sunset']) ? strtotime($formattedWeather['sunset']) : null;

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

// Get weather conditions for both cities
$weatherCondition1 = getWeatherCondition($weatherDataCity1['current']);
$weatherCondition2 = getWeatherCondition($weatherDataCity2['current']);

// Check if it's day or night for each city
$currentTime1 = strtotime($weatherDataCity1['current']['date']);
$sunriseTime1 = strtotime($weatherDataCity1['current']['sunrise']);
$sunsetTime1 = isset($weatherDataCity1['current']['sunset']) ? strtotime($weatherDataCity1['current']['sunset']) : null;
$isDaytime1 = ($currentTime1 >= $sunriseTime1 && ($sunsetTime1 === null || $currentTime1 <= $sunsetTime1));

$currentTime2 = strtotime($weatherDataCity2['current']['date']);
$sunriseTime2 = strtotime($weatherDataCity2['current']['sunrise']);
$sunsetTime2 = isset($weatherDataCity2['current']['sunset']) ? strtotime($weatherDataCity2['current']['sunset']) : null;
$isDaytime2 = ($currentTime2 >= $sunriseTime2 && ($sunsetTime2 === null || $currentTime2 <= $sunsetTime2));

// Get precipitation chance (default to 0 if not available)
$precipitation1 = isset($weatherDataCity1['current']['precipitation']) ? $weatherDataCity1['current']['precipitation'] : '0';
$precipitation2 = isset($weatherDataCity2['current']['precipitation']) ? $weatherDataCity2['current']['precipitation'] : '0';

// Get weather descriptions and main weather types
$weatherDesc1 = ucfirst($weatherDataCity1['current']['description']);
$weatherDesc2 = ucfirst($weatherDataCity2['current']['description']);
?>

<div class="combined-weather-container">
    <div class="row">
        <!-- First City -->
        <div class="col-md-6 city-column" data-weather="<?php echo $weatherCondition1; ?>" data-time="<?php echo $isDaytime1 ? 'day' : 'night'; ?>">
            <div class="weather-bg-overlay"></div>
            <div class="city-content">
                <div class="city-header">
                    <h1 class="city-name"><?php echo $weatherDataCity1['current']['name']; ?></h1>
                    <div class="current-time"><?php echo date('H:i', strtotime($weatherDataCity1['current']['date'])); ?></div>
                </div>

                <div class="weather-main-info">
                    <div class="temperature">
                        <span class="temp-value"><?php echo round($weatherDataCity1['current']['temp']); ?></span>
                        <span class="temp-unit">°</span>
                    </div>
                    <div class="feels-like">Feels Like <?php echo round($weatherDataCity1['current']['feels_like']); ?>°</div>
                </div>

                <div class="weather-description"><?php echo $weatherDesc1; ?></div>

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

        <!-- Second City -->
        <div class="col-md-6 city-column" data-weather="<?php echo $weatherCondition2; ?>" data-time="<?php echo $isDaytime2 ? 'day' : 'night'; ?>">
            <div class="weather-bg-overlay"></div>
            <div class="city-content">
                <div class="city-header">
                    <h1 class="city-name"><?php echo $weatherDataCity2['current']['name']; ?></h1>
                    <div class="current-time"><?php echo date('H:i', strtotime($weatherDataCity2['current']['date'])); ?></div>
                </div>

                <div class="weather-main-info">
                    <div class="temperature">
                        <span class="temp-value"><?php echo round($weatherDataCity2['current']['temp']); ?></span>
                        <span class="temp-unit">°</span>
                    </div>
                    <div class="feels-like">Feels Like <?php echo round($weatherDataCity2['current']['feels_like']); ?>°</div>
                </div>

                <div class="weather-description"><?php echo $weatherDesc2; ?></div>

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
