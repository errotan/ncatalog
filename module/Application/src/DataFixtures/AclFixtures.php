<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Application\Entity\Acl;
use Application\Entity\User;
use Application\DataFixtures\UserFixtures;

/**
 * Predefined Acl.
 */
class AclFixtures extends AbstractFixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager database access object
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $metadata = $manager->getClassMetaData(Acl::class);
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $metadata->setIdGenerator(new AssignedGenerator());

        $user = $manager->find(User::class, 1);

        $acl = (new Acl())
            ->setId(1)
            ->setUser($user)
            ->setCanCreateCategory(true)
            ->setCanUpload(true)
            ->setCanDownload(true);

        $manager->persist($acl);
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
