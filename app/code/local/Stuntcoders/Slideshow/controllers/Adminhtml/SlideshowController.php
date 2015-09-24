<?php

class Stuntcoders_Slideshow_Adminhtml_SlideshowController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function addAction()
    {
        if ($this->getRequest()->getParam('id')) {
            Mage::register('slideshow_data',
                Mage::getModel('stuntcoders_slideshow/slideshow')->load($this->getRequest()->getParam('id'))
            );
        }

        $this->loadLayout();
        $this->renderLayout();
    }

    public function editAction()
    {
        if ($this->getRequest()->getParam('id')) {
            Mage::register('slideshow_data',
                Mage::getModel('stuntcoders_slideshow/slideshow')->load($this->getRequest()->getParam('id'))
            );
        }

        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction()
    {
        $postData = $this->getRequest()->getPost();

        if (!$postData) {
            $this->_redirect('*/*/index');
            return;
        }

        try {
            $slideshowModel = Mage::getModel('stuntcoders_slideshow/slideshow');
            $slideshowModel->setName($postData['name'])
                ->setCode($postData['code'])
                ->setIsEnabled($postData['status'])
                ->setJsonString(preg_replace('/\s+/', ' ', $postData['jsonObject']));
            if ($this->getRequest()->getParam('id')) {
                $slideshowModel->setId($this->getRequest()->getParam('id'));
            }

            $slideshowModel->save();
            if (isset($postData['editImages'])) {
                $images = json_decode($postData['editImages']);
                foreach ($images as $image) {
                    $imageModel = Mage::getModel('stuntcoders_slideshow/slideshow_image')->load($image->id);
                    if ($image->delete) {
                        $imageModel->delete();
                    }
                    $image->status ? $imageModel->setIsEnabled(1) : $imageModel->setIsEnabled(0);
                    $imageModel->save();
                }
            }

            $images = $this->_uploadImage();
            if (!empty($images)) {
                foreach ($images as $image) {
                    Mage::getModel('stuntcoders_slideshow/slideshow_image')
                        ->setImage($image)
                        ->setSlideshowId($slideshowModel->getId())
                        ->setIsEnabled(1)
                        ->save();
                }
            }

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('stuntcoders_slideshow')->__('Slideshow successfully saved'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stuntcoders_slideshow')->__('Slideshow could not be saved'));
        }

        $this->_redirect('*/*/index');
    }

    public function deleteAction()
    {
        if (!$this->getRequest()->getParam('id')) {
            $this->_redirect('*/*/index');
            return;
        }

        try {
            Mage::getModel('stuntcoders_slideshow/slideshow')
                ->load($this->getRequest()->getParam('id'))
                ->delete();

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('stuntcoders_simplemenu')->__('Simple Menu successfully deleted'));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stuntcoders_simplemenu')->__('Simple Menu could not be deleted'));
        }

        $this->_redirect('*/*/index');
    }

    public function massDeleteAction()
    {
        $idList = $this->getRequest()->getParam('ids');
        if (!is_array($idList)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('stuntcoders_slideshow')->__('Please select banners(s)')
            );
        } else {
            try {
                foreach ($idList as $itemId) {
                    Mage::getModel('stuntcoders_slideshow/slideshow')
                        ->setIsMassDelete(true)
                        ->load($itemId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('stuntcoders_slideshow')->__(
                        'Total of %d record(s) were successfully deleted', count($idList)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    private function _uploadImage()
    {
        if (!isset($_FILES['image']['name'])) {
            return false;
        }

        $names = array();
        $path = Mage::getBaseDir('media') . DS . 'slideshow' . DS;
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        foreach ($_FILES['image']['name'] as $key => $image) {
            try {
                $uploader = new Varien_File_Uploader(
                    array(
                        'name' => $_FILES['image']['name'][$key],
                        'type' => $_FILES['image']['type'][$key],
                        'tmp_name' => $_FILES['image']['tmp_name'][$key],
                        'error' => $_FILES['image']['error'][$key],
                        'size' => $_FILES['image']['size'][$key]
                    )
                );
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                $imageName = $uploader->getCorrectFileName($_FILES['image']['name'][$key]);
                $uploader->save($path, $imageName);
                $names[] = 'slideshow/' . $imageName;

            } catch (Exception $e) {
                Mage::logException($e);
                continue;
            }
        }

        return $names;
    }
}
