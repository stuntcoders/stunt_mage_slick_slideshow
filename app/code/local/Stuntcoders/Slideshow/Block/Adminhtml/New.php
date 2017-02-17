<?php

class Stuntcoders_Slideshow_Block_Adminhtml_New extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_headerText = Mage::helper('stuntcoders_slideshow')->__('Slideshow Manager');
        $this->_blockGroup = 'stuntcoders_slideshow';
        $this->_controller = 'adminhtml';
        $this->_mode = 'new';

        parent::__construct();
    }
}
