<?php

class Stuntcoders_Slideshow_Block_Slideshow extends Mage_Core_Block_Template
{
    public function getImages()
    {
        if (!$this->hasLoadedImages()) {
            if (!$this->getSlideshow()) {
                $this->_loadSlideshow();
            }

            $this->setLoadedImages($this->getSlideshow() ? $this->getSlideshow()->getImages(): array());
        }

        return $this->getLoadedImages();
    }

    public function isEnabled()
    {
        if (!$this->hasSlideshow()) {
            $this->_loadSlideshow();
        }

        return (bool) $this->getSlideshow()->getIsEnabled();
    }

    protected function _loadSlideshow()
    {
        if ($this->hasSlideshowCode()) {
            $this->setId(Mage::getModel('stuntcoders_slideshow/slideshow')->getIdByCode($this->getSlideshowCode()));
        }

        if ($this->hasId()) {
            $this->setSlideshow(Mage::getModel('stuntcoders_slideshow/slideshow')->load($this->getId()));
        }

        return $this;
    }

    public function getImagePath($image)
    {
        return Mage::getBaseUrl('media') . $image['image'];
    }
}
