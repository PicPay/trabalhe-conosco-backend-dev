-- Table 'customers'
CREATE TABLE `customers` (
    `id` VARCHAR(40) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `username` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`)
)ENGINE=INNODB;


-- Table 'users'
CREATE TABLE `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(200) NOT NULL,
    `senha` CHAR(32) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY (`email`)
)ENGINE=INNODB;

INSERT INTO `users` VALUES (1, 'João Paulo Angeleti de Souza', 'joaopauloangeletisouza@gmail.com', 'e10adc3949ba59abbe56e057f20f883e');
