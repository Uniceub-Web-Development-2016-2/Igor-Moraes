CREATE TABLE IF NOT EXISTS `#__restful_resources` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`state` TINYINT(1)  NOT NULL ,
`table` VARCHAR(255)  NOT NULL ,
`privileges` VARCHAR(255)  NOT NULL ,
`columns` VARCHAR(255)  NOT NULL ,
`model_schema` TEXT NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__restful_external_senders` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`state` TINYINT(1)  NOT NULL ,
`url` VARCHAR(255)  NOT NULL ,
`route` VARCHAR(255)  NOT NULL ,
`table` VARCHAR(255)  NOT NULL ,
`model_schema_relationship` VARCHAR(255)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__restful_extsender_logs` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`resource` VARCHAR(255)  NOT NULL ,
`id_resource_element` int(11) UNSIGNED NOT NULL,
`change_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`method` VARCHAR(255)  NOT NULL ,
`request_sent` TINYINT(1)  NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__restful_keys` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',

`state` TINYINT(1)  NOT NULL ,
`key` VARCHAR(255)  NOT NULL ,
`user_id` INT(11)  NOT NULL ,
`daily_requests` INT(11)  NOT NULL ,
`expiration_date` DATE NOT NULL DEFAULT '0000-00-00',
`comment` TEXT NOT NULL ,
`hits` INT(11)  NOT NULL ,
`last_visit` DATETIME NOT NULL DEFAULT '0000-00-00',
`current_day` DATETIME NOT NULL DEFAULT '0000-00-00',
`current_hits` INT(11)  NOT NULL ,
`ordering` INT(11)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT COLLATE=utf8mb4_unicode_ci;


INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Resource (WS)','com_restful.resource','{"special":{"dbtable":"#__restful_resources","key":"id","type":"Resource","prefix":"RestfulTable"}}', '{"formFile":"administrator\/components\/com_restful\/models\/forms\/resource.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"model_schema"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_restful.resource')
) LIMIT 1;

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'External Sender','com_restful.externalsender','{"special":{"dbtable":"#__restful_external_senders","key":"id","type":"Externalsender","prefix":"RestfulTable"}}', '{"formFile":"administrator\/components\/com_restful\/models\/forms\/externalsender.xml", "hideFields":["checked_out","checked_out_time","params","language"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_restful.externalsender')
) LIMIT 1;

INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Key','com_restful.key','{"special":{"dbtable":"#__restful_keys","key":"id","type":"Key","prefix":"RestfulTable"}}', '{"formFile":"administrator\/components\/com_restful\/models\/forms\/key.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"comment"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_restful.key')
) LIMIT 1;
