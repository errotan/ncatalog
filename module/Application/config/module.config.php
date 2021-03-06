<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'category' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/category/:categoryId',
                    'constraints' => [
                        'categoryId' => '\d+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'category_edit' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/category/edit/:categoryId',
                    'constraints' => [
                        'categoryId' => '\d+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\CategoryController::class,
                        'action'     => 'edit',
                    ],
                ],
            ],
            'category_new' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/category/new/[:parentId]',
                    'constraints' => [
                        'parentId' => '\d+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\CategoryController::class,
                        'action'     => 'new',
                    ],
                ],
            ],
            'category_delete' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/category/delete/:categoryId',
                    'constraints' => [
                        'categoryId' => '\d+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\CategoryController::class,
                        'action'     => 'delete',
                    ],
                ],
            ],
            'file' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/file/:action/:categoryId',
                    'constraints' => [
                        'categoryId' => '\d+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\FileController::class,
                        'action'     => 'upload',
                    ],
                ],
            ],
            'file_download' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/file/download/:fileId',
                    'constraints' => [
                        'fileId' => '\d+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\FileController::class,
                        'action'     => 'download',
                    ],
                ],
            ],
            'file_history' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/file/history/:fileId',
                    'constraints' => [
                        'fileId' => '\d+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\FileController::class,
                        'action'     => 'history',
                    ],
                ],
            ],
            'acl' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/acl',
                    'defaults'    => [
                        'controller' => Controller\AclController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'acl_list' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/acl/list/:userId',
                    'constraints' => [
                        'userId' => '\d+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\AclController::class,
                        'action'     => 'list',
                    ],
                ],
            ],
            'acl_edit' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/acl/edit/:aclId',
                    'constraints' => [
                        'aclId' => '\d+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\AclController::class,
                        'action'     => 'edit',
                    ],
                ],
            ],
            'acl_new' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/acl/new/:userId',
                    'constraints' => [
                        'userId' => '\d+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\AclController::class,
                        'action'     => 'new',
                    ],
                ],
            ],
            'acl_delete' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/acl/delete/:aclId',
                    'constraints' => [
                        'aclId' => '\d+',
                    ],
                    'defaults'    => [
                        'controller' => Controller\AclController::class,
                        'action'     => 'delete',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\AclController::class => Controller\Factory\DefaultControllerFactory::class,
            Controller\CategoryController::class => Controller\Factory\DefaultControllerFactory::class,
            Controller\FileController::class => Controller\Factory\DefaultControllerFactory::class,
            Controller\IndexController::class => Controller\Factory\DefaultControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => false,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__.'/../view/layout/layout.phtml',
            'application/index/index' => __DIR__.'/../view/application/index/index.phtml',
            'error/404'               => __DIR__.'/../view/error/404.phtml',
            'error/index'             => __DIR__.'/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__.'/../view',
        ],
    ],
];
