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

    public function testNotImage() {
        $downloadPath = __DIR__ . '/cover_letter.jpg';
        try {
            //actually it's pdf ;)
            $loader = new ImageLoader('http://mihael.me/sites/default/files/cover_letter.jpg');
            $loader->download($downloadPath);
            unlink($downloadPath);
            $this->fail('File is not an image not thrown');
        } catch(\Exception $e) {
            unlink($downloadPath);
            $this->assertEquals('File is not an image', $e->getMessage());
        }
    }

    public function testWrongMimeType() {
        $downloadPath = __DIR__ . '/test.jpg';

        try {
            //actually it's bmp ;)
            $loader = new ImageLoader('http://mihael.me/sites/default/files/test.jpg');
            $loader->download($downloadPath);
            unlink($downloadPath);
            $this->fail('Image has wrong mime type');
        } catch (\Exception $e) {
            unlink($downloadPath);
            $this->assertEquals('Image has wrong mime type', $e->getMessage());
        }
    }

    public function testSuccessfulDownload() {
        $downloadPath = __DIR__ . '/face.jpg';
        try {
            //huh, this is real image
            $loader = new ImageLoader('http://mihael.me/sites/default/files/large_1KCapF6H02c.jpg');
            $return = $loader->download($downloadPath);
            unlink($downloadPath);
            $this->assertEquals($return, true);
        } catch(\Exception $e) {
            unlink($downloadPath);
            $this->fail($e->getMessage());
        }
    }

}