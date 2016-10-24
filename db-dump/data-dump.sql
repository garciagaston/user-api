CREATE DATABASE olx;

USE olx;

CREATE TABLE IF NOT EXISTS users (
    `id` int(11) NOT NULL PRIMARY KEY auto_increment,
	`name` varchar(100) NOT NULL,
	`picture` varchar(200),
	`address` text
) COLLATE='latin1_general_ci' ENGINE=InnoDB;