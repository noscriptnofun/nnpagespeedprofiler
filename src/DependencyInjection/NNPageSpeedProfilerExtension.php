<?php
# @Author: andreasprietzel
# @Date:   1970-01-01T01:00:00+01:00
# @Last modified by:   andreasprietzel
# @Last modified time: 2020-08-10T12:32:13+02:00

namespace nsnf\NNPageSpeedProfiler\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class NNPageSpeedProfilerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');
    }
}
