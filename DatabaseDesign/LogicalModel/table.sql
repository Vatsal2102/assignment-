-- *** Put 'AUTO_INCREMENT' in Mysql for the 1* key ***

-- Create table for city

CREATE TABLE city (
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
);