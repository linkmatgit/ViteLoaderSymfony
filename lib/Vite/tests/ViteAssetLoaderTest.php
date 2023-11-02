<?php

namespace Vite\Tests;

use PHPUnit\Framework\TestCase;
use Vite\Symfony\Exception\ManifestNotFoundException;
use Vite\ViteAssetLoader;
use Vite\ViteManifestReader;

class ViteAssetLoaderTest extends TestCase
{

    private ViteAssetLoader $loader;
    private ViteAssetLoader $devLoader;
    public function setUp(): void
    {
        parent::setUp();
        $readerMock =  $this->createMock(ViteManifestReader::class);
        $readerMock->expects($this->any())
            ->method('read')
            ->willReturn([
                'app.css' => 'demo.css',
                'app.js' =>  'demo.js'
            ]);
        $readerMockException =  $this->createMock(ViteManifestReader::class);
        $readerMockException->expects($this->any())
            ->method('read')
            ->willThrowException(new ManifestNotFoundException());

        $this->loader  = new ViteAssetLoader(
            'manifest.json',
            '/assets/',
            'http://localhost:5173/',
            true,
            true,
            $readerMock);
        $this->devLoader  = new ViteAssetLoader(
            'manifest.json',
            '/assets/',
            'http://localhost:5173/',
            false,
            true,
            $readerMockException);


    }

    public function testScript(): void
    {

        $script = <<<HTML
<script type="module" src="/assets/demo.js" defer></script>
HTML;
        $this->assertEquals($script,  $this->loader->script('app'));
    }

    public function testLink(): void
    {

        $script = <<<HTML
<link rel="stylesheet" href="/assets/demo.css" media="screen" />
HTML;
        $this->assertEquals($script,  $this->loader->link('app'));
    }
   /* public function testScriptDevMode(): void
    {

        $script = <<<HTML
<script type="module" src="http://localhost:5173/assets/app.js" defer></script>
HTML;
        $this->assertEquals($script,  $this->devLoader->script('app'));
    }*/

}