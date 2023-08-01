CREATE TABLE users
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password) VALUES ('admin', 'test');

CREATE TABLE news
(
    id       INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50)  NOT NULL,
    description VARCHAR(255) NOT NULL
);