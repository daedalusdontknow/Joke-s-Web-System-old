# Please don´t use this Version, there are Bugs, i need to fix, wait for release on 03.04.22, thanks

# Joke-s-Web-System


How to Set up:

Go to your database on sql commands and paste this code:


CREATE TABLE IF NOT EXISTS `tickets` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL,
	`msg` text NOT NULL,
	`email` varchar(255) NOT NULL,
    `username` varchar(50) NOT NULL,
	`created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`status` enum('open','closed','resolved') NOT NULL DEFAULT 'open',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `tickets` (`id`, `title`, `msg`, `email`, `username`, `created`, `status`) VALUES (1, 'Test Ticket', 'This is first ticket.', 'daedalusdontknow@gmx.de', 'TestUser', '2022-03-17 19:51:17', 'open');

CREATE TABLE IF NOT EXISTS `tickets_comments` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`ticket_id` int(11) NOT NULL,
	`msg` text NOT NULL,
    `username` varchar(50) NOT NULL,
	`created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `tickets_comments` (`id`, `ticket_id`, `msg`, `username`, `created`) VALUES (1, 1, 'This is a test comment.', 'TestUser', '2022-03-17 19:52:21');

CREATE TABLE IF NOT EXISTS `accounts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  	`username` varchar(50) NOT NULL,
  	`password` varchar(255) NOT NULL,
  	`email` varchar(100) NOT NULL,
	`role` int(11) NOT NULL DEFAULT 0,
	`created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


After this go to the file db.php:

Change DATABASE_HOST to the ip your database is running or just keep it as Localhost if your DB is running on the same server as the Web server

Change DATABASE_USER to the User Joke should use

Change DATABASE_PASS to the password for the DATABASE_USER

Change DATABASE_NAME to the DB name you executed the sql command in.

Now, just registrate, and have fun with Joke's Web System

-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

Here Some screenshots of Version 1 (May not be updatet)


![image](https://user-images.githubusercontent.com/101858241/159173668-bf301c54-0f00-4968-8262-15199441bb6f.png)
![image](https://user-images.githubusercontent.com/101858241/159173682-7e8a8006-8979-417a-8d26-a68f55d887da.png)
![image](https://user-images.githubusercontent.com/101858241/159173697-917b4c1b-52fa-4902-a460-5e0714fdbd16.png)
![image](https://user-images.githubusercontent.com/101858241/159341693-b17aaba5-8a5f-433e-ac4f-b9c0262ac600.png)
![image](https://user-images.githubusercontent.com/101858241/159173832-e698a237-1ac7-4473-876b-bdf837b35c9f.png)


See updates.txt to see what is planned
I Love <3 Joke <3
