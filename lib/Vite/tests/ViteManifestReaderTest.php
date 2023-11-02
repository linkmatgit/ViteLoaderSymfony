<?php

namespace Vite\Tests;

use PHPUnit\Framework\TestCase;
use Vite\Symfony\Exception\ManifestNotFoundException;
use Vite\ViteManifestReader;

class ViteManifestReaderTest extends TestCase
{

    public function testReadManifest():Void {


        $reader = new ViteManifestReader();
        $data =  $reader->read(__DIR__ .'/manifest.json');
        $this->assertArrayHasKey('app.js', $data);
        $this->assertEquals('app.js-ea7cb917.js', $data['app.js']);

}
     public function testThrowExceptionIfFileNotFound(): void
     {
        $reader = new ViteManifestReader();
        $reader->read(__DIR__ .'/manifdwest.json');

         $this->expectException(ManifestNotFoundException::class);
     }
}