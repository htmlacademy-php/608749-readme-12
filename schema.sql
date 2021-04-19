DROP DATABASE IF EXISTS readme;

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
    password     VARCHAR(64)     NOT NULL,
    avatar       VARCHAR(256)
);

CREATE TABLE post
(
    id              INT AUTO_INCREMENT PRIMARY KEY,
    date            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    title           VARCHAR(256) NOT NULL,
    content         TEXT,
    cite_author     VARCHAR(128),
    picture         VARCHAR(256),
    video           VARCHAR(256),
    link            VARCHAR(256),
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
    type VARCHAR(32) NOT NULL UNIQUE,
    icon VARCHAR(32)
);
