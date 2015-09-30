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

        if (Mage::registry('stuntcoders_slideshow')) {
            $data = Mage::registry('stuntcoders_slideshow')->getData();
        } else {
            $data = array();
        }

        $fieldset = $form->addFieldset('stuntcoders_slideshow_form', array(
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

        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('stuntcoders_slideshow')->__('Add images'),
            'name' => 'images[]',
            'multiple'  => 'multiple',
            'mulitple'  => true,
        ));

        $fieldset = $form->addFieldset('stuntcoders_slideshow_options_form', array(
            'legend' => Mage::helper('stuntcoders_slideshow')->__('Slideshow Options')
        ));

        $configData = isset($data['config']) ? json_decode($data['config'], true) : array();
        $data['autoplay'] = isset($configData['autoplay']) && $configData['autoplay'] ? 1 : 0;
        $data['direction'] = isset($configData['vertical']) && $configData['vertical'] ? 1 : 0;
        $data['animation'] = isset($configData['fade']) && $configData['fade'] ? 1 : 0;
        $data['dots'] = isset($configData['dots']) && $configData['dots'] ? 1 : 0;

        $fieldset->addField('autoplay', 'select', array(
            'label' => Mage::helper('stuntcoders_slideshow')->__('Auto play'),
            'name' => 'autoplay',
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        $fieldset->addField('direction', 'select', array(
            'label' => Mage::helper('stuntcoders_slideshow')->__('Slideshow direction'),
            'name' => 'direction',
            'values' => array(
                array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('Horizontal')),
                array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Vertical')),
            )
        ));

        $fieldset->addField('animation', 'select', array(
            'label' => Mage::helper('stuntcoders_slideshow')->__('Animation type'),
            'name' => 'animation',
            'values' => array(
                array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('Slide')),
                array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Fade')),
            )
        ));

        $fieldset->addField('dots', 'select', array(
            'label' => Mage::helper('stuntcoders_slideshow')->__('Show dots'),
            'name' => 'dots',
            'values' => Mage::getModel('adminhtml/system_config_source_yesno')->toOptionArray()
        ));

        $fieldset = $form->addFieldset('stuntcoders_slideshow_images_form', array(
            'legend' => Mage::helper('stuntcoders_slideshow')->__('Slideshow Images')
        ));

        $fieldset->addType('stuntcoders_slideshow_image', 'Stuntcoders_Slideshow_Block_Adminhtml_Slideshow_Form_Image');
        if (Mage::registry('stuntcoders_slideshow')) {
            foreach (Mage::registry('stuntcoders_slideshow')->getImagesCollection() as $image) {
                $fieldset->addField("slideshow_image_{$image->getId()}", 'stuntcoders_slideshow_image', array(
                    'image' => $image
                ));
            }
        }

        $form->setValues($data);

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
