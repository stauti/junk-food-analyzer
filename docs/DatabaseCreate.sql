CREATE DATABASE junkFoodAnalyzer;

USE junkFoodAnalyzer;

ALTER DATABASE `junkFoodAnalyzer` 
DEFAULT CHARACTER SET utf8 
DEFAULT COLLATE utf8_general_ci;

CREATE TABLE user(
  userID INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(25),
  password VARCHAR(30),
  isAdmin BIT DEFAULT FALSE,
  PRIMARY KEY (userID)
);

CREATE TABLE junkfoodArt(
  artID INT NOT NULL AUTO_INCREMENT,
  art VARCHAR(25) ,
  PRIMARY KEY (artID)
);

CREATE TABLE ingredients(
  ingrID INT NOT NULL AUTO_INCREMENT,
  ingrName VARCHAR(50) ,
  kcalPer100g INT NOT NULL ,
  isVeggie BIT DEFAULT FALSE ,
  PRIMARY KEY (ingrID)
);

CREATE TABLE junkfood(
  junkfoodID INT NOT NULL AUTO_INCREMENT,
  userID INT NULL ,
  name VARCHAR(50) NOT NULL ,
  imgPath VARCHAR(60) NULL ,
  art INT NOT NULL ,
  kcal INT NOT NULL ,
  isVeggie BIT DEFAULT FALSE ,
  PRIMARY KEY (junkfoodID) ,
  FOREIGN KEY (userID)
    REFERENCES user(userID) , 
  FOREIGN KEY (art)
    REFERENCES junkfoodArt(artID)
);

CREATE TABLE junkfoodIngredients(
  junkfoodID INT NOT NULL ,
  ingrID INT NOT NULL ,
  gramm INT NULL ,
  FOREIGN KEY (junkfoodID)
	REFERENCES junkfood(junkfoodID) ,
  FOREIGN KEY (ingrID)
	REFERENCES ingredients(ingrID)  
);
