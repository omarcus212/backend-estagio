CREATE TABLE IF NOT EXISTS `company` (
	`id`	integer,
	`name`	VARCHAR(255) NOT NULL UNIQUE,
	`active`	TINYINT NOT NULL,
	PRIMARY KEY(`id`)
);
CREATE TABLE IF NOT EXISTS `admin_user` (
	`id`	integer,
	`company_id`	integer,
	`email`	VARCHAR(255) NOT NULL UNIQUE,
	`name`	VARCHAR(255) NOT NULL,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`company_id`) REFERENCES `company`(`id`)
);
CREATE TABLE IF NOT EXISTS `category` (
	`id`	integer,
	`company_id`	integer,
	`title`	VARCHAR(255) NOT NULL,
	`active`	tinyint NOT NULL,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`company_id`) REFERENCES `company`(`id`)
);
CREATE TABLE IF NOT EXISTS `product` (
	`id`	integer,
	`company_id`	integer NOT NULL,
	`title`	VARCHAR(255) NOT NULL,
	`price`	float,
	`active`	tinyint NOT NULL,
	`created_at`	datetime NOT NULL DEFAULT current_timestamp,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`company_id`) REFERENCES `company`(`id`)
);
CREATE TABLE IF NOT EXISTS `product_category` (
	`id`	integer,
	`cat_id`	integer NOT NULL,
	`product_id`	integer NOT NULL,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`cat_id`) REFERENCES `category`(`id`),
	FOREIGN KEY(`product_id`) REFERENCES `product`(`id`)
);
CREATE TABLE IF NOT EXISTS `product_log` (
	`id`	integer,
	`product_id`	integer NOT NULL,
	`admin_user_id`	integer NOT NULL,
	`action`	VARCHAR(255) NOT NULL,
	`timestamp`	datetime NOT NULL DEFAULT current_timestamp,
	PRIMARY KEY(`id`),
	FOREIGN KEY(`admin_user_id`) REFERENCES `admin_user`(`id`),
	FOREIGN KEY(`product_id`) REFERENCES `product`(`id`)
);
INSERT INTO `company` VALUES (1,'XPTO Ltda.',1);
INSERT INTO `admin_user` VALUES (1,1,'rivers.cuomo@xpto.com','rivers');
INSERT INTO `admin_user` VALUES (2,1,'kim.deal@xpto.com','kim');
INSERT INTO `admin_user` VALUES (3,1,'corin.tucker@xpto.com','corin');
INSERT INTO `admin_user` VALUES (4,1,'jeff.magnum@xpto.com','jeff');
INSERT INTO `category` VALUES (1,NULL,'clothing',1);
INSERT INTO `category` VALUES (2,NULL,'phone',1);
INSERT INTO `category` VALUES (3,NULL,'computer',1);
INSERT INTO `category` VALUES (4,1,'furniture',1);
INSERT INTO `category` VALUES (5,1,'food',1);
INSERT INTO `category` VALUES (6,NULL,'house',1);
INSERT INTO `product` VALUES (1,1,'white shirt',70.5,1,'2023-12-20 21:05:48');
INSERT INTO `product` VALUES (2,1,'blue trouser',68.5,1,'2023-12-20 21:05:48');
INSERT INTO `product` VALUES (3,1,'brown hat',20.7,1,'2023-12-20 21:05:48');
INSERT INTO `product` VALUES (4,1,'iphone 8',18.0,1,'2023-12-20 21:05:48');
INSERT INTO `product` VALUES (5,1,'iphone 10',2790.75,1,'2023-12-20 21:05:48');
INSERT INTO `product` VALUES (6,1,'dell vostro',2450.5,1,'2023-12-20 21:05:48');
INSERT INTO `product` VALUES (7,1,'acer aspire',1804.05,1,'2023-12-20 21:05:48');
INSERT INTO `product` VALUES (8,1,'pink sofa',1396.5,1,'2023-12-20 21:08:27');
INSERT INTO `product` VALUES (9,1,'small wardrobe',680.25,1,'2023-12-20 21:08:27');
INSERT INTO `product` VALUES (10,1,'king size bed',4520.83,1,'2023-12-20 21:08:27');
INSERT INTO `product` VALUES (11,1,'big red couch',2520.83,0,'2023-12-20 21:08:27');
INSERT INTO `product` VALUES (12,1,'chocolate snack',20.0,1,'2023-12-20 21:12:22');
INSERT INTO `product` VALUES (13,1,'honey flavoured cookie',10.21,0,'2023-12-20 21:12:22');
INSERT INTO `product` VALUES (14,1,'strawberry bubblegum',4520.83,1,'2023-12-20 21:12:22');
INSERT INTO `product` VALUES (15,1,'muffin',14.24,1,'2023-12-20 21:12:22');
INSERT INTO `product` VALUES (16,1,'coffee candy',1.8,0,'2023-12-20 21:12:22');
INSERT INTO `product` VALUES (17,1,'air conditioning',2700.0,1,'2023-12-20 21:19:58');
INSERT INTO `product` VALUES (18,1,'refrigerator',680.5,1,'2023-12-21 15:31:45');
INSERT INTO `product_category` VALUES (1,1,1);
INSERT INTO `product_category` VALUES (2,1,2);
INSERT INTO `product_category` VALUES (3,1,3);
INSERT INTO `product_category` VALUES (4,2,4);
INSERT INTO `product_category` VALUES (5,2,5);
INSERT INTO `product_category` VALUES (6,3,6);
INSERT INTO `product_category` VALUES (7,3,7);
INSERT INTO `product_category` VALUES (8,4,8);
INSERT INTO `product_category` VALUES (9,6,8);
INSERT INTO `product_category` VALUES (10,4,9);
INSERT INTO `product_category` VALUES (11,6,9);
INSERT INTO `product_category` VALUES (12,4,10);
INSERT INTO `product_category` VALUES (13,6,10);
INSERT INTO `product_category` VALUES (14,4,11);
INSERT INTO `product_category` VALUES (15,6,11);
INSERT INTO `product_category` VALUES (16,5,12);
INSERT INTO `product_category` VALUES (17,5,13);
INSERT INTO `product_category` VALUES (18,5,14);
INSERT INTO `product_category` VALUES (19,5,15);
INSERT INTO `product_category` VALUES (20,5,16);
INSERT INTO `product_category` VALUES (21,6,17);
INSERT INTO `product_category` VALUES (22,6,18);
INSERT INTO `product_log` VALUES (1,1,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (2,1,2,'update','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (3,1,3,'update','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (4,11,3,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (5,11,1,'update','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (6,11,4,'delete','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (7,2,2,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (8,3,3,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (9,4,4,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (10,2,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (11,4,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (12,7,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (13,8,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (14,9,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (15,10,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (16,11,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (17,12,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (18,13,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (19,14,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (20,15,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (21,16,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (22,17,1,'create','2023-12-20 21:32:22');
INSERT INTO `product_log` VALUES (23,18,1,'create','2023-12-20 23:49:54');
INSERT INTO `product_log` VALUES (24,18,1,'update','2023-12-20 23:52:58');
INSERT INTO `product_log` VALUES (25,18,1,'update','2023-12-20 23:53:10');
INSERT INTO `product_log` VALUES (26,18,1,'update','2023-12-21 00:03:55');
INSERT INTO `product_log` VALUES (27,18,1,'delete','2023-12-21 00:04:35');
INSERT INTO `product_log` VALUES (28,18,1,'create','2023-12-21 15:31:45');
INSERT INTO `product_log` VALUES (29,4,1,'update','2023-12-22 18:08:12');
INSERT INTO `product_log` VALUES (30,4,3,'update','2023-12-22 18:12:10');
INSERT INTO `product_log` VALUES (31,19,1,'create','2024-01-04 02:44:37');
INSERT INTO `product_log` VALUES (32,19,1,'update','2024-01-04 02:44:53');
INSERT INTO `product_log` VALUES (33,19,1,'delete','2024-01-04 02:45:00');
INSERT INTO `product_log` VALUES (34,19,1,'delete','2024-01-05 15:46:42');

