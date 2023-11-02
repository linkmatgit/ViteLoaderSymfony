<?php

namespace Vite;


use Vite\Symfony\Exception\ManifestNotFoundException;

class ViteAssetLoader
{

    public function __construct(
        private readonly string $manifestPath,
        private readonly string $publicPath,
        private readonly string $devServer,
        private readonly bool $isProduction,
        private readonly bool $isReact,
        private readonly ViteManifestReader $reader

    )
    {

    }


    public function link(string $fileName):string
    {
        /**
         * Si on est en dev renvoie une chaine de caractere vide
         */
        if($this->isProduction === false) {
            return '';
        }
        $path = $this->getUrl("$fileName.css");
        return <<<HTML
<link rel="stylesheet" href="$path" media="screen" />
HTML;

    }

    public function script(string $fileName): string|ManifestNotFoundException
    {

    if($this->isProduction === true)
    {
        $path = $this->getUrl("$fileName.js");
        $html =  <<<HTML
<script type="module" src="$path" defer></script>
HTML;
    }
            /**
         * Seconde verification a savoir si on est en Production ou Dev
         */
     if ($this->isProduction === false){
         $dev =$this->devServer . 'assets/' . "$fileName.js";
            $html =  <<<HTML
<script type="module" src="$dev" defer></script>
HTML;
            $html .= $this->getViteTool();

         /**
          * Verifie si le Module est React
          */
         /*   if ($this->isReact === true) {
                $html .= $this->getReactTools();
            }

*/
        }
   return $html;
    }

    private function getUrl(string $filename):string
    {
        try {
            $file = $this->reader->read($this->manifestPath);

            return rtrim($this->publicPath, '/') . '/' . $file[$filename];
        } catch (ManifestNotFoundException $e) {
            return $this->devServer . '/' . $filename;

        }

    }


        public function getViteTool():string
        {
         return <<<HTML
            <script type="module" src={$this->devServer}/@vite/client"></script>
        HTML;
        }


        public function getReactTool() {

        $html = <<<HTML
<script type="module">
            import RefreshRuntime from "{$this->devServer}/@react-refresh"
            RefreshRuntime.injectIntoGlobalHook(window)
            window.$RefreshReg$ = () => {}
            window.$RefreshSig$ = () => (type) => type
            window.__vite_plugin_react_preamble_installed__ = true
        </script>
HTML;

        }





}