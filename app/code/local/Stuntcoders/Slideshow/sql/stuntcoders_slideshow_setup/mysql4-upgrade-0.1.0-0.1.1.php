<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    ALTER TABLE {$this->getTable('stuntcoders_slideshow/slideshow')}
    ADD COLUMN `config` varchar(255) NOT NULL AFTER `is_enabled`;
");

$installer->endSetup();
