<?php

$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS `{$this->getTable('stuntcoders_slideshow/slideshow')}`;
CREATE TABLE `{$this->getTable('stuntcoders_slideshow/slideshow')}` (
    `id` smallint(6) NOT NULL AUTO_INCREMENT,
    `code` varchar(255) NOT NULL,
    `name` varchar(255) NOT NULL,
    `is_enabled` smallint(6) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `UNIQ_KEY_STUNTCODERS_SLIDESHOW_CODE` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Slideshow instance' ;
");

$installer->run("
DROP TABLE IF EXISTS `{$this->getTable('stuntcoders_slideshow/slideshow_image')}`;
CREATE TABLE `{$this->getTable('stuntcoders_slideshow/slideshow_image')}` (
    `id` smallint(6) NOT NULL AUTO_INCREMENT,
    `slideshow_id` smallint(6) NOT NULL,
    `image` varchar(255) NOT NULL,
    `is_enabled` smallint(6) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Slideshow image instance' ;
");

$installer->endSetup();