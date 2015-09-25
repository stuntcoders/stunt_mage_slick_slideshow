<?php

class Stuntcoders_Slideshow_Block_Slideshow extends Mage_Core_Block_Template
{
    public function getImagesCollection()
    {
        return $this->getSlideshow() ? $this->getSlideshow()->getImagesCollection(): array();
    }

    public function isEnabled()
    {
        return (bool) $this->getSlideshow() ? $this->getSlideshow()->getIsEnabled() : false;
    }

    public function getConfig()
    {
        return $this->getSlideshow() ? $this->getSlideshow()->getConfig() : '';
    }

    public function getImageUrl($image)
    {
        return Mage::helper('stuntcoders_slideshow')->getImageUrl($image->getImage());
    }

    public function getSlideshow()
    {
        if (!$this->hasSlideshow()) {
            $this->_loadSlideshow();
        }

        return $this->getData('slideshow');
    }

    protected function _loadSlideshow()
    {
        if ($this->hasSlideshowCode()) {
            $this->setSlideshowId(
                Mage::getModel('stuntcoders_slideshow/slideshow')->getIdByCode($this->getSlideshowCode())
            );
        }

        if ($this->getSlideshowId()) {
            $this->setSlideshow(Mage::getModel('stuntcoders_slideshow/slideshow')->load($this->getSlideshowId()));
        }

        return $this;
    }

    protected function _toHtml()
    {
        if (!$this->getTemplate()) {
            $this->setTemplate('stuntcoders/slideshow/slideshow.phtml');
        }
        $html = $this->renderView();
        return $html;
    }
}
