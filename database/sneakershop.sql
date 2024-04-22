DROP DATABASE IF EXISTS defaultdb;
CREATE DATABASE defaultdb;
USE defaultdb;

/* Create Brands table */
CREATE TABLE IF NOT EXISTS Brands (
    Brand_ID INT AUTO_INCREMENT PRIMARY KEY,
    Brand_Name VARCHAR(255) NOT NULL,
    Brand_Description TEXT 
);

/* Create Size table */
CREATE TABLE IF NOT EXISTS Sizes (
    Size_ID INT AUTO_INCREMENT PRIMARY KEY,
    Size_Value INT NOT NULL
);

/* Create Sneakers table */
CREATE TABLE IF NOT EXISTS Sneakers (
    Sneaker_ID INT AUTO_INCREMENT PRIMARY KEY,
    Brand_ID INT,
    Sneaker_Model VARCHAR(255) NOT NULL,
    Sneaker_Description TEXT,
    Sneaker_Price DECIMAL(10, 2) NOT NULL,
    Sneaker_Stock INT NOT NULL,
    Sneaker_ImageURL VARCHAR(255),
    FOREIGN KEY (Brand_ID) REFERENCES Brands(Brand_ID)
);

/* Create Sneaker_Size table */
CREATE TABLE IF NOT EXISTS Sneaker_Sizes (
    Sneaker_ID INT,
    Size_ID INT,
    PRIMARY KEY (Sneaker_ID, Size_ID),
    FOREIGN KEY (Sneaker_ID) REFERENCES Sneakers(Sneaker_ID),
    FOREIGN KEY (Size_ID) REFERENCES Sizes(Size_ID)
);

/* Create User, Token, Orders, and Order_Detail tables */
CREATE TABLE IF NOT EXISTS Users (
    User_ID INT AUTO_INCREMENT PRIMARY KEY,
    User_Email VARCHAR(255) NOT NULL,
    User_Password VARCHAR(255) NOT NULL,
    User_Role ENUM('admin', 'user') DEFAULT 'user'
);

/* Create Token table */
CREATE TABLE IF NOT EXISTS Tokens (
    Token_ID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT,
    Token_Value VARCHAR(255) NOT NULL,
    Token_Created_At DATETIME DEFAULT CURRENT_TIMESTAMP,
    Token_Expired_At DATETIME NOT NULL,
    FOREIGN KEY (User_ID) REFERENCES Users(User_ID)
);

/* Create Cart_Items table */
CREATE TABLE IF NOT EXISTS Cart (
    Cart_Item_ID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT NOT NULL,
    Sneaker_ID INT NOT NULL,
    Size_ID INT NOT NULL,
    Quantity INT NOT NULL,
    FOREIGN KEY (User_ID) REFERENCES Users(User_ID),
    FOREIGN KEY (Sneaker_ID) REFERENCES Sneakers(Sneaker_ID),
    FOREIGN KEY (Size_ID) REFERENCES Sizes(Size_ID)
);

/* Create Orders table */
CREATE TABLE IF NOT EXISTS Orders (
    Order_ID INT AUTO_INCREMENT PRIMARY KEY,
    User_ID INT,
    Order_Date DATE NOT NULL,
    Order_Total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (User_ID) REFERENCES Users(User_ID)
);

/* Create Order_Detail table */
CREATE TABLE IF NOT EXISTS Order_Details (
    OrderDetail_ID INT AUTO_INCREMENT PRIMARY KEY,
    Order_ID INT,
    Sneaker_ID INT,
    Size_ID INT,
    Order_Quantity INT NOT NULL,
    Price_Per_Unit DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (Order_ID) REFERENCES Orders(Order_ID),
    FOREIGN KEY (Sneaker_ID) REFERENCES Sneakers(Sneaker_ID),
    FOREIGN KEY (Size_ID) REFERENCES Sizes(Size_ID)
);

