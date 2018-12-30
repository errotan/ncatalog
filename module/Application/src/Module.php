<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application;

use Zend\EventManager\EventInterface;

/**
 * Application setup class.
 */
class Module
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__.'/../config/module.config.php';
    }

    /**
     * @param EventInterface $event bootstrap event holder
     *
     * @return void
     */
    public function onBootstrap(EventInterface $event)
    {
        date_default_timezone_set($event->getApplication()->getServiceManager()->get('config')['timezone']);
    }
}
