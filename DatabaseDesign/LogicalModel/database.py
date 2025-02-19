# Description: This file contains the functions to connect to a MySQL database, create a database, create tables, and insert data into tables.
import mysql.connector
from mysql.connector import Error
import configparser

# Get the data from configuration file
def get_db_config(config_file):
    config = configparser.ConfigParser()
    config.read(config_file)
    
    db_config = {
        'hostname': config['DBMS']['Host'],
        'username': config['DBMS']['User'],
        'password': config['DBMS']['Password']
    }
    
    return db_config
#------------------------------------------------------------#
def main():
    config_file = "twincities/config.ini"
    db_config = get_db_config(config_file)

    connect(db_config['hostname'], db_config['username'], db_config['password']) # invoke the connect function
    create_database(db_config['hostname'], db_config['username'], db_config['password'], 'twincities') # invoke the create_database function
    create_table(db_config['hostname'], db_config['username'], db_config['password'], 'twincities', 'city') # invoke the create_table function
    insert_data(db_config['hostname'], db_config['username'], db_config['password'], 'twincities', 'city', 'data') # invoke the insert_data function

#------------------------------------------------------------#
# Connect to MySQL
def connect(hostname, username, password):
    try:
        db = mysql.connector.connect(host=hostname, user=username, password=password)
        if db.is_connected():
            print('Connected to MySQL database')
    except Error as e:
        print(e)
    finally:
        db.close()

# Create a database and use it
def create_database(hostname, username, password, database_name):
    try:
        db = mysql.connector.connect(host=hostname, user=username, password=password)
        cursor = db.cursor()
        cursor.execute(f'CREATE DATABASE {database_name} IF NOT EXISTS')
        cursor.execute(f'USE {database_name}')
        print(f'{database_name} created and in use')
    except Error as e:
        print(e)
    finally:
        cursor.close()
        db.close()

# Create a table
def create_table(hostname, username, password, database_name):
    try:
        db = mysql.connector.connect(host=hostname, user=username, password=password, database=database_name)
        cursor = db.cursor()
        cursor.execute(
            '''CREATE TABLE city (
    cityID INTEGER PRIMARY KEY AUTOINCREMENT,
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

-- Create table for country
CREATE TABLE country (
    countryID INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    code CHAR(3) NOT NULL,
    currencyname VARCHAR(255),
    currencysymbol VARCHAR(255)
);

-- Create table for news
CREATE TABLE news (
    newsID INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    date DATE NOT NULL,
    cityID INT NOT NULL,
    FOREIGN KEY (cityID) REFERENCES city(cityID)
);

-- Create table for photo
CREATE TABLE photo (
    photoID INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    image BLOB NOT NULL,
    date DATE NOT NULL,
    cityID INT NOT NULL,
    FOREIGN KEY (cityID) REFERENCES city(cityID)
);

-- Create junction table for news and photo
CREATE table news_photo (
    newsID INT NOT NULL,
    photoID INT NOT NULL,
    FOREIGN KEY (newsID) REFERENCES news(newsID),
    FOREIGN KEY (photoID) REFERENCES photo(photoID)
);

-- Create table for user
CREATE TABLE user (
    userID INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(255) NOT NULL
);

-- Create table for comment
CREATE TABLE comment (
    commentID INTEGER PRIMARY KEY AUTOINCREMENT,
    content TEXT NOT NULL,
    date DATE NOT NULL,
    cityID INT NOT NULL,
    userID INT NOT NULL,
    FOREIGN KEY (cityID) REFERENCES city(cityID),
    FOREIGN KEY (userID) REFERENCES user(userID)
);

-- Create table for place
CREATE TABLE place (
    placeID INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    cityID INT NOT NULL,
    FOREIGN KEY (cityID) REFERENCES city(cityID)
);

-- Create table for category
CREATE TABLE category (
    categoryID INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL
);

-- Create junction table for place_category
CREATE table place_category (
    placeID INT NOT NULL,
    categoryID INT NOT NULL,
    FOREIGN KEY (placeID) REFERENCES place(placeID),
    FOREIGN KEY (categoryID) REFERENCES category(categoryID)
);)
                       ''')
        print('tables created')
    except Error as e:
        print(e)
    finally:
        cursor.close()
        db.close()

