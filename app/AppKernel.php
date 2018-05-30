<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Broadway\Bundle\BroadwayBundle\BroadwayBundle(),
            new SuperAwesome\Symfony\BlogBundle\SuperAwesomeBlogBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config.yml');
        $loader->load(__DIR__ . '/config/services.yml');

        $envParameters = $this->getEnvParameters();
        $loader->load(function (ContainerBuilder $container) use ($envParameters) {
            $container->getParameterBag()->add($envParameters);
        });

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $loader->load(function (ContainerBuilder $container) {
                $container->loadFromExtension('web_profiler', array(
                    'toolbar' => true,
                ));

                $container->loadFromExtension('framework', array(
                    'test' => true,
                ));
            });
        }
    }
}
