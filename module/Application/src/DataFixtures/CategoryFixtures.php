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

        $firstCategory = (new Category())
            ->setId(1)
            ->setName('Levelek');
        $manager->persist($firstCategory);

        $category = (new Category())
            ->setId(2)
            ->setName('Iratok');
        $manager->persist($category);

        $category = (new Category())
            ->setId(3)
            ->setName('Bejövő')
            ->setParent($firstCategory);
        $manager->persist($category);

        $outCategory = (new Category())
            ->setId(4)
            ->setName('Kimenő')
            ->setParent($firstCategory);
        $manager->persist($outCategory);

        $category = (new Category())
            ->setId(5)
            ->setName('2019')
            ->setParent($outCategory);
        $manager->persist($category);

        $manager->flush();
    }
}
