<?php

class Stuntcoders_Slideshow_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getImageSavePath()
    {
        $path = Mage::getBaseDir('media') . DS . 'stuntcoders' .DS . 'slideshow' . DS;
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        return $path;
    }

    public function getImageUrl($imageName)
    {
        return Mage::getBaseUrl('media') . '/stuntcoders/slideshow/' . $imageName;
    }
}
