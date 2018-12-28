<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Doctrine\ORM\EntityManager;
use Application\Controller\IndexController;

/**
 * This is the factory for IndexController. Its purpose is to instantiate the
 * controller.
 */
class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new IndexController($container->get(EntityManager::class));
    }
}
