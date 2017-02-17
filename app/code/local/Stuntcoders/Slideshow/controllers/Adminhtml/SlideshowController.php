<?php

class Stuntcoders_Slideshow_Adminhtml_SlideshowController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function newAction()
    {
        if ($this->getRequest()->getParam('id')) {
            Mage::register('stuntcoders_slideshow',
                Mage::getModel('stuntcoders_slideshow/slideshow')->load($this->getRequest()->getParam('id'))
            );
        }

        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction()
    {
        try {
            $postData = $this->getRequest()->getPost();
            if (!$postData) {
                Mage::throwException('Bad request');
            }

            $slideshowModel = Mage::getModel('stuntcoders_slideshow/slideshow');
            $slideshowModel->addData($postData)
                ->setConfig(Mage::helper('stuntcoders_slideshow')->generateConfig($postData));

            if ($this->getRequest()->getParam('id')) {
                $slideshowModel->setId($this->getRequest()->getParam('id'));
            }

            $slideshowModel->save();

            $slideshowModel->addImages($this->_uploadImages());

            if (!empty($postData['edit_images'])) {
                foreach ($postData['edit_images'] as $id => $data) {
                    $image = Mage::getModel('stuntcoders_slideshow/slideshow_image')->load($id);

                    if (!$image->getId()) {
                        continue;
                    }

                    if (isset($data['delete'])) {
                        $image->delete();
                        continue;
                    }

                    $image->setName($data['name'])
                        ->setIsEnabled(isset($data['enabled']))
                        ->save();
                }
            }

            $this->_getSession()->addSuccess($this->__('Slideshow saved'));
            $this->_redirect('*/*/new', array('id' => $slideshowModel->getId()));
        } catch (Exception $e) {
            $this->_getSession()->addError($this->__($e->getMessage()));
            $this->_redirect('*/*/index');
        }
    }

    public function deleteAction()
    {
        try {
            if (!$this->getRequest()->getParam('id')) {
                Mage::throwException('Bad request');
            }

            Mage::getModel('stuntcoders_slideshow/slideshow')
                ->load($this->getRequest()->getParam('id'))
                ->delete();

            $this->_getSession()->addSuccess($this->__('Slideshow deleted'));
        } catch (Exception $e) {
            $this->_getSession()->addError($this->__($e->getMessage()));
        }

        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        try {
            $idList = $this->getRequest()->getParam('ids');
            if (!is_array($idList)) {
                Mage::throwException('Please select slideshow(s)');
            }

            foreach ($idList as $itemId) {
                Mage::getModel('stuntcoders_slideshow/slideshow')
                    ->setIsMassDelete(true)
                    ->load($itemId)
                    ->delete();
            }

            $this->_getSession()->addSuccess($this->__(
                'Total of %d record(s) were successfully deleted',
                count($idList)
            ));
        } catch (Exception $e) {
            $this->_getSession()->addError($this->__($e->getMessage()));
        }

        $this->_redirect('*/*/index');
    }

    protected function _getHelper()
    {
        return Mage::helper('stuntcoders_slideshow');
    }

    protected function _uploadImages()
    {
        if (!isset($_FILES['images']['name'])) {
            return false;
        }

        $names = array();
        $path = Mage::helper('stuntcoders_slideshow')->getImageSavePath();
        foreach ($_FILES['images']['name'] as $key => $image) {
            try {
                $uploader = new Varien_File_Uploader(array(
                    'name' => $_FILES['images']['name'][$key],
                    'type' => $_FILES['images']['type'][$key],
                    'tmp_name' => $_FILES['images']['tmp_name'][$key],
                    'error' => $_FILES['images']['error'][$key],
                    'size' => $_FILES['images']['size'][$key]
                ));

                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                $imageName = $uploader->getCorrectFileName($_FILES['images']['name'][$key]);

                $uploader->save($path, $imageName);
                $names[] = $imageName;

            } catch (Exception $e) {
                Mage::logException($e);
                continue;
            }
        }

        return $names;
    }
}
