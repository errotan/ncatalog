<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Application\Entity\Category;

class CategoryFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName('Levelek');
        $category->setParentId(0);
        $manager->persist($category);

        $category = new Category();
        $category->setName('Iratok');
        $category->setParentId(0);
        $manager->persist($category);

        $category = new Category();
        $category->setName('Bejövő');
        $category->setParentId(1);
        $manager->persist($category);

        $category = new Category();
        $category->setName('Kimenő');
        $category->setParentId(1);
        $manager->persist($category);

        $manager->flush();
    }
}
