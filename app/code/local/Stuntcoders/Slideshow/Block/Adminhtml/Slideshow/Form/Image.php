<?php

class Stuntcoders_Slideshow_Block_Adminhtml_Slideshow_Form_Image extends Varien_Data_Form_Element_Abstract
{
    public function getElementHtml()
    {
        return Mage::app()->getLayout()
            ->createBlock('core/template')
            ->setTemplate('stuntcoders/slideshow/form/image.phtml')
            ->setImage($this->getImage())
            ->toHtml();
    }
 }