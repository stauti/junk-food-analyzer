CREATE DATABASE junkFoodAnalyzer;

USE junkFoodAnalyzer;

ALTER DATABASE `junkFoodAnalyzer` 
DEFAULT CHARACTER SET utf8 
DEFAULT COLLATE utf8_general_ci;

CREATE TABLE user(
  userID INT NOT NULL,
  name VARCHAR(25),
  password VARCHAR(30),
  isAdmin BIT DEFAULT FALSE,
  PRIMARY KEY (userID)
);

CREATE TABLE junkfood(
  junkfoodID INT NOT NULL ,
  userID INT NULL ,
  name VARCHAR(50) NOT NULL ,
  imgPath VARCHAR(60) NULL ,
  art INT NOT NULL ,
  kcal INT NOT NULL ,
  isVeggie BIT DEFAULT FALSE ,
  PRIMARY KEY (junkfoodID)
);

CREATE TABLE junkfoodArt(
  artID INT NOT NULL ,
  art VARCHAR(25) ,
  PRIMARY KEY (artID)
);

CREATE TABLE junkfoodIngredients(
  junkfoodID INT NOT NULL ,
  ingrID INT NOT NULL ,
  gramm INT NULL
);

CREATE TABLE ingredients(
  ingrID INT NOT NULL ,
  ingrName VARCHAR(50) ,
  kcalPer100g INT NOT NULL ,
  isVeggie BIT DEFAULT FALSE ,
  PRIMARY KEY (ingrID)
);