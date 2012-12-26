CREATE TABLE IF NOT EXISTS `prefix_topicup_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `date_up` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `prefix_topicup_data`
  ADD CONSTRAINT `prefix_topicup_data_fk0` FOREIGN KEY (`topic_id`) REFERENCES `prefix_topic` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prefix_topicup_data_fk3` FOREIGN KEY (`user_id`) REFERENCES `prefix_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `prefix_topic` ADD `topic_date_up`  DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL;
update `prefix_topic` set `topic_date_up`=`topic_date_add`;
