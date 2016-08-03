<?php

namespace mike;

/**
 * Class ImageLoader
 * @package mike
 */
class ImageLoader
{
    /**
     * @var string remote image path
     */
    private $path;

    /**
     * @var array allowed mime types for image validation after download
     */
    private $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/git'
    ];

    /**
     * @var array allowed file extension for validation download url
     */
    private $allowedExtensions = [
        'jpg',
        'png',
        'gif'
    ];

    /**
     * ImageLoader constructor.
     * @param string $sourcePath remote image path
     */
    public function __construct($sourcePath)
    {
        $this->validateUrl($sourcePath);
        $this->path = $sourcePath;
    }

    /**
     * @param string $sourcePath remote image path
     * @throws \Exception
     */
    private function validateUrl($sourcePath)
    {
        if(!filter_var($sourcePath, FILTER_VALIDATE_URL)) {
            throw new \Exception('Wrong url format');
        }

        $pathInfo = pathinfo($sourcePath);
        if(!in_array($pathInfo['extension'], $this->allowedExtensions)) {
            throw new \Exception('Wrong image extension');
        }
    }

    /**
     * @param string $destinationPath image destination path
     * @throws \Exception
     */
    private function validateImage($destinationPath)
    {
        $image = getimagesize($destinationPath);

        if(!$image) {
            throw new \Exception('File is not an image');
        }

        if(!in_array($image['mime'], $this->allowedMimeTypes)) {
            throw new \Exception('Image has wrong mime type');
        }
    }

    /**
     * @param string $destinationPath image destination path
     * @return bool returns true on success
     * @throws \Exception
     */
    public function download($destinationPath)
    {
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