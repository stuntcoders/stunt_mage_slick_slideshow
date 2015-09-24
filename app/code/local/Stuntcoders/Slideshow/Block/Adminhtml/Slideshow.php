<?php

class Stuntcoders_Slideshow_Block_Adminhtml_Slideshow extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_headerText = Mage::helper('stuntcoders_slideshow')->__('Slideshow Manager');
        parent::__construct();
        $this->setTemplate('stuntcoders/slideshow/slideshow.phtml');
    }

    protected function _prepareLayout()
    {
        $this->setChild('add_new_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('stuntcoders_slideshow')->__('Add Slideshow'),
                    'onclick'   => "setLocation('" . $this->getUrl('*/*/add') . "')",
                    'class'     => 'add'
                ))
        );
    }

    public function getAddNewButtonHtml()
    {
        return $this->getChildHtml('add_new_button');
    }
}
