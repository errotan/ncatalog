<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace ApplicationTest\Utils;

use PHPUnit\Framework\TestCase;
use Application\Utils\Doctrine;
use Application\Entity\Acl;
use Application\Entity\Category;
use Application\Entity\User;

class DoctrineTest extends TestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    public function setUp()
    {
        $reflector = new \ReflectionClass(Doctrine::class);

        $property = $reflector->getProperty('em');
        $property->setAccessible(true);

        $doctrine = new Doctrine();
        $doctrine->doLoadFixtures();

        $this->em = $property->getValue($doctrine);
    }

    public function testTablesNotEmpty()
    {
        $this->assertNotNull($this->em->find(Acl::class, 1));
        $this->assertNotNull($this->em->find(Category::class, 1));
        $this->assertNotNull($this->em->find(User::class, 1));
    }
}
