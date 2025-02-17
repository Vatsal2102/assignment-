-- *** Put 'AUTO_INCREMENT' in Mysql for the 1* key ***

-- Create table for city

CREATE TABLE city (
    cityID INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    history TEXT,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    timezone VARCHAR(255),
    language VARCHAR(255),
    population INT,
    currencyID INT,
    countryID INT,
    PRIMARY KEY (cityID),
    FOREIGN KEY (currencyID) REFERENCES currency(currencyID),
    FOREIGN KEY (countryID) REFERENCES country(countryID)
);

-- Create table for country
CREATE TABLE country (
    countryID INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    code CHAR(3) NOT NULL,
    PRIMARY KEY (countryID)
);

-- Create table for currency
CREATE TABLE currency (
    currencyID INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    symbol VARCHAR(255) NOT NULL,
    PRIMARY KEY (currencyID)
);

-- Create table for ethnicity
CREATE TABLE ethnicity (
    ethnicityID INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (ethnicityID)
);

-- Create junction table for city and ethnicity
CREATE table city_ethnicity (
    cityID INT NOT NULL,
    ethnicityID INT NOT NULL,
    FOREIGN KEY (cityID) REFERENCES city(cityID),
    FOREIGN KEY (ethnicityID) REFERENCES ethnicity(ethnicityID)
);

-- Create table for news
CREATE TABLE news (
    newsID INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    date DATE NOT NULL,
    cityID INT NOT NULL,
    PRIMARY KEY (newsID),
    FOREIGN KEY (cityID) REFERENCES city(cityID)
);

-- Create table for photo
CREATE TABLE photo (
    photoID INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    image BLOB NOT NULL,
    date DATE,
    cityID INT NOT NULL,
    PRIMARY KEY (photoID),
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
    userID INT NOT NULL,
    username VARCHAR(255) NOT NULL,
    PRIMARY KEY (userID)
);

-- Create table for comment
CREATE TABLE comment (
    commentID INT NOT NULL,
    content TEXT NOT NULL,
    date DATE NOT NULL,
    cityID INT NOT NULL,
    userID INT NOT NULL,
    PRIMARY KEY (commentID),
    FOREIGN KEY (cityID) REFERENCES city(cityID),
    FOREIGN KEY (userID) REFERENCES user(userID)
);

-- Create table for place
CREATE TABLE place (
    placeID INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    cityID INT NOT NULL,
    PRIMARY KEY (placeID),
    FOREIGN KEY (cityID) REFERENCES city(cityID)
);

-- Create table for category
CREATE TABLE category (
    categoryID INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (categoryID)
);

-- Create junction table for place_category
CREATE table place_category (
    placeID INT NOT NULL,
    categoryID INT NOT NULL,
    FOREIGN KEY (placeID) REFERENCES place(placeID),
    FOREIGN KEY (categoryID) REFERENCES category(categoryID)
);