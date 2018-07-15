/*创建数据库*/
CREATE DATABASE newsreport;

/*择库*/
USE newsreport;

/*创建管理员用户表*/
CREATE TABLE `admin`(
	`id` tinyint(3) NOT NULL AUTO_INCREMENT,
	`username` varchar(20) NOT NULL,
	`password` varchar(40) NOT NULL,
	`email` varchar(30) NOT NULL,
	PRIMARY KEY(`id`),
	UNIQUE KEY `username`(`username`)
)ENGINE=INNODB DEFAULT CHARSET=UTF8;

/*插入1条管理员记录*/
INSERT INTO `admin`(username, password, email) VALUES("news_admin", md5("admin123"), "1234@qq.com");

/*创建news表*/
CREATE TABLE `news`(
	`id` int(11) NOT NULL PRIMARY KEY auto_increment,
	`title` char(100) NOT NULL,
	`author` char(50) not null ,
	`from` varchar(255) not null,
	`content` text not null,
	`dateline` int(11) not null default 0
)ENGINE=INNODB DEFAULT CHARSET=UTF8;