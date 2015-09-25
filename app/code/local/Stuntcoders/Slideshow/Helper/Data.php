<?php

class Stuntcoders_Slideshow_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getImageSavePath()
    {
        $path = Mage::getBaseDir('media') . DS . 'stuntcoders' .DS . 'slideshow' . DS;
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        return $path;
    }

    public function getImageUrl($imageName)
    {
        return Mage::getBaseUrl('media') . '/stuntcoders/slideshow/' . $imageName;
    }

    public function generateConfig($data)
    {
        $config = array(
            'adaptiveHeight' => true,
            'infinite' => true,
        );

        if ($data['autoplay']) {
            $config['autoplay'] = true;
        }

        if ($data['animation']) {
            $config['fade'] = true;
        }

        if ($data['direction']) {
            $config['vertical'] = true;
        }

        if ($data['dots']) {
            $config['dots'] = true;
        }

        return json_encode($config);
    }
}
