<?php

namespace mike;

class ImageLoader {
    private $path;
    public function __construct($path) {
        $this->path = $path;
    }

    public function download() {
        echo $this->path;
    }
}