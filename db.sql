CREATE DATABASE IF NOT EXISTS events_db;
USE events_db;

-- Events Table
CREATE TABLE IF NOT EXISTS events (
    evCode INT PRIMARY KEY AUTO_INCREMENT,
    evName VARCHAR(100),
    evDate DATE,
    evVenue VARCHAR(100),
    evRFee DECIMAL(10,2)
);

-- Participants Table
CREATE TABLE IF NOT EXISTS participants (
    partID INT PRIMARY KEY AUTO_INCREMENT,
    evCode INT,
    partFName VARCHAR(100),
    partLName VARCHAR(100),
    partDRate DECIMAL(10,2),
    FOREIGN KEY (evCode) REFERENCES events(evCode) ON DELETE SET NULL ON UPDATE CASCADE
);

-- Registration Table
-- Registration Table
CREATE TABLE IF NOT EXISTS registration (
    regCode INT PRIMARY KEY AUTO_INCREMENT,
    partID INT,
    evCode INT,
    regDate DATE,
    regFeePaid DECIMAL(10,2),
    regPMode VARCHAR(20),
    FOREIGN KEY (partID) REFERENCES participants(partID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (evCode) REFERENCES events(evCode) ON DELETE SET NULL ON UPDATE CASCADE
);