<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

return [
    'doctrine' => [
        'driver' => [
            'my_annotation_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__.'/../../module/Application/src/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'Application\Entity' => 'my_annotation_driver',
                ],
            ],
        ],
    ],
];
