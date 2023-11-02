## Vite AssetsLoader Pour symfony


Ce projet a pour but de facilité mon installation de viteJs avec Symfony, il n'est pas 
penser pour etre utiliser par d'autre mais si vous voulez  le prendre et l'ameliorer pour
vous allez-y
Je suis debutant en php donc le code n'est aucunement optimiser et les test son 
primaire ...



### a faire
 - Rajouter le cache
 - Finaliser les testunitaire

## Installation 

pour commancer ajouter dans votre .env les ligne suivente

VITE_ASSETS_PATH=/assets/

VITE_DEV_SERVER_URL=http://localhost:5173/

VITE_ENV=0

VITE_REACT=1

et finalement a Ajouter dans votre Service.yaml

Vite\ViteAssetLoader:
arguments:
- "%kernel.project_dir%/public/assets/manifest.json"
- "%env(VITE_ASSETS_PATH)%"
- "%env(VITE_DEV_SERVER_URL)%"
- "%env(VITE_ENV)%"
- "%env(VITE_REACT)%"

    Vite\ViteManifestReader:
        class: Vite\ViteManifestReader

    Vite\Symfony\Twig\TwigAssetExtension:
        class: Vite\Symfony\Twig\TwigAssetExtension

Merci de votre comprehension 