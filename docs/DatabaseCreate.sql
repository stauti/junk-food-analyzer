CREATE DATABASE junkFoodAnalyzer;

USE junkFoodAnalyzer;

ALTER DATABASE `junkFoodAnalyzer` 
DEFAULT CHARACTER SET utf8 
DEFAULT COLLATE utf8_general_ci;

CREATE TABLE User(
  UserID INT NOT NULL,
  Name VARCHAR(25),
  Password VARCHAR(30),
  isAdmin BIT DEFAULT FALSE,
  PRIMARY KEY (UserID)
);

CREATE TABLE Junkfood(
  JunkfoodID INT NOT NULL ,
  UserID INT NULL ,
  JFName VARCHAR(50) NOT NULL ,
  JFArt INT NOT NULL ,
  JFKcal INT NOT NULL ,
  isVeggie BIT DEFAULT FALSE ,
  PRIMARY KEY (JunkfoodID)
);

CREATE TABLE JunkfoodArt(
  JFArtID INT NOT NULL ,
  JFArt VARCHAR(25) ,
  PRIMARY KEY (JFArt)
);

CREATE TABLE JunkfoodIngredients(
  JunkfoodID INT NOT NULL ,
  IngrID INT NOT NULL ,
  Gramm INT NULL
);

CREATE TABLE Ingredients(
  IngrID INT NOT NULL ,
  IngrName VARCHAR(50) ,
  KcalPer100g INT NOT NULL ,
  isVeggie BIT DEFAULT FALSE ,
  PRIMARY KEY (IngrID)
);