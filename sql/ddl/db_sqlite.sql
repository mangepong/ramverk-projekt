--
-- Table User
--
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "acronym" TEXT UNIQUE NOT NULL,
    "password" TEXT,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "email" VARCHAR(100)
);

--
-- Table TagQuestion
--
DROP TABLE IF EXISTS TagQuestion;
CREATE TABLE TagQuestion (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "text" TEXT,
    "questionid" INTEGER
);

--
-- Table Question
--
DROP TABLE IF EXISTS Question;
CREATE TABLE Question (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userId" INTEGER NOT NULL,
    "title" TEXT,
    "text" TEXT,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

--
-- Table Comment
--
DROP TABLE IF EXISTS Comment;
CREATE TABLE Comment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userId" INTEGER NOT NULL,
    "text" TEXT,
    "questionid" INTEGER,
    "answerid" INTEGER
);

--
-- Table Answer
--
DROP TABLE IF EXISTS Answer;
CREATE TABLE Answer (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userId" INTEGER NOT NULL,
    "text" TEXT NOT NULL,
    "questionid" INTEGER
);