/* Insert example data into Brands table */
INSERT INTO Brands (Brand_ID, Brand_Name, Brand_Description) VALUES
(1, 'Nike', 'American multinational corporation that is engaged in the design, development, manufacturing, and worldwide marketing and sales of footwear, apparel, equipment, accessories, and services.'),
(2, 'Adidas', 'German multinational corporation, founded and headquartered in Herzogenaurach, Germany, that designs and manufactures shoes, clothing, and accessories.'),
(3, 'Puma', 'German multinational corporation that designs and manufactures athletic and casual footwear, apparel and accessories, which is headquartered in Herzogenaurach, Bavaria, Germany.'),
(4, 'Reebok', 'American-inspired global brand with a deep fitness heritage and a clear mission: To be the best fitness brand in the world.')
AS new_brands ON DUPLICATE KEY UPDATE Brand_Name = new_brands.Brand_Name, Brand_Description = new_brands.Brand_Description;

/* Insert example data into Size table */
INSERT INTO Sizes (Size_ID, Size_Value) VALUES
(1, 36),
(2, 37),
(3, 38),
(4, 39),
(5, 40),
(6, 41),
(7, 42),
(8, 43),
(9, 44),
(10, 45)
AS new_sizes ON DUPLICATE KEY UPDATE Size_Value = new_sizes.Size_Value;

/* Ensure all Brands are inserted before referencing them in the Sneakers table */
INSERT INTO Sneakers (Brand_ID, Sneaker_Model, Sneaker_Price, Sneaker_Stock, Sneaker_Description, Sneaker_ImageURL) VALUES 
(1, 'Air Force 1', 100.00, 50, 'Classic basketball shoes', 'http://metroglide_version_laravel_10.test/assets/img/sneakers/air-force-one-removebg.webp'),
(1, 'Air Max 90', 120.00, 30, 'Iconic running shoes', 'http://metroglide_version_laravel_10.test/assets/img/sneakers/air-max-90-removebg.webp'),
(2, 'Superstar', 80.00, 40, 'Classic shell-toe shoes', 'http://metroglide_version_laravel_10.test/assets/img/sneakers/superstar-removebg.webp'),
(2, 'Ultraboost', 180.00, 20, 'High-performance running shoes', 'http://metroglide_version_laravel_10.test/assets/img/sneakers/ultraboost-removebg.webp'),
(1, 'Jordan 4 Retro Military Blue', 400.00, 10, 'Retro basketball shoes', 'http://metroglide_version_laravel_10.test/assets/img/sneakers/military-blue-removebg.webp'),
(2, 'Response CL Bad Bunny Paso Fino', 160.00, 15, 'Collaboration with Bad Bunny', 'http://metroglide_version_laravel_10.test/assets/img/sneakers/paso-fino-removebg.webp'),
(3, 'RS-X3 Puzzle', 110.00, 25, 'Chunky sneakers', 'http://metroglide_version_laravel_10.test/assets/img/sneakers/rs-x3-removebg.webp'),
(4, 'Classic Leather', 75.00, 35, 'Classic running shoes', 'http://metroglide_version_laravel_10.test/assets/img/sneakers/classic-leather-removebg.webp'),
(3, 'Future Rider Twofold', 90.00, 30, 'Retro running shoes', 'http://metroglide_version_laravel_10.test/assets/img/sneakers/future-rider-removebg.webp')
AS new_sneakers ON DUPLICATE KEY UPDATE Brand_ID = new_sneakers.Brand_ID, Sneaker_Model = new_sneakers.Sneaker_Model, Sneaker_Price = new_sneakers.Sneaker_Price, Sneaker_Stock = new_sneakers.Sneaker_Stock, Sneaker_Description = new_sneakers.Sneaker_Description, Sneaker_ImageURL = new_sneakers.Sneaker_ImageURL;

/* Insert example data into User table */
INSERT INTO Users (User_ID, User_Email, User_Password, User_Role) VALUES
(1, 'admin@example.com', '12345678', 'admin'),
(2, 'user@example.com', '12345678', 'user')
AS new_users ON DUPLICATE KEY UPDATE User_Email = new_users.User_Email, User_Password = new_users.User_Password, User_Role = new_users.User_Role;

/* Insert example data into Sneaker_Size table */
INSERT INTO Sneaker_Sizes (Sneaker_ID, Size_ID) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(4, 8),
(4, 9),
(4, 10)
AS new_sneaker_sizes ON DUPLICATE KEY UPDATE Sneaker_ID = new_sneaker_sizes.Sneaker_ID, Size_ID = new_sneaker_sizes.Size_ID;