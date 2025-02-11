-- Create a table for city
CREATE TABLE city (
    cityID INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    country VARCHAR(255) NOT NULL,
    latitude DECIMAL(9,6) NOT NULL,
    longitude DECIMAL(9,6) NOT NULL,
    timezone VARCHAR(255) NOT NULL,
    language VARCHAR(255) NOT NULL,
    population INT,
    countrycode CHAR(2) NOT NULL,
    currencyID INT NOT NULL,
    ethnicityID INT NOT NULL,
    PRIMARY KEY (cityID),
    FOREIGN KEY (currencyID) REFERENCES currency(currencyID),
    FOREIGN KEY (ethnicityID) REFERENCES ethnicity(ethnicityID)
);

show tables;

-- Create a table for currency
CREATE TABLE currency (
    currencyID INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    symbol VARCHAR(255) NOT NULL,
    PRIMARY KEY (currencyID)
);

-- Create a table for ethnicity
CREATE TABLE ethnicity (
    ethnicityID INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (ethnicityID)
);

-- Create a table for news
CREATE TABLE news (
    newsID INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    date DATE NOT NULL,
    cityID INT NOT NULL,
    PRIMARY KEY (newsID),
    FOREIGN KEY (cityID) REFERENCES city(cityID)
);

-- Create a table for photo
CREATE TABLE photo (
    photoID INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    image BLOB NOT NULL,
    date DATE,
    cityID INT NOT NULL,
    PRIMARY KEY (photoID),
    FOREIGN KEY (cityID) REFERENCES city(cityID)
);

-- Create a table for comment
CREATE TABLE comment (
    commentID INT NOT NULL AUTO_INCREMENT,
    content TEXT NOT NULL,
    date DATE NOT NULL,
    cityID INT NOT NULL,
    PRIMARY KEY (commentID),
    FOREIGN KEY (cityID) REFERENCES city(cityID)
);

-- Create a table for place
CREATE TABLE place (
    placeID INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    latitude DECIMAL(9,6) NOT NULL,
    longitude DECIMAL(9,6) NOT NULL,
    cityID INT NOT NULL,
    categoryID INT NOT NULL,
    PRIMARY KEY (placeID),
    FOREIGN KEY (cityID) REFERENCES city(cityID),
    FOREIGN KEY (categoryID) REFERENCES category(categoryID)
);

-- Create a table for category
CREATE TABLE category (
    categoryID INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (categoryID)
);
-----------------------------------------------------------------

-- Insert data into city table
INSERT INTO city 
    (name, country, latitude, longitude, timezone, language, population, countrycode, currencyID, ethnicityID)
        VALUES 
        ('Birminham', 'United Kingdom', 52.4862, -1.8904, 'GMT', 'English', 1085810, 'GB', 1, 1),
        ('Frankfurt', 'Germany', 50.1109, 8.6821, 'CET', 'German', 753056, 'DE', 2, 2);

-- Insert data into currency table
INSERT INTO currency 
    (name, symbol)
        VALUES 
        ('Pound Sterling', '£'),
        ('Euro', '€');

