
CREATE TABLE `elgg_imhomedev_hra_basicinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shn_userid` int(11) NOT NULL,
  `guid` int(11) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `token` varchar(45) DEFAULT NULL,
  `uuid` varchar(45) DEFAULT NULL,
  `age` tinyint(4) DEFAULT NULL,
  `height` varchar(6) DEFAULT NULL,
  `weight` varchar(6) DEFAULT NULL,
  `ethnicity` varchar(10) DEFAULT NULL,
  `waist` varchar(10) DEFAULT NULL,
  `livingarea` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `guid_UNIQUE` (`guid`)
) ENGINE=InnoDB AUTO_INCREMENT DEFAULT CHARSET=latin1;


CREATE TABLE `elgg_imhomedev_hra_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `desc` varchar(45) DEFAULT NULL,
  `uuid` varchar(45) DEFAULT NULL,
  `score` varchar(45) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT DEFAULT CHARSET=latin1;



CREATE TABLE `elgg_imhomedev_hra_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `desc` varchar(200) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '0' COMMENT '0 - both gender / 1 - only male / 2- only female',
  `main` int(11) DEFAULT NULL COMMENT '0 - main\\\\n1 - sub == need main\\\\n',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT DEFAULT CHARSET=latin1;


CREATE TABLE `elgg_imhomedev_hra_stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` int(11) DEFAULT NULL,
  `hra_id` int(11) DEFAULT NULL,
  `date` varchar(45) DEFAULT NULL,
  `score` varchar(45) DEFAULT NULL,
  `done` tinyint(4) DEFAULT '0',
  `bmi` int(11) DEFAULT NULL,
  `bmr` varchar(45) DEFAULT NULL,
  `diet_plan` varchar(45) DEFAULT NULL,
  `calories_goal` int(11) DEFAULT NULL,
  `strength_level` varchar(45) DEFAULT NULL,
  `fitness_classification_level` varchar(45) DEFAULT NULL,
  `vo2_max` varchar(45) DEFAULT NULL,
  `aerobic_capacity` varchar(45) DEFAULT NULL,
  `answerlists` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT DEFAULT CHARSET=latin1;

