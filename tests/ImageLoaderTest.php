<?php

namespace mike\tests;

use mike\ImageLoader;
use PHPUnit\Framework\TestCase;

class ImageLoaderTest extends TestCase {

    public function testWrongUrl() {
        try {
            $loader = new ImageLoader('');
            $this->fail('Wrong url format not thrown');
        } catch(\Exception $e) {
            $this->assertEquals('Wrong url format', $e->getMessage());
        }
    }

    public function testWrongExtension() {
        try {
            $loader = new ImageLoader('https://mail.ru/');
            $this->fail('Wrong image extension not thrown');
        } catch(\Exception $e) {
            $this->assertEquals('Wrong image extension', $e->getMessage());
        }
    }

}