# Insert data into table
def insert_data(hostname, username, password, database_name):
    try:
        db = mysql.connector.connect(host=hostname, user=username, password=password, database=database_name)
        cursor = db.cursor()
        cursor.execute('''
-- Add data into the city table
INSERT INTO city 
(name, description, history, latitude, longitude, timezone, language, population, countryID) 
VALUES 
-- Birmingham City's Data
("Birmingham",
"A major city in England's West Midlands region, known for its rich industrial history and vibrant cultural scene.", 
"Second-largest city in Britain, with a population of 1.158 million in the city proper. It played a key role in the Industrial Revolution and has since evolved into a modern metropolis.", 
52.4862, 
-1.8904, 
"GMT", 
"English",
1080000, 
1),
-- Frankfurt City's Data
("Frankfurt", 
"A major financial hub in Germany, home to the European Central Bank.", 
"Frankfurt has a rich history dating back to the Roman Empire. It became a major center for trade and finance in medieval Europe and continues to be a global financial hub today.", 
50.1109, 
8.6821, 
"CET", 
"German", 
732688, 
2); 

-- Insert data into country table
INSERT INTO country
(name, code, currencyname, currencysymbol)
VALUES
("United Kingdom", "GB", "Pound Sterling", "£"),
("Germany", "DE", "Euro", "€");

-- Insert data into news, photo and news_photo tables
INSERT INTO news (title, content, date, cityID) 
VALUES 
-- Birmingham News
('Birmingham Hosts International Business Summit', 
    'Birmingham has successfully hosted the annual International Business Summit, attracting investors and entrepreneurs from around the world.', 
    '2024-02-10', 1),
('New Transport Plans for Birmingham Unveiled', 
    'The city council has announced plans to invest £1.5 billion into the public transport system, improving connectivity and sustainability.', 
    '2024-01-25', 1),
('Birmingham Museum & Art Gallery to Reopen', 
    'After extensive renovations, the Birmingham Museum & Art Gallery is set to reopen, featuring new exhibits and enhanced visitor experiences.', 
    '2024-03-05', 1),
('Tech Startups Flourish in Birmingham', 
    'Birmingham is becoming a hub for tech startups, with new coworking spaces and government incentives attracting innovative companies.', 
    '2024-02-15', 1),
('Aston Villa Wins Premier League Match', 
    'Aston Villa secured a thrilling victory in their latest Premier League match, keeping hopes alive for European qualification.', 
    '2024-02-20', 1),

-- Frankfurt News
('Frankfurt Stock Exchange Hits Record High', 
    'The Frankfurt Stock Exchange has reached an all-time high, reflecting positive economic trends in the Eurozone.', 
    '2024-02-12', 2),
('Frankfurt Hosts International Auto Show', 
    'The Frankfurt International Auto Show has unveiled the latest electric vehicles and autonomous driving technology.', 
    '2024-01-30', 2),
('New High-Speed Rail Line to Connect Frankfurt and Berlin', 
    'A new high-speed rail project has been approved, cutting travel time between Frankfurt and Berlin to under three hours.', 
    '2024-03-01', 2),
('Frankfurt Christmas Market Attracts Millions', 
    'The annual Frankfurt Christmas Market saw record attendance, with visitors enjoying traditional German holiday treats and crafts.', 
    '2023-12-20', 2),
('Eintracht Frankfurt Advances in UEFA Europa League', 
    'Eintracht Frankfurt has progressed to the knockout stage of the UEFA Europa League after a strong group stage performance.', 
    '2024-02-17', 2);

INSERT INTO photo (title, image, date, cityID) 
VALUES 
--  Birmingham Photos
('Students participating in the conference at the University of Birmingham Dubai', ?, '2024-02-10', 1),
('New Transport Plans for Birmingham Unveiled', ?, '2024-01-25', 1),
('Birmingham Museum & Art Gallery to Reopen', ?, '2024-03-05', 1),
('Tech Startups Flourish in Birmingham', ?, '2024-02-15', 1),
('Aston Villa Wins Premier League Match', ?, '2024-02-20', 1),

--  Frankfurt Photos
('Frankfurt Stock Exchange Hits Record High', ?, '2024-02-12', 2),
('Frankfurt Hosts International Auto Show', ?, '2024-01-30', 2),
('New High-Speed Rail Line to Connect Frankfurt and Berlin', ?, '2024-03-01', 2),
('Frankfurt Christmas Market Attracts Millions', ?, '2023-12-20', 2),
('Eintracht Frankfurt Advances in UEFA Europa League', ?, '2024-02-17', 2);

INSERT INTO news_photo (newsID, photoID) 
VALUES 
-- Birmingham News & Photos
(1, 1),  -- Birmingham Business Summit -> Photo of the summit
(2, 2),  -- Transport Plan Announcement -> Photo of transport development
(3, 3),  -- Museum & Art Gallery Reopening -> Photo of the museum
(4, 4),  -- Tech Startups Flourish -> Photo of a startup hub
(5, 5),  -- Aston Villa Football Match -> Photo of Aston Villa stadium

--  Frankfurt News & Photos
(6, 6),  -- Stock Exchange Record High -> Photo of Frankfurt Stock Exchange
(7, 7),  -- International Auto Show -> Photo of the Auto Show
(8, 8),  -- High-Speed Rail Project -> Photo of a high-speed train
(9, 9),  -- Frankfurt Christmas Market -> Photo of the Christmas Market
(10, 10); -- Eintracht Frankfurt UEFA Victory -> Photo of the football match celebration

INSERT INTO place (name, description, latitude, longitude, cityID) 
VALUES 
--  Birmingham Places
('Birmingham Museum & Art Gallery', 'A major museum known for its Pre-Raphaelite art collection and historical exhibits.', 52.4797, -1.9020, 1),
('Bullring Shopping Centre', 'One of the largest shopping centers in the UK, famous for its modern architecture.', 52.4778, -1.8932, 1),
('Cadbury World', 'A visitor attraction showcasing the history and production of Cadbury chocolates.', 52.4286, -1.9279, 1),
('Birmingham Botanical Gardens', 'Beautiful Victorian gardens featuring glasshouses and rare plant species.', 52.4711, -1.9367, 1),
('Library of Birmingham', 'A modern library with a unique architectural design and extensive book collections.', 52.4798, -1.9049, 1),

--  Frankfurt Places
('Römerberg', 'The historic heart of Frankfurt, home to the Römer, the city hall since the 15th century.', 50.1109, 8.6821, 2),
('Palmengarten', 'A large botanical garden with exotic plants, greenhouses, and themed landscapes.', 50.1233, 8.6507, 2),
('Goethe House', 'The birthplace of the famous German writer Johann Wolfgang von Goethe.', 50.1106, 8.6825, 2),
('Main Tower', 'A skyscraper offering panoramic views of Frankfurt from its observation deck.', 50.1106, 8.6754, 2),
('Senckenberg Natural History Museum', 'One of the largest natural history museums in Germany, featuring dinosaur fossils and scientific exhibits.', 50.1175, 8.6527, 2);

INSERT INTO category (name) 
VALUES 
-- General Categories
('Historical'),
('Cultural'),
('Tourism'),
('Education'),
('Business'),
('Sports'),
('Technology'),
('Entertainment'),
('Nature'),
('Transportation');

INSERT INTO place_category (placeID, categoryID) 
VALUES 
--  Birmingham Places Categories
(1, 1),  -- Birmingham Museum & Art Gallery -> Historical
(1, 2),  -- Birmingham Museum & Art Gallery -> Cultural
(2, 3),  -- Bullring Shopping Centre -> Tourism
(2, 8),  -- Bullring Shopping Centre -> Entertainment
(3, 3),  -- Cadbury World -> Tourism
(3, 8),  -- Cadbury World -> Entertainment
(4, 9),  -- Birmingham Botanical Gardens -> Nature
(5, 4),  -- Library of Birmingham -> Education
(5, 3),  -- Library of Birmingham -> Tourism

-- Frankfurt Places Categories
(6, 1),  -- Römerberg -> Historical
(6, 2),  -- Römerberg -> Cultural
(7, 9),  -- Palmengarten -> Nature
(7, 3),  -- Palmengarten -> Tourism
(8, 1),  -- Goethe House -> Historical
(8, 2),  -- Goethe House -> Cultural
(9, 3),  -- Main Tower -> Tourism
(9, 8),  -- Main Tower -> Entertainment
(10, 4), -- Senckenberg Natural History Museum -> Education
(10, 3); -- Senckenberg Natural History Museum -> Tourism




''')    
        print('data inserted')
    except Error as e:
        print(e)
    finally:
        cursor.close()
        db.close()

# Call main function
main()




