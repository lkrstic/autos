# autos
This is a simple "Automobile Tracking" application.
The user can log in, view saved automobiles, and add their own.

It assumes the following queries have been run beforehand in a MySQL database, and at least one user exists:

CREATE TABLE autos (
    autoID INTEGER UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    make VARCHAR(128),
    model VARCHAR(128),
    year INTEGER,
    mileage INTEGER
);


CREATE TABLE users (
    userID INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(128),
    name VARCHAR(128),
    password VARCHAR(128)
);
