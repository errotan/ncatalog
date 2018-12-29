<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Utils;

use Zend\Mvc\Application;
use Zend\Stdlib\ArrayUtils;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

/**
 * Doctrine utility functions.
 */
final class Doctrine
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Load all fixtures.
     *
     * @return void
     */
    public static function loadFixtures()
    {
        (new Doctrine())->doLoadFixtures();
    }

    /**
     * Actually load all fixtures.
     *
     * @return void
     */
    public function doLoadFixtures()
    {
        $this->initApp();
        $this->importFixtures();
    }

    /**
     * @return void
     */
    private function initApp()
    {
        $appConfig = require 'config/application.config.php';

        if (file_exists('config/development.config.php')) {
            $appConfig = ArrayUtils::merge($appConfig, require 'config/development.config.php');
        }

        $this->em = Application::init($appConfig)->getServiceManager()->get(EntityManager::class);
    }

    /**
     * @return void
     */
    private function importFixtures()
    {
        $loader = new Loader();
        $loader->loadFromDirectory('module/Application/src/DataFixtures');
        $purger = new ORMPurger();
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());
    }
}
