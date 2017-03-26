<?php
/** @var Mage_Core_Model_Resource_Setup $this */

$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('stuntcoders_slideshow/slideshow'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ))->addColumn('code', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array())
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, null, array())
    ->addColumn('config', Varien_Db_Ddl_Table::TYPE_TEXT, null, array())
    ->addColumn('is_enabled', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null);

$table->addIndex(
    $this->getIdxName('stuntcoders_slideshow/slideshow', array('code'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
    array('code'),
    Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
);

$this->getConnection()->createTable($table);

$table = $this->getConnection()
    ->newTable($this->getTable('stuntcoders_slideshow/slideshow_image'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
    ))->addColumn('slideshow_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array())
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_TEXT, null, array())
    ->addColumn('is_enabled', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null);

$this->getConnection()->createTable($table);
$this->endSetup();
