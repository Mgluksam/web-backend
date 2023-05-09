CREATE TABLE `application` (
  `application_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `born` INT NOT NULL,
  `gender` INT NOT NULL,
  `num_of_limbs` INT NOT NULL,
  `text` VARCHAR(300) NULL DEFAULT NULL,
  PRIMARY KEY (`application_id`)
);

CREATE TABLE `ability` (
  `ab_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`ab_id`)
);

CREATE TABLE `application_ability` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `application_id` INT NOT NULL,
  `ab_id` INT NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    app_id INT,
    login VARCHAR(255),
    password VARCHAR(255),
    password_hash VARCHAR(255),
    FOREIGN KEY (app_id) REFERENCES application(application_id)
);

ALTER TABLE `application_ability` ADD FOREIGN KEY (application_id) REFERENCES `application` (`application_id`);
ALTER TABLE `application_ability` ADD FOREIGN KEY (ab_id) REFERENCES `ability` (`ab_id`);