<?php

class Stuntcoders_Slideshow_Model_Resource_Slideshow_Image extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('stuntcoders_slideshow/slideshow_image', 'id');
    }
}
