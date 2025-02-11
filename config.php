<?php
namespace dsa_twin_cities;
@date_default_timezone_set("GMT");

#API keys
define ('OpenWeatherAPI', '');
define ('GoogleAPI', '');
define ('FlickrAPI', '');

#Database connection
define ('DBMS', [
    'Host' => '',
    'DB' => '',
    'User' => '',
    'Password' => ''
    
]);

#Brimingham(city1) data
define ('City1', [
    'Name' => 'Birmingham',
    'Latitude' => '',
    'Longitude' => '-',
    'Timezone' => '',
    'Language' => '',
    'Population' => '',
    'Countrycode' => '',
    'CurrencyID' => '',



    
]);

#Frankfurt(city2) data
define ('City2', [
    'Name' => 'Frankfurt',
    'Latitude' => '',
    'Longitude' => '',
    'Timezone' => '',
    'Language' => '',
    'Population' => '',
    'Countrycode' => '',
    'CurrencyID' => '',

    
]);

#Error handling
