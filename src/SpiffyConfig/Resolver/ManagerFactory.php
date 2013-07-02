<?php

namespace SpiffyConfig\Resolver;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ManagerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return Manager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \SpiffyConfig\ModuleOptions $options */
        $options = $serviceLocator->get('SpiffyConfig\ModuleOptions');
        $manager = new Manager();
        $config  = new ManagerConfig($options->getResolvers());

        $manager->addPeeringServiceManager($serviceLocator);
        $config->configureServiceManager($manager);

        return $manager;
    }
}
