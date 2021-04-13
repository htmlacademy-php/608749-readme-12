CREATE DATABASE readme
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE readme;

CREATE TABLE user
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    registration TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email        VARCHAR(128) NOT NULL UNIQUE,
    login        VARCHAR(128) NOT NULL UNIQUE,
    password     CHAR(64)     NOT NULL,
    avatar       TEXT
);

CREATE TABLE post
(
    id              INT AUTO_INCREMENT PRIMARY KEY,
    date            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title           TEXT NOT NULL,
    content         TEXT,
    cite_author     VARCHAR(128),
    picture         TEXT,
    video           TEXT,
    link            TEXT,
    views           INT,
    user_id         INT  NOT NULL,
    content_type_id INT
);

CREATE TABLE post_hashtag
(
    post_id    INT NOT NULL,
    hashtag_id INT NOT NULL
);

CREATE TABLE post_like
(
    user_id INT NOT NULL,
    post_id INT NOT NULL
);

CREATE TABLE subscription
(
    user_id      INT NOT NULL,
    recipient_id INT NOT NULL
);

CREATE TABLE comment
(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    date    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    content TEXT NOT NULL,
    user_id INT  NOT NULL,
    post_id INT  NOT NULL
);

CREATE TABLE message
(
    id           INT AUTO_INCREMENT PRIMARY KEY,
    date         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    message      TEXT NOT NULL,
    user_id      INT  NOT NULL,
    recipient_id INT  NOT NULL
);

CREATE TABLE hashtag
(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    hashtag VARCHAR(32) NOT NULL UNIQUE
);

CREATE TABLE content_type
(
    id   INT AUTO_INCREMENT PRIMARY KEY,
    type CHAR NOT NULL UNIQUE,
    icon CHAR
);
