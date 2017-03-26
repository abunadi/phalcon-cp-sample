<?php

use Phalcon\Mvc\User\Plugin;

class ImagesUploader extends Plugin
{

    private $_image;
    private $imagedir;
    private $quality;
    private $resize;
    private $allowed_types;
    private $save_path;
    private $new_name;
    private $mid;

    public function __construct($settings, $save_path, $mid)
    {
        $this->imagedir = $settings['imagedir'];
        $this->quality = $settings['quality'];
        $this->resize = $settings['resize'];
        $this->allowed_types = array(IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG, IMAGETYPE_BMP);
        $this->mid = $mid;
        $this->save_path = $save_path . $this->imagedir . sprintf('%03d', $this->mid) . '/';
    }

    public function loadImage($image)
    {
        // Check if image exists
        if (!is_file($image->getTempName())) {
            $this->logger->log('cp', "Image can not be loaded ({$image->getName()})");
            return false;
        }

        // Get image information
        list($width, $height, $type, $attr) = @getimagesize($image->getTempName());

        // Log image information
        $this->logger->log('cp', "Loading Image ({$image->getName()}), type ($type) and size ($width x $height)");

        if (in_array($type, $this->allowed_types)) {
            try {
                $this->_image = new Phalcon\Image\Adapter\Imagick($image->getTempName());
                $this->new_name = $this->generate_img_name($this->mid);
            } catch (ImagickException $e) {
                $this->logger->log('cp', "Imagick exception: " . $e->getMessage());
                return false;
            }
        } else {
            $this->logger->log('cp', "Image type is not supported ({$image->getName()}) with type (" . mime_content_type($image->getTempName()) . ")");
            return false;
        }

        // Image load ok
        $this->logger->log('cp', "Image load success, name:'{$image->getName()}', type:'$type', size:'{$width}x{$height}'");
        return true;
    }

    private function generate_img_name($mid)
    {
        return uniqid(sprintf('%03d', $mid)) . '.jpg';
    }

    // path ex: /var/www/html/images/items/mall-id/lg/test3.jpg
    public function resize_and_save()
    {
        foreach ($this->resize as $folder => $res) {
            $this->_image->resize($res['w'], $res['h']);
            if ($this->_image->save($this->save_path . $folder . '/' . $this->new_name, $this->quality)) {
                $this->logger->log('cp', "Image resized to ({$res['w']}, {$res['h']}) and saved in $folder with file name ({$this->new_name})");
            } else {
                $this->logger->log('cp', "Image is not saved/resized.");
                return false;
            }
        }
        return $this->new_name;
    }

    public function get_img_res()
    {
        return $this->_image->getWidth() . '*' . $this->_image->getHeight();
    }

    public function destroyImage()
    {

    }
}	
