# Twin Cities Web Application Documentation

## Overview

This documentation covers the Twin Cities web application, a PHP-based website and app, that showcases paired cities (Birmingham, UK and Frankfurt, Germany) with interactive maps, weather data, and points of interest. The application uses the Google Maps API for location visualization and OpenWeather API for weather information.

## File Structure

### Main Files

| File | Purpose |
|------|---------|
| `index.php` | Main entry point that displays maps and weather for both cities |
| `config.php` | Configuration file with API keys, database settings, and city data |
| `weather.php` | Weather-related functions to fetch and format weather data |
| `city.php` | Displays detailed information for a single selected city |
| `docs.php` | Documentation page about the application |
| `404.php` | Custom error page for not found resources |

### Template Files

| File | Purpose |
|------|---------|
| `head.php` | HTML head section with metadata and CSS/JS links |
| `nav.php` | Navigation menu |
| `footer.php` | Footer content and closing HTML tags |
| `displaymap.php` | Template for rendering a Google Map with markers |
| `weatherwidget.php` | Template for displaying weather information |

### Utility Files

| File | Purpose |
|------|---------|
| `darkmode.php` | Manages the dark mode feature |
| `getplaces.php` | API endpoint to retrieve places from the database |
| `placesdetails.php` | Displays detailed information about a specific place |
| `rss_feed.php` | Generates an RSS feed of city and place information |

## Key Components

### 1. Configuration (`config.php`)

This file contains configuration settings:

- **API Keys**: OpenWeather, Google Maps, and Flickr
- **Database Connection**: Host, user, password, and database name
- **City Data**: Detailed information about Birmingham and Frankfurt including:
  - Geographic coordinates
  - Country code
  - Population
  - Points of interest with coordinates and opening hours
- **Error Handling**: Custom error and exception handlers

### 2. Index Page (`index.php`)

The main page of the application:

- Fetches city data from configuration
- Retrieves and formats weather information
- Displays maps for both cities with points of interest
- Provides a weather widget with current conditions and forecasts

Key functions:
- `getCityData()`: Extracts city information from configuration
- `getFormattedWeatherData()`: Retrieves and formats weather information
- `displayMap()`: Renders a map for a specified city

### 3. Weather Module (`weather.php`)

Handles all weather-related functionality:

- `getCurrentWeather()`: Fetches current weather data from OpenWeather API
- `getForecastWeather()`: Retrieves forecast data from OpenWeather API
- `formatCurrentWeather()`: Processes and formats current weather data
  - Converts temperatures from Kelvin to Celsius
  - Formats time information with timezone offsets
  - Extracts relevant data points (temperature, humidity, wind, etc.)
- `formatForecastWeather()`: Processes and formats forecast data
  - Limits to 20 forecast periods
  - Formats each forecast with relevant data points

### 4. Map Display (`displaymap.php`)

Creates interactive Google Maps:

- Takes map data as input (city name, coordinates, markers)
- Renders a map centered on the specified city
- Adds custom markers for points of interest
- Creates interactive info windows that display on mouseover
- Customizes map appearance by hiding default Google POIs

### 5. City Page (`city.php`)

Displays information about a single selected city:

- Validates the city parameter from URL
- Displays the map for the selected city
- Shows weather information
- Uses the same templating system as the index page

### 6. Weather Widget (`weatherwidget.php`)

Creates a visual weather display component for the two cities:

#### Weather Condition Detection

- `getWeatherCondition()` function:
  - Takes formatted weather data as input
  - Determines appropriate weather condition based on the main weather type (clear, clouds, rain, snow)
  - Checks if it's day or night by comparing current time against sunrise/sunset times
  - Returns a condition string (clear-day, clear-night, clouds, rain, snow) used for styling

#### Time of Day Calculation

- Calculates if it's currently daytime or nighttime for each city:
  - Extracts current time, sunrise time, and sunset time from the weather data
  - Compares timestamps to determine if the current time falls between sunrise and sunset
  - Sets a boolean flag (`$isDaytime1`, `$isDaytime2`) for each city

#### Weather Data Processing

- Extracts and prepares weather data for display:
  - Handles missing data with default values (e.g., precipitation defaults to 0%)
  - Formats weather descriptions with proper capitalization
  - Rounds temperature values for cleaner display

#### HTML Structure

- Creates a responsive two-column layout:
  - Each city gets one column (`city-column`) with dynamic data attributes for styling
  - City header shows name and current time
  - Main weather info displays temperature and "feels like" temperature
  - Weather description shows current conditions in text form
  - Weather details section shows precipitation, humidity, wind, and sunrise in a grid layout

#### Dynamic Styling

- CSS provides:
  - Weather-based styling through data attributes (`data-weather` and `data-time`)
  - Different background gradients for day (blue) and night (dark blue with stars)
  - Weather condition icons displayed based on current conditions
  - Star effect simulation for nighttime backgrounds
  - Responsive design that adapts to different screen sizes
  - Smooth transitions between weather states

#### Weather Icons

- Uses SVG weather icons from the Basmilius weather icons library:
  - Different icons for clear day, clear night, clouds, rain, and snow
  - Icons are positioned in the top-right corner of each city's weather card
  - Icons are loaded from a CDN (jsdelivr)

#### Responsive Design

- Mobile-friendly layout:
  - Adjusts font sizes and spacing for smaller screens
  - Changes from side-by-side to stacked layout on mobile
  - Adds appropriate borders between cities (right border on desktop, bottom border on mobile)

### 7. Database Integration

Several files interact with the MySQL database:

- `getplaces.php`: Retrieves all places with coordinates and city names
- `placesdetails.php`: Fetches detailed information about a specific place
- `rss_feed.php`: Generates an RSS feed from database content

### 8. Error Handling

The application includes comprehensive error handling:

- Custom error handler in `config.php`
- Custom exception handler
- Shutdown function to catch fatal errors
- Dedicated 404 page for not found resources

## JavaScript Functionality

The application includes client-side JavaScript for:

- Map initialization and interaction
- Marker creation and info window handling
- Dark mode toggle

## API Integration

The application integrates with:

1. **Google Maps API**: For displaying interactive maps with custom markers
2. **OpenWeather API**: For current and forecast weather data
3. **Flickr API**: We defined API key which we intend to use in the future

## Templates and Design

The application uses:

- Bootstrap 5 for responsive design
- Bootstrap Icons for visual elements
- Custom CSS for styling
- A consistent template system with header, navigation, and footer

## Additional Features

1. **RSS Feed**: Provides city and place information in RSS format
2. **Dark Mode**: We have implemented the code which we plan to use in the future
3. **Documentation**: We intend this to be a dedicated page explaining the application
4. **Error Pages**: Custom 404 page for better user experience

## Database Schema

The database has:

- `city` table: Storing city information
- `place` table: Storing points of interest
- `news` table: Storing news items related to cities