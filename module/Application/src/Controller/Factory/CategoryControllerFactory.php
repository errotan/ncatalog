<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Doctrine\ORM\EntityManager;
use Application\Controller\CategoryController;

/**
 * This is the factory for CategoryController. Its purpose is to instantiate the
 * controller.
 */
class CategoryControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CategoryController($container->get(EntityManager::class));
    }
}
