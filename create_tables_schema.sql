-- Create Tables
CREATE TABLE City(
	city_name varchar(50) NOT NULL,
    state varchar(50) NOT NULL,
    population int NOT NULL,
    PRIMARY KEY (city_name, state)
);

CREATE TABLE Store (
	store_ID int NOT NULL,
    phone_number varchar(50) NOT NULL,
    street_address varchar(100) NOT NULL,
    city_name varchar(50) NOT NULL,
    state varchar(50) NOT NULL,
    PRIMARY KEY (store_ID),
    FOREIGN KEY (city_name, state) REFERENCES City (city_name, state)
);

CREATE TABLE Date (
    date date NOT NULL,
    PRIMARY KEY (date)
);

CREATE TABLE Holiday (
    date date NOT NULL,
    holiday_name varchar(50) NOT NULL,
    PRIMARY KEY (date),
    FOREIGN KEY (date) REFERENCES Date (date)
);

CREATE TABLE Membership (
    member_ID int NOT NULL,
    membership_type varchar(20) NOT NULL,
    date date NOT NULL,
    store_ID int NOT NULL,
    PRIMARY KEY (member_ID),
    FOREIGN KEY (store_ID) REFERENCES Store (store_ID),
    FOREIGN KEY (date) REFERENCES Date (date)
);

CREATE TABLE Manufacturer (
    manufacturer_name varchar(50) NOT NULL,
    maximum_discount double NULL,
    PRIMARY KEY (manufacturer_name)
);

CREATE TABLE Product (
	PID int NOT NULL,
    product_name varchar(50) NOT NULL,
    manufacturer_name varchar(50) NOT NULL,
    retail_price double NOT NULL,
    PRIMARY KEY (PID),
    FOREIGN KEY (manufacturer_name) REFERENCES Manufacturer (manufacturer_name)
    );

CREATE TABLE Sell (
	store_ID int NOT NULL,
    PID int NOT NULL,
    date date NOT NULL,
    quantity int NOT NULL,
    PRIMARY KEY (PID, store_ID, date),
    FOREIGN KEY (PID) REFERENCES Product (PID),
    FOREIGN KEY (store_ID) REFERENCES Store (store_ID),
    FOREIGN KEY (date) REFERENCES Date (date)
    );
    
    
CREATE TABLE OnSale (
	PID int NOT NULL,
    date date NOT NULL,
    discount double NOT NULL,
    PRIMARY KEY (PID, date),
    FOREIGN KEY (PID) REFERENCES Product (PID),
    FOREIGN KEY (date) REFERENCES Date (date)
);

CREATE TABLE Category (
	category_name varchar(50) NOT NULL,
    PRIMARY KEY(category_name)
);

CREATE TABLE ProductBelongsToCategory (
	PID int NOT NULL,
    category_name varchar(50) NOT NULL,
    UNIQUE(PID, category_name),
    FOREIGN KEY (PID) REFERENCES Product (PID),
    FOREIGN KEY (category_name) REFERENCES Category(category_name)
);

