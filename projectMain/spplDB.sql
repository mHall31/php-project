create table `spplUsers` (
    `userId` int AUTO_INCREMENT NOT NULL primary key
    , `username` varchar(30)
    , `password` varchar(255)
    , `adminPriv` char(1)
    , `firstName` varchar(20)
    ,`lastName` varchar(25)
    , `email` varchar(150)
);

create table `spplPatrons` (
    `Id` int AUTO_INCREMENT NOT NULL primary key
    , `firstName` varchar(20)
    , `lastName` varchar(25)
    , `sex` char(1)
    , `birthdate` date
    , `schoolAttending` varchar(5)
    , `grade` int
    , `city` varchar(5)
    , `phoneNumber` varchar(15)
    , `email` varchar(150)
);

create table `spplPrograms`(
    `Id` int AUTO_INCREMENT not null primary key
    , `name` varchar(50)
    , `startDate` date
    , `maxCapacity` int
    , `typeID` int
);

create table `programTypes` (
    `Id` int AUTO_INCREMENT not null primary key
    , `title` varchar(30)
    , `description` varchar(255)
);

create table `patronProgramAttendance` (
    `programId` int
    , `patronId` int
    , `attended` char(1)
    
);
