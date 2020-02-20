INSERT INTO `accounts`
	( `first_name`,`last_name`,`username`, `password`, `email`)
VALUES 
	("Admin", "Administrator",'Test', 'passw3x2', 'NotAnEmail@dal.ca');
INSERT INTO `accounts`
	( `first_name`,`last_name`,`username`, `password`, `email`, `admin`)
VALUES 
	("Bat", "Man",'admin', 'passw3x2', 'NotAnEmail@dal.ca', true);
    
INSERT INTO `books`( `book_name`, `book_author`, `api_id`)
VALUES ("Harry Potter", "JK Rowling", "2qenqw8dhbqwne")