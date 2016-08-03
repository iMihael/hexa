<?php

namespace mike;

class ImageLoader {
    private $path;

    private $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/git'
    ];

    private $allowedExtensions = [
        'jpg',
        'png',
        'gif'
    ];

    public function __construct($sourcePath) {
        $this->validateUrl($sourcePath);
        $this->path = $sourcePath;
    }

    private function validateUrl($sourcePath) {
        if(!filter_var($sourcePath, FILTER_VALIDATE_URL)) {
            throw new \Exception('Wrong url format');
        }

        $pathInfo = pathinfo($sourcePath);
        if(!in_array($pathInfo['extension'], $this->allowedExtensions)) {
            throw new \Exception('Wrong image extension');
        }
    }

    private function validateImage($destinationPath) {
        $image = getimagesize($destinationPath);

        if(!$image) {
            throw new \Exception('File is not an image');
        }

        if(!in_array($image['mime'], $this->allowedMimeTypes)) {
            throw new \Exception('Image has wrong mime type');
        }
    }

    public function download($destinationPath) {
        if($file = fopen($destinationPath, 'w+')) {
            $ch = curl_init($this->path);
            curl_setopt($ch, CURLOPT_FILE, $file);
            curl_exec($ch);
            curl_close($ch);
            fclose($file);

            $this->validateImage($destinationPath);

            return true;
        } else {
            throw new \Exception('Fail open failure');
        }
    }
}