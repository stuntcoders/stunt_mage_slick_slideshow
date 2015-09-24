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
            Mage::register('stuntcoders_slideshow',
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
                ->setIsEnabled($postData['is_enabled'])
                ->setConfig(trim($postData['config']));

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

            Mage::getSingleton('adminhtml/session')
                ->addSuccess(Mage::helper('stuntcoders_slideshow')->__('Slideshow successfully saved'));
            $this->_redirect('*/*/add', array('id' => $slideshowModel->getId()));
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')
                ->addError(Mage::helper('stuntcoders_slideshow')->__($e->getMessage()));
            $this->_redirect('*/*/index');
        }
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

    private function _uploadImages()
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
