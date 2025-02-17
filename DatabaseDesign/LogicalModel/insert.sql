-- Add data into the city table

INSERT INTO city
(name, description, history, latitude, longitude, timezone, language, population)
VALUES
('Birmingham', 'A major city in England\'s West Midlands region.', 'Founded in the 6th century, Birmingham grew to prominence during the Industrial Revolution.', 52.4862, -1.8904, 'GMT', 'English', 1080000),
('Frankfurt', 'A major financial hub in Germany.', 'Frankfurt has a rich history dating back to the Roman Empire.', 50.1109, 8.6821, 'CET', 'German', 732688)
;

-- Insert data into country table
INSERT INTO country
(name, code)
VALUES
('United Kingdom', 'GB'),
('Germany', 'DE')
;

-- Insert data into currency table
INSERT INTO currency
(name, symbol)
VALUES
('Pound Sterling', '£'),
('Euro', '€')
;

-- Insert data into ethnicity
INSERT INTO ethnicity
(name)
VALUES
('White'),
('Black'),
('Asian'),
('Mixed'),
('Other')
;

-- Insert data into city and ethnicity junction table
INSERT INTO city_ethnicity
(cityID, ethnicityID)
VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5)
;

-- Insert data into news table
INSERT INTO news 
(title, content, date, cityID)
VALUES
('News Title 1', 'News Content 1', '2023-01-01', 1),
('News Title 2', 'News Content 2', '2023-01-02', 1),
('News Title 3', 'News Content 3', '2023-01-03', 1),
('News Title 4', 'News Content 4', '2023-01-04', 1),
('News Title 5', 'News Content 5', '2023-01-05', 1),
('News Title 6', 'News Content 6', '2023-01-06', 2),
('News Title 7', 'News Content 7', '2023-01-07', 2),
('News Title 8', 'News Content 8', '2023-01-08', 2),
('News Title 9', 'News Content 9', '2023-01-09', 2),
('News Title 10', 'News Content 10', '2023-01-10', 2)
;

-- Insert data into photo table
INSERT INTO photo
(title, image, date, cityID)
VALUES
('Photo Title 1', 'image1.jpg', '2023-01-01', 1),
('Photo Title 2', 'image2.jpg', '2023-01-02', 1),
('Photo Title 3', 'image3.jpg', '2023-01-03', 1),
('Photo Title 4', 'image4.jpg', '2023-01-04', 1),
('Photo Title 5', 'image5.jpg', '2023-01-05', 1),
('Photo Title 6', 'image6.jpg', '2023-01-06', 2),
('Photo Title 7', 'image7.jpg', '2023-01-07', 2),
('Photo Title 8', 'image8.jpg', '2023-01-08', 2),
('Photo Title 9', 'image9.jpg', '2023-01-09', 2),
('Photo Title 10', 'image10.jpg', '2023-01-10', 2)
;

-- Insert data into news_photo table
INSERT INTO news_photo
(newsID, photoID)
VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10)
;

-- Get the data from user to insert the data into user table and comment table



