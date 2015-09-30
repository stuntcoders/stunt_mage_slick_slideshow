<?php

class Stuntcoders_Slideshow_Block_Adminhtml_Slideshow_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('slideshow_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $this->setCollection(Mage::getModel('stuntcoders_slideshow/slideshow')->getCollection());
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('stuntcoders_slideshow')->__('Slideshow id'),
            'align'     =>'left',
            'width'     => '50px',
            'index'     => 'id',
        ));

        $this->addColumn('is_enabled', array(
            'header'  => Mage::helper('stuntcoders_slideshow')->__('Enabled'),
            'align'   => 'left',
            'width'   => '100px',
            'index'   => 'is_enabled',
            'type'    => 'options',
            'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray()
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('stuntcoders_slideshow')->__('Name'),
            'align'     =>'left',
            'index'     => 'name',
        ));

        $this->addColumn('code', array(
            'header'    => Mage::helper('stuntcoders_slideshow')->__('Code'),
            'align'     =>'left',
            'index'     => 'code',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('stuntcoders_slideshow')->__('Name'),
            'align'     =>'left',
            'index'     => 'name',
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('ids');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'    => Mage::helper('stuntcoders_slideshow')->__('Delete'),
            'url'      => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('stuntcoders_slideshow')->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/add', array('id' => $row->getId()));
    }

}
