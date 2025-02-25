<?php
namespace dsa_twin_cities;
include_once('C:\laragon\www\Twin-cities-web-app\config.php');

// Get database connection parameters
$hostname = DBMS['HOST'];
$username = DBMS['USER'];
$password = DBMS['PASSWORD'];
$database_name = DBMS['DBNAME'];

// Main functions
$db = connect($hostname, $username, $password);
create_database($db, $database_name);
create_tables($db, $database_name);
insert_data($db, $database_name);

// Connect to MySQL
function connect($hostname, $username, $password) {
    $db = null;
    try {
        $db = new \mysqli($hostname, $username, $password);
        if ($db->connect_error) {
            throw new \Exception("Connection failed: " . $db->connect_error);
        }
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
    return $db;
}

// Create a database and use it
function create_database($db, $database_name) {
    try {
        if ($db->connect_error) {
            throw new \Exception("Connection failed: " . $db->connect_error);
        }
        
        $sql = "CREATE DATABASE IF NOT EXISTS $database_name";
        if ($db->query($sql) === TRUE) {
            echo "Database created successfully\n";
        } else {
            throw new \Exception("Error creating database: " . $db->error);
        }
        
        $db->select_db($database_name);
        echo "$database_name created and in use\n";
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}

// Create tables
function create_tables($db, $database_name) {
    try {
        if ($db->connect_error) {
            throw new \Exception("Connection failed: " . $db->connect_error);
        }
        
        $sql = get_table_creation_sql();
        if ($db->multi_query($sql) === TRUE) {
            echo "Tables created successfully\n";
            // Consume all results from multi_query
            while ($db->next_result()) {
                // Free each result set
                if ($result = $db->store_result()) {
                    $result->free();
                }
            }
        } else {
            throw new \Exception("Error creating tables: " . $db->error);
        }
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}

// Insert data into tables
function insert_data($db, $database_name) {
    try {
        if ($db->connect_error) {
            throw new \Exception("Connection failed: " . $db->connect_error);
        }
        
        $sql = get_data_insertion_sql();
        if ($db->multi_query($sql) === TRUE) {
            echo "Data inserted successfully\n";
            // Consume all results from multi_query
            while ($db->next_result()) {
                // Free each result set
                if ($result = $db->store_result()) {
                    $result->free();
                }
            }
        } else {
            throw new \Exception("Error inserting data: " . $db->error);
        }
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}

// Get SQL for creating tables
function get_table_creation_sql() {
    return "
    CREATE TABLE IF NOT EXISTS country (
        countryID INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        code CHAR(3) NOT NULL,
        currencyname VARCHAR(255),
        currencysymbol VARCHAR(255)
    );

    CREATE TABLE IF NOT EXISTS city (
        cityID INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        history TEXT,
        latitude DECIMAL(10, 8),
        longitude DECIMAL(11, 8),
        timezone VARCHAR(255),
        language VARCHAR(255),
        population INT,
        countryID INT,
        FOREIGN KEY (countryID) REFERENCES country(countryID)
    );
    
    CREATE TABLE IF NOT EXISTS news (
        newsID INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        date DATE NOT NULL,
        cityID INT NOT NULL,
        FOREIGN KEY (cityID) REFERENCES city(cityID)
    );
    
    CREATE TABLE IF NOT EXISTS photo (
        photoID INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        image BLOB NULL,
        date DATE NOT NULL,
        cityID INT NOT NULL,
        FOREIGN KEY (cityID) REFERENCES city(cityID)
    );
    
    CREATE TABLE IF NOT EXISTS news_photo (
        newsID INT NOT NULL,
        photoID INT NOT NULL,
        FOREIGN KEY (newsID) REFERENCES news(newsID),
        FOREIGN KEY (photoID) REFERENCES photo(photoID)
    );
    
    CREATE TABLE IF NOT EXISTS user (
        userID INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL
    );
    
    CREATE TABLE IF NOT EXISTS comment (
        commentID INT AUTO_INCREMENT PRIMARY KEY,
        content TEXT NOT NULL,
        date DATE NOT NULL,
        cityID INT NOT NULL,
        userID INT NOT NULL,
        FOREIGN KEY (cityID) REFERENCES city(cityID),
        FOREIGN KEY (userID) REFERENCES user(userID)
    );
    
    CREATE TABLE IF NOT EXISTS place (
        placeID INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        opentimes VARCHAR(255),
        closetimes VARCHAR(255),
        latitude DECIMAL(10, 8),
        longitude DECIMAL(11, 8),
        cityID INT NOT NULL,
        FOREIGN KEY (cityID) REFERENCES city(cityID)
    );
    
    CREATE TABLE IF NOT EXISTS category (
        categoryID INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    );
    
    CREATE TABLE IF NOT EXISTS place_category (
        placeID INT NOT NULL,
        categoryID INT NOT NULL,
        FOREIGN KEY (placeID) REFERENCES place(placeID),
        FOREIGN KEY (categoryID) REFERENCES category(categoryID)
    );
    ";
}

// Get SQL for inserting data
function get_data_insertion_sql() {
    return "
    -- Insert data into country table
    INSERT INTO country (name, code, currencyname, currencysymbol)
    VALUES
    ('United Kingdom', 'GB', 'Pound Sterling', '£'),
    ('Germany', 'DE', 'Euro', '€');
     
    -- Add data into the city table
    INSERT INTO city (name, description, history, latitude, longitude, timezone, language, population, countryID) 
    VALUES 
    ('Birmingham', 'A major city in England\'s West Midlands region, known for its rich industrial history and vibrant cultural scene.', 'Second-largest city in Britain, with a population of 1.158 million in the city proper. It played a key role in the Industrial Revolution and has since evolved into a modern metropolis.', 52.4862, -1.8904, 'GMT', 'English', 1080000, 1),
    ('Frankfurt', 'A major financial hub in Germany, home to the European Central Bank.', 'Frankfurt has a rich history dating back to the Roman Empire. It became a major center for trade and finance in medieval Europe and continues to be a global financial hub today.', 50.1109, 8.6821, 'CET', 'German', 732688, 2);

    -- Insert data into news, photo and news_photo tables
    INSERT INTO news (title, content, date, cityID) 
    VALUES 
    ('Birmingham Hosts International Business Summit', 'Birmingham has successfully hosted the annual International Business Summit, attracting investors and entrepreneurs from around the world.', '2024-02-10', 1),
    ('New Transport Plans for Birmingham Unveiled', 'The city council has announced plans to invest £1.5 billion into the public transport system, improving connectivity and sustainability.', '2024-01-25', 1),
    ('Birmingham Museum & Art Gallery to Reopen', 'After extensive renovations, the Birmingham Museum & Art Gallery is set to reopen, featuring new exhibits and enhanced visitor experiences.', '2024-03-05', 1),
    ('Tech Startups Flourish in Birmingham', 'Birmingham is becoming a hub for tech startups, with new coworking spaces and government incentives attracting innovative companies.', '2024-02-15', 1),
    ('Aston Villa Wins Premier League Match', 'Aston Villa secured a thrilling victory in their latest Premier League match, keeping hopes alive for European qualification.', '2024-02-20', 1),
    ('Frankfurt Stock Exchange Hits Record High', 'The Frankfurt Stock Exchange has reached an all-time high, reflecting positive economic trends in the Eurozone.', '2024-02-12', 2),
    ('Frankfurt Hosts International Auto Show', 'The Frankfurt International Auto Show has unveiled the latest electric vehicles and autonomous driving technology.', '2024-01-30', 2),
    ('New High-Speed Rail Line to Connect Frankfurt and Berlin', 'A new high-speed rail project has been approved, cutting travel time between Frankfurt and Berlin to under three hours.', '2024-03-01', 2),
    ('Frankfurt Christmas Market Attracts Millions', 'The annual Frankfurt Christmas Market saw record attendance, with visitors enjoying traditional German holiday treats and crafts.', '2023-12-20', 2),
    ('Eintracht Frankfurt Advances in UEFA Europa League', 'Eintracht Frankfurt has progressed to the knockout stage of the UEFA Europa League after a strong group stage performance.', '2024-02-17', 2);
    
    INSERT INTO photo (title, image, date, cityID) 
    VALUES 
    ('Students participating in the conference at the University of Birmingham Dubai', NULL, '2024-02-10', 1),
    ('New Transport Plans for Birmingham Unveiled', NULL, '2024-01-25', 1),
    ('Birmingham Museum & Art Gallery to Reopen', NULL, '2024-03-05', 1),
    ('Tech Startups Flourish in Birmingham', NULL, '2024-02-15', 1),
    ('Aston Villa Wins Premier League Match', NULL, '2024-02-20', 1),
    ('Frankfurt Stock Exchange Hits Record High', NULL, '2024-02-12', 2),
    ('Frankfurt Hosts International Auto Show', NULL, '2024-01-30', 2),
    ('New High-Speed Rail Line to Connect Frankfurt and Berlin', NULL, '2024-03-01', 2),
    ('Frankfurt Christmas Market Attracts Millions', NULL, '2023-12-20', 2),
    ('Eintracht Frankfurt Advances in UEFA Europa League', NULL, '2024-02-17', 2);
    
    INSERT INTO news_photo (newsID, photoID) 
    VALUES 
    (1, 1), (2, 2), (3, 3), (4, 4), (5, 5), (6, 6), (7, 7), (8, 8), (9, 9), (10, 10);
    
    INSERT INTO place (name, description, opentimes, closetimes, latitude, longitude, cityID) 
    VALUES 
    ('Birmingham Museum & Art Gallery', 'A major museum known for its Pre-Raphaelite art collection and historical exhibits.', '09:00', '17:00', 52.4797, -1.9020, 1),
    ('Bullring Shopping Centre', 'One of the largest shopping centers in the UK, famous for its modern architecture.', '10:00', '20:00', 52.4778, -1.8932, 1),
    ('Cadbury World', 'A visitor attraction showcasing the history and production of Cadbury chocolates.', '10:00', '16:00', 52.4286, -1.9279, 1),
    ('Birmingham Botanical Gardens', 'Beautiful Victorian gardens featuring glasshouses and rare plant species.', '10:00', '18:00', 52.4711, -1.9367, 1),
    ('Library of Birmingham', 'A modern library with a unique architectural design and extensive book collections.', '08:00', '20:00', 52.4798, -1.9049, 1),
    ('Thinktank, Birmingham Science Museum', 'A science museum with interactive exhibits and a planetarium.', '10:00', '17:00', 52.4820, -1.8864, 1),
    ('Römerberg', 'The historic heart of Frankfurt, home to the Römer, the city hall since the 15th century.', '09:00', '18:00', 50.1109, 8.6821, 2),
    ('Palmengarten', 'A large botanical garden with exotic plants, greenhouses, and themed landscapes.', '09:00', '18:00', 50.1233, 8.6507, 2),
    ('Goethe House', 'The birthplace of the famous German writer Johann Wolfgang von Goethe.', '10:00', '18:00', 50.1106, 8.6825, 2),
    ('Main Tower', 'A skyscraper offering panoramic views of Frankfurt from its observation deck.', '10:00', '21:00', 50.1106, 8.6754, 2),
    ('Senckenberg Natural History Museum', 'One of the largest natural history museums in Germany, featuring dinosaur fossils and scientific exhibits.', '09:00', '17:00', 50.1175, 8.6527, 2),
    ('Frankfurt Zoo', 'A well-known zoo with a wide variety of animals and conservation programs.', '09:00', '18:00', 50.1167, 8.7016, 2);
    
    INSERT INTO category (name) 
    VALUES 
    ('Historical'), ('Cultural'), ('Tourism'), ('Education'), ('Business'), ('Sports'), ('Technology'), ('Entertainment'), ('Nature'), ('Transportation');
    
    INSERT INTO place_category (placeID, categoryID) 
    VALUES 
    (1, 1), (1, 2), (2, 3), (2, 8), (3, 3), (3, 8), (4, 9), (5, 4), (5, 3), (6, 1), (6, 2), (7, 9), (7, 3), (8, 1), (8, 2), (9, 3), (9, 8), (10, 4), (10, 3), (11, 1), (11, 2), (12, 9), (12, 3);
    ";
}
?>



