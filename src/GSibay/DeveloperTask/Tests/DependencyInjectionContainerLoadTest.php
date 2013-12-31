<?php

namespace GSibay\DeveloperTask\Tests;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DependencyInjectionContainerLoadTest extends \PHPUnit_Framework_TestCase
{

    public function testLoadContainerFromFile_AllServicesAreInstanciated()
    {
        $container = new ContainerBuilder();
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../../../../app/config'));
        $loader->load('services.xml');

        foreach ($container->getServiceIds() as $serviceId) {
            $this->assertNotNull($container->get($serviceId));
        }
    }

}
