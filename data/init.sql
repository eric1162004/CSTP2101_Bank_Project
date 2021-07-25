DROP DATABASE IF EXISTS Bank;

CREATE DATABASE Bank;

USE Bank;

CREATE TABLE Customer (
    customerID INT NOT NULL AUTO_INCREMENT,
    firstName VARCHAR(30) DEFAULT '',
    lastName VARCHAR(30) DEFAULT '',
    income DOUBLE DEFAULT 0.00,
    birthDate DATE,
    PRIMARY KEY (customerID)
);

CREATE TABLE Employee (
    sin CHAR(9) NOT NULL, 
    firstName VARCHAR(30) NOT NULL,
    lastName VARCHAR(30) NOT NULL,
    salary DOUBLE DEFAULT 0.00,
    branchNumber INT, 
    PRIMARY KEY (sin)
);

CREATE TABLE Branch (
    branchNumber INT NOT NULL AUTO_INCREMENT,
    branchName VARCHAR(30) NOT NULL,
    managerSIN CHAR(9),
    budget DOUBLE DEFAULT 0.00,
    PRIMARY KEY (branchNumber),
    FOREIGN KEY (managerSIN) REFERENCES Employee (sin)
);

ALTER TABLE Employee
ADD FOREIGN KEY (branchNumber) REFERENCES Branch(branchNumber);

CREATE TABLE Account (
    accNumber INT NOT NULL AUTO_INCREMENT,
    type ENUM('chequing','saving','business'), 
    balance DOUBLE DEFAULT 0.00,
    branchNumber INT,
    PRIMARY KEY (accNumber),
    FOREIGN KEY (branchNumber) REFERENCES Branch (branchNumber)
);

CREATE TABLE Owns (
    customerID INT,
    accNumber INT,
    PRIMARY KEY (customerID, accNumber),
    FOREIGN KEY (customerID) REFERENCES Customer (customerID),
    FOREIGN KEY (accNumber) REFERENCES Account (accNumber)
);

CREATE TABLE Transactions (
    transNumber INT NOT NULL AUTO_INCREMENT,
    accNumber INT,
    amount DOUBLE DEFAULT 0.00,
    PRIMARY KEY (transNumber, accNumber),
    FOREIGN KEY (accNumber) REFERENCES Account (accNumber)
);



