-- User Account Tables
CREATE TABLE IF NOT EXISTS `accounts` (
    `user_id` INT(11) NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(50) NOT NULL,
    `last_name` VARCHAR(50) NOT NULL,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `admin` BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (`user_id`)
);

-- Order Table
CREATE TABLE IF NOT EXISTS `orders` (
    `order_id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `order_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `num_item` INT(11) NOT NULL,
    FOREIGN KEY (`user_id`)
        REFERENCES accounts (`user_id`),
    PRIMARY KEY (`order_id`)
);

-- Book Table
CREATE TABLE IF NOT EXISTS `books`(
    `book_id` INT(11) NOT NULL AUTO_INCREMENT,
    `book_name` VARCHAR(50) NOT NULL, 
    `book_author` VARCHAR(50) NOT NULL,
    `api_id` VARCHAR(50) NOT NULL UNIQUE,
    PRIMARY KEY (`book_id`)
);

-- Cart Table
CREATE TABLE IF NOT EXISTS `cart`(
    `user_id` INT (11) NOT NULL,
    `book_id` INT (11) NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES accounts(`user_id`),
    FOREIGN KEY(`book_id`) REFERENCES books(`book_id`)
);

-- Sold Books
CREATE TABLE IF NOT EXISTS `sold_books` (
    `order_id` INT(11) NOT NULL,
    `book_id` INT(11) NOT NULL,
    FOREIGN KEY (`order_id`)
        REFERENCES orders (`order_id`),
    FOREIGN KEY (`book_id`)
        REFERENCES books (`book_id`)
);
-- Shipping Information Table
CREATE TABLE IF NOT EXISTS `shipping_information` (
    `user_id` INT(11) NOT NULL,
    `order_id` INT(11) NOT NULL,
    `number_items` INT(11) NOT NULL,
    `shipping_address` VARCHAR(255) NOT NULL,
    FOREIGN KEY (`user_id`)
        REFERENCES accounts (`user_id`),
    FOREIGN KEY (`order_id`)
        REFERENCES orders (`order_id`)
);