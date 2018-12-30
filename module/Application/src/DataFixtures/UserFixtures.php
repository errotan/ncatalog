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
use Application\Entity\User;

/**
 * Predefined users.
 */
class UserFixtures implements FixtureInterface
{
    /**
     * @param ObjectManager $manager database access object
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $metadata = $manager->getClassMetaData(User::class);
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $metadata->setIdGenerator(new AssignedGenerator());

        $password = substr(sha1(uniqid(null, true)), 0, 8);

        $user = new User();
        $user->setId(1);
        $user->setUserName('admin');
        $user->setFullName('Mighty Admin');
        $user->setEmail('admin@example.com');
        $user->setPassword(password_hash($password, PASSWORD_BCRYPT));

        $manager->persist($user);
        $manager->flush();

        echo 'Admin password is: '.$password;
    }
}
