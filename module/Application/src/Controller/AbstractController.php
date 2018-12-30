<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;

/**
 * Abstract controller to inherit from.
 */
abstract class AbstractController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em database access object
     *
     * @return void
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
}
