-- Create a table for the city
CREATE TABLE city (
    cityID INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    latitude DECIMAL(9,6) NOT NULL,
    longitude DECIMAL(9,6) NOT NULL,
    timezone VARCHAR(255) NOT NULL,
    language VARCHAR(255) NOT NULL,
    population INT,
    countrycode CHAR(2) NOT NULL,
    currencyID INT NOT NULL,
    ethnicityID INT NOT NULL,
    newsID INT NOT NULL,
    photoID INT NOT NULL,
    commentID INT NOT NULL,
    placeID INT NOT NULL,
    PRIMARY KEY (cityID),
    FOREIGN KEY (currencyID) REFERENCES currency(currencyID),
    FOREIGN KEY (ethnicityID) REFERENCES ethnicity(ethnicityID),
    FOREIGN KEY (newsID) REFERENCES news(newsID),
    FOREIGN KEY (photoID) REFERENCES photo(photoID),
    FOREIGN KEY (commentID) REFERENCES comment(commentID),
    FOREIGN KEY (placeID) REFERENCES place(placeID)
);

-- Create a table for the currency
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
    PRIMARY KEY (newsID)
);

-- Create a table for photo
CREATE TABLE photo (
    photoID INT NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    image BLOB NOT NULL,
    date DATE,
    PRIMARY KEY (photoID)
);

-- Create a table for comment
CREATE TABLE comment (
    commentID INT NOT NULL AUTO_INCREMENT,
    content TEXT NOT NULL,
    date DATE NOT NULL,
    PRIMARY KEY (commentID)
);

-- Create a table for place
CREATE TABLE place (
    placeID INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    latitude DECIMAL(9,6) NOT NULL,
    longitude DECIMAL(9,6) NOT NULL,
    PRIMARY KEY (placeID)
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
    (name, latitude, longitude, timezone, language, population, countrycode, currencyID, ethnicityID, newsID, photoID, commentID, placeID)
        VALUES 
        ('Birmingham', 52.4862, -1.8904, 'GMT', 'English', 1141816, 'GB', 1, 1, 1, 1, 1, 1),
        ('Frankfurt', 50.1109, 8.6821, 'CET', 'German', 753056, 'DE', 2, 2, 2, 2, 2, 2);

-- Insert data into currency table
INSERT INTO currency 
    (name, symbol)
        VALUES 
        ('Pound Sterling', '£'),
        ('Euro', '€');

