<?php

class Stuntcoders_Slideshow_Model_Slideshow extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('stuntcoders_slideshow/slideshow');
    }

    public function getIdByCode($code)
    {
        return $this->_getResource()->getIdByCode($code);
    }

    public function addImages($images)
    {
        if (empty($images)) {
            return;
        }

        $imageModel = Mage::getModel('stuntcoders_slideshow/slideshow_image');
        foreach ($images as $image) {
            $imageModel->setId(null)->setImage($image)->setSlideshowId($this->getId())->setIsEnabled(1)->save();
        }
    }

    protected function _afterLoad()
    {
        parent::_afterLoad();

        $this->setImages($this->_getResource()->getImages($this->getId()));
        return $this;
    }

    protected function _beforeDelete()
    {
        parent::_beforeDelete();

        foreach ($this->getImages() as $image) {
            Mage::getModel('stuntcoders_slideshow/slideshow_image')->setId($image['id'])->delete();
        }
        return $this;
    }
}
