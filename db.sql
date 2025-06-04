CREATE database events_db
-- Participants Table
CREATE TABLE participants (
    partID INT PRIMARY KEY AUTO_INCREMENT,
    evCode INT,
    partFName VARCHAR(100),
    partLName VARCHAR(100),
    partDRate DECIMAL(10,2)
);

-- Events Table
CREATE TABLE events (
    evCode INT PRIMARY KEY AUTO_INCREMENT,
    evName VARCHAR(100),
    evDate DATE,
    evVenue VARCHAR(100),
    evRFee DECIMAL(10,2)
);

-- Registration Table
CREATE TABLE registration (
    regCode INT PRIMARY KEY AUTO_INCREMENT,
    partID INT,
    regDate DATE,
    regFeePaid DECIMAL(10,2),
    regPMode VARCHAR(20)
);