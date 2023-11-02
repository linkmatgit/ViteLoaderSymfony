<?php

namespace Vite\Symfony\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Vite\ViteAssetLoader;


class TwigAssetExtension extends AbstractExtension
{


    public function __construct(private ViteAssetLoader $loader)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('encore_entry_link_tags', [$this->loader,  'link'],['is_safe' => ['html']]),
            new TwigFunction('encore_entry_script_tags', [$this->loader, 'script'], ['is_safe' => ['html']]),
        ];
    }



}