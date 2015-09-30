<?php

class Stuntcoders_Slideshow_Block_Adminhtml_Add extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_headerText = Mage::helper('stuntcoders_slideshow')->__('Slideshow Manager');;
        parent::__construct();
        $this->setTemplate('stuntcoders/slideshow/add.phtml');
    }

    protected function _prepareLayout()
    {
        $this->setChild('save_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'   =>  Mage::helper('stuntcoders_slideshow')->__('Save Slideshow'),
                    'onclick' => "stuntcoders_slideshow.submit()",
                    'class'   => 'add'
                ))
        );

        $this->setChild('form', $this->getLayout()->createBlock('stuntcoders_slideshow/adminhtml_slideshow_form'));
    }

    public function getSaveButtonHtml()
    {
        return $this->getChildHtml('save_button');
    }

    public function getFormHtml()
    {
        return $this->getChildHtml('form');
    }
}
