<?php

class Stuntcoders_Slideshow_Block_Adminhtml_Slideshow_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id' => 'stuntcoders_slideshow',
                'name' => 'stuntcoders_slideshow',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            )
        );

        if (Mage::registry('stuntcoders_data')) {
            $data = Mage::registry('stuntcoders_data')->getData();
        } else {
            $data = array();
        }

        $fieldset = $form->addFieldset('stuntcoders_form', array(
            'legend' => Mage::helper('stuntcoders_slideshow')->__('Slideshow Information')
        ));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('stuntcoders_slideshow')->__('Name'),
            'name' => 'name',
        ));

        $fieldset->addField('code', 'text', array(
            'label' => Mage::helper('stuntcoders_slideshow')->__('Code'),
            'name' => 'code',
        ));

        $fieldset->addField('is_enabled', 'select', array(
            'label' => Mage::helper('stuntcoders_slideshow')->__('Enabled'),
            'name' => 'is_enabled',
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        $fieldset->addField('config', 'hidden', array('name' => 'config'));

        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('stuntcoders_slideshow')->__('Images'),
            'name' => 'images[]',
            'multiple'  => 'multiple',
            'mulitple'  => true,
        ));

        $form->setValues($data);

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
