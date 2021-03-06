<?php

namespace DistrictWeb\SphinxBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('dw_sphinx');

        $rootNode
            ->children()
                ->scalarNode('host')
                    ->defaultValue('127.0.0.1')
                ->end()
                ->scalarNode('port')
                    ->defaultValue('9312')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
