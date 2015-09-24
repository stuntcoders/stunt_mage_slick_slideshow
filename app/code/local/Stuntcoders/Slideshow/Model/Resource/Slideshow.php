<?php

class Stuntcoders_Slideshow_Model_Resource_Slideshow extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('stuntcoders_slideshow/slideshow', 'id');
    }

    public function getImages($id)
    {
        $select = $this->_getReadAdapter()->select()
            ->from($this->getTable('stuntcoders_slideshow/slideshow_image'))
            ->where('slideshow_id = ?', $id);

        return $this->_getReadAdapter()->fetchAll($select);
    }

    public function getIdByCode($code)
    {
        $adapter = $this->_getReadAdapter();

        $select = $adapter->select()
            ->from($this->getTable('stuntcoders_slideshow/slideshow_image'))
            ->where('code = :code');

        $bind = array(':code' => (string) $code);

        return $adapter->fetchOne($select, $bind);
    }

    protected function _beforeDelete(Mage_Core_Model_Abstract $object)
    {
        $images = $this->getImages($object->getId());

        foreach ($images as $image) {
            $image = Mage::getModel('stuntcoders_slideshow/slideshow_image')->load($image['id']);
            $image->getResource()->delete($image);
        }
    }
}
