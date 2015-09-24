<?php

class Stuntcoders_Slideshow_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function getID()
    {
        return Mage::registry('slideshow_data')->getId();
    }

    public function getCodeValue()
    {
        return Mage::registry('slideshow_data')->getCode();
    }

    public function getNameValue()
    {
        return Mage::registry('slideshow_data')->getName();
    }

    public function getStatusValue()
    {
        return Mage::registry('slideshow_data')->getIsEnabled();
    }

    public function getJsonObject()
    {
        return Mage::registry('slideshow_data')->getJsonString();
    }

    public function getImages()
    {
        return Mage::registry('slideshow_data')->getImages();
    }

    protected function _prepareLayout()
    {
        $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     =>  Mage::helper('stuntcoders_slideshow')->__('Save Slideshow'),
                    'onclick'   => 'stuntcoders_slideshow.submit()',
                    'class'   => 'add'
                ))
        );
    }

    public function getAddNewButtonHtml()
    {
        return $this->getChildHtml('save_button');
    }
}
