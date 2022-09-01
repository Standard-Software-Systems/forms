CREATE TABLE siteSettings (
    id INT NOT NULL AUTO_INCREMENT,
    siteName TEXT,
    siteDescription TEXT,
    siteLogo TEXT,
    siteFooter TEXT,
    siteThemeColor TEXT,
    siteBackground TEXT,
    PRIMARY KEY (id)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
CREATE TABLE `users` (
	`discordID` VARCHAR(18) NOT NULL COLLATE 'utf8mb4_general_ci',
	`banned` TINYINT(1) NOT NULL,
	`name` TEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`discriminator` VARCHAR(4) NOT NULL COLLATE 'utf8mb4_general_ci',
	`avatar` TEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`email` TEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	`joinDate` TEXT NOT NULL COLLATE 'utf8mb4_general_ci',
	PRIMARY KEY (`discordID`) USING BTREE,
	UNIQUE INDEX `discordID` (`discordID`) USING BTREE
) COLLATE='utf8mb4_general_ci' ENGINE=InnoDB;
CREATE TABLE forms (
    id TEXT,
    userid TEXT,
    formName TEXT,
    formDescription TEXT,
    date TEXT,
    webhook TEXT
);
CREATE TABLE questions (
	id INT AUTO_INCREMENT,
	formId TEXT,
	question TEXT,
	type BOOLEAN,
	options TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE submissions (
	id TEXT,
	formId TEXT,
	userid TEXT,
	status TEXT,
	replies TEXT
	date TEXT
);
CREATE TABLE answers (
	id INT AUTO_INCREMENT,
	formId TEXT,
	questionId TEXT,
	answer TEXT,
	PRIMARY KEY(id)
);
CREATE TABLE replies (
	id INT AUTO_INCREMENT,
	subId TEXT,
	userid TEXT,
	reply TEXT,
	date TEXT,
	PRIMARY KEY(id)
);
INSERT INTO `sitesettings` (`id`, `siteName`, `siteDescription`, `siteLogo`, `siteThemeColor`, `siteBackground`) VALUES (1, 'Standard Form Builder', 'An easy and free to use form builder for your communties.', 'https://pastenow.xyz/images/standard_logo.png', '#2d7cb5', 'https://store.hyperz.net/assets/bg.jpg');
