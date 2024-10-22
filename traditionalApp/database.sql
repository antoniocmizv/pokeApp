create database productdatabase
    default character set utf8
    collate utf8_unicode_ci;

use productdatabase;

CREATE TABLE pokemon (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  type VARCHAR(50) NOT NULL,
  ability VARCHAR(100),
  hp INT,
  attack INT,
  defense INT
);

create user productuser@localhost
    identified by 'productpassword';

grant all
    on productdatabase.*
    to productuser@localhost;

flush privileges;