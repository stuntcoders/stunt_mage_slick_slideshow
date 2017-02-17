<?php

class Stuntcoders_Slideshow_Block_Adminhtml_Index extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_headerText = Mage::helper('stuntcoders_slideshow')->__('Slideshow Manager');
        $this->_blockGroup = 'stuntcoders_slideshow';
        $this->_controller = 'adminhtml_index';

        parent::__construct();
    }
}
