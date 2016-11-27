DROP TABLE IF EXISTS `#__restful_resources`;
DROP TABLE IF EXISTS `#__restful_external_senders`;
DROP TABLE IF EXISTS `#__restful_extsender_logs`;
DROP TABLE IF EXISTS `#__restful_keys`;

DELETE FROM `#__content_types` WHERE (type_alias LIKE 'com_restful.%');