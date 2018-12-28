<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Application\Entity\User;

class UserFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUserName('admin');
        $user->setFullName('Mighty Admin');
        $user->setEmail('admin@example.com');
        $user->setPassword('');

        $manager->persist($user);
        $manager->flush();
    }
}
