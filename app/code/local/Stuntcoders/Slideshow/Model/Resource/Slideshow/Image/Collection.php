<?php

class Stuntcoders_Slideshow_Model_Resource_Slideshow_Image_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('stuntcoders_slideshow/slideshow_image');
    }

    public function addSlideshowFilter($slideshowId)
    {
        $this->getSelect()->where('main_table.slideshow_id in (?)', $slideshowId);
        return $this;
    }
}
