<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Id\AssignedGenerator;
use Application\Entity\Category;

/**
 * Sample categories.
 */
class CategoryFixtures implements FixtureInterface
{
    /**
     * @param ObjectManager $manager database access object
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $metadata = $manager->getClassMetaData(Category::class);
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $metadata->setIdGenerator(new AssignedGenerator());

        $category = new Category();
        $category->setId(1);
        $category->setName('Levelek');
        $category->setParentId(0);
        $manager->persist($category);

        $category = new Category();
        $category->setId(2);
        $category->setName('Iratok');
        $category->setParentId(0);
        $manager->persist($category);

        $category = new Category();
        $category->setId(3);
        $category->setName('Bejövő');
        $category->setParentId(1);
        $manager->persist($category);

        $category = new Category();
        $category->setId(4);
        $category->setName('Kimenő');
        $category->setParentId(1);
        $manager->persist($category);

        $category = new Category();
        $category->setId(5);
        $category->setName('2019');
        $category->setParentId(4);
        $manager->persist($category);

        $manager->flush();
    }
}
