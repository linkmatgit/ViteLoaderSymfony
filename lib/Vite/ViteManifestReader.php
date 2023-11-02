<?php

namespace Vite;

use Vite\Symfony\Exception\ManifestNotFoundException;

class ViteManifestReader
{

    /**
     * @param string $path
     * @return array
     */
    public function read(string $path)
    {
                if(!file_exists($path)) {

                    throw new ManifestNotFoundException();

                }

        $files = json_decode(file_get_contents($path), true);

        return array_map(fn(array $item) => $item['file'], $files);


    }
}