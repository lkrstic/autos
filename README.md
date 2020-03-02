# autos
This is a simple "Automobile Tracking" application demonstrating CRUD.
The user can log in, view, edit, and delete saved automobiles, as well as add their own.

It assumes the following queries have been run beforehand in a local MySQL database, and at least one user exists:

CREATE DATABASE auto;

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
