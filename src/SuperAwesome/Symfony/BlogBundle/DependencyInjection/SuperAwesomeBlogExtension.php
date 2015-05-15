<?php

namespace SuperAwesome\Symfony\BlogBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class SuperAwesomeBlogExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $this->loadModels($loader);
        $this->loadReadModels($loader);
    }

    public function loadModels(LoaderInterface $loader)
    {
        $loader->load('model/post.xml');
    }

    public function loadReadModels(LoaderInterface $loader)
    {
        $loader->load('read-model/post-category-count.xml');
        $loader->load('read-model/post-tag-count.xml');
        $loader->load('read-model/published-post.xml');
    }
}
