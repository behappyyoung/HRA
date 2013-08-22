
DROP TABLE IF EXISTS  `elgg_imhomedev_hra_answers` ;
CREATE TABLE `elgg_imhomedev_hra_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `desc` varchar(45) DEFAULT NULL,
  `uuid` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS  `elgg_imhomedev_hra_basicinfo`  ;
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `guid_UNIQUE` (`guid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS  `elgg_imhomedev_hra_questions`  ;
CREATE TABLE `elgg_imhomedev_hra_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `desc` varchar(200) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '0' COMMENT '0 - main\\n1 - sub == need main\\n',
  `main` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS  `elgg_imhomedev_hra_stat`  ;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;




LOCK TABLES `elgg_imhomedev_hra_questions` WRITE;
/*!40000 ALTER TABLE `elgg_imhomedev_hra_questions` DISABLE KEYS */;
INSERT INTO `elgg_imhomedev_hra_questions` VALUES (1,2,'lifestyle','Eating & Lifestyle Habits','Eating & Lifestyle Habits',0,NULL),(2,6,'lifestyle','physical_activity','Pysical activity / Type of day job',1,2),(3,7,'lifestyle','cardio_exercise_beyond_work','Cardiovascular Exercise beyond the scope of work (brisk walking, jogging, running, swimming laps, aerobic class, bicycling, etc) ',1,2),(4,8,'lifestyle','hard_alcohol','Do you drink more than 1 serving (1.5 ounces of hard alcohol, 5 oz. of wine or 12 ounces of beer) per day?',1,2),(5,9,'lifestyle','teeth_cleaned','How often do you get your teeth cleaned by a hygienist/dentist?',1,2),(6,29,'lifestyle','stress_level','Stress Level',1,2),(7,30,'lifestyle','sleep','Sleep',1,2),(8,31,'lifestyle','smoke','Do you smoke?',1,2),(9,32,'lifestyle','drink_alcohol?','Do you drink alcohol?',1,2);
/*!40000 ALTER TABLE `elgg_imhomedev_hra_questions` ENABLE KEYS */;
UNLOCK TABLES;


LOCK TABLES `elgg_imhomedev_hra_answers` WRITE;
/*!40000 ALTER TABLE `elgg_imhomedev_hra_answers` DISABLE KEYS */;
INSERT INTO `elgg_imhomedev_hra_answers` VALUES (1,6,'select','Sedentary (little or no exercise)','52150a99-e00c-41fd-9dbb-308aac116443'),(2,6,'select','lightly active (exercise/sports 1-3 times/wee','52150a99-17a0-453d-af9d-308aac116443'),(3,6,'select','Moderatetely active (exercise/sports 3-5 time','52150a99-0a10-49c8-b9e0-308aac116443'),(4,6,'select','Very active (hard exercise/sports 6-7 times/w','52150a99-f3e8-47cb-8a11-308aac116443'),(5,6,'select','Extra active (very hard exercise/sports or ph','52150a99-3734-4563-b54e-308aac116443'),(6,8,'select','Yes','52120b8d-26cc-4bec-b94b-2488ac116443'),(7,8,'select','No','52120b8d-4434-4679-a023-2488ac116443'),(8,9,'select','Less than once a year','52120bea-2cfc-4634-8957-2488ac116443'),(9,9,'select','Once a year','52120bea-51d0-4c6d-a910-2488ac116443'),(10,9,'select','Twice a year','52120bea-3d38-4c64-b14c-2488ac116443'),(11,9,'select','Over twice a year','52120bea-2d50-4058-ba54-2488ac116443'),(12,29,'select','Low','52121064-36f4-4ca4-8252-2488ac116443'),(13,29,'select','Medium','52121064-46b0-49ab-bd2a-2488ac116443'),(14,29,'select','High','52121064-2980-4e7d-a214-2488ac116443'),(15,30,'select','6 hours or less','521210a8-12f0-44d0-b8c2-2488ac116443'),(16,30,'select','6-7 hours','521210a8-17bc-4af9-aa8c-2488ac116443'),(17,30,'select','7-8 hours','521210a8-02c0-42e5-b32f-2488ac116443'),(18,30,'select','9+ hours','521210a8-e8b0-4aa6-87d7-2488ac116443'),(19,31,NULL,'Yes','521210c7-376c-4490-9710-2488ac116443'),(20,31,NULL,'No','521210c7-49e4-46d2-a52f-2488ac116443'),(21,32,NULL,'Yes','521210e4-20ec-4a4c-be70-2488ac116443'),(22,32,NULL,'No','521210e4-2f7c-4a56-941d-2488ac116443');
/*!40000 ALTER TABLE `elgg_imhomedev_hra_answers` ENABLE KEYS */;
UNLOCK TABLES;

