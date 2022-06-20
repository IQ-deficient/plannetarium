CREATE TABLE `users` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `type` int NOT NULL
);

CREATE TABLE `usertype` (
  `id` int PRIMARY KEY,
  `name` varchar(32)
);

CREATE TABLE `projects` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `title` varchar(32),
  `status` smallint
);

CREATE TABLE `tasks` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(32),
  `description` varchar(300),
  `time` date,
  `projectsID` int(11),
  `userId` int(11),
  `status` smallint
);

CREATE TABLE `tasks_comments` (
  `id` int PRIMARY KEY,
  `tasksId` int,
  `commentsId` int
);

CREATE TABLE `comments` (
  `id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `text` varchar(255)
);

CREATE TABLE `statustype` (
  `id` smallint PRIMARY KEY,
  `name` varchar(32)
);

ALTER TABLE `users` ADD FOREIGN KEY (`type`) REFERENCES `usertype` (`id`);

ALTER TABLE `tasks` ADD FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

ALTER TABLE `tasks` ADD FOREIGN KEY (`projectsID`) REFERENCES `projects` (`id`);

ALTER TABLE `tasks` ADD FOREIGN KEY (`status`) REFERENCES `statustype` (`id`);

ALTER TABLE `projects` ADD FOREIGN KEY (`status`) REFERENCES `statustype` (`id`);

ALTER TABLE `tasks_comments` ADD FOREIGN KEY (`commentsId`) REFERENCES `comments` (`id`);

ALTER TABLE `tasks_comments` ADD FOREIGN KEY (`tasksId`) REFERENCES `tasks` (`id`);
