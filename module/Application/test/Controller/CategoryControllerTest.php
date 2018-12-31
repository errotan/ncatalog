<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace ApplicationTest\Controller;

use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class CategoryControllerTest extends AbstractHttpControllerTestCase
{
    public function setUp()
    {
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__.'/../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();
    }

    public function testEditActionCanBeAccessed()
    {
        $this->dispatch('/category/edit/1', 'GET');
        $this->assertResponseStatusCode(200);
    }

    public function testEditActionNotFound()
    {
        $this->dispatch('/category/edit/0', 'GET');
        $this->assertResponseStatusCode(404);
    }

    public function testNewActionCanBeAccessed()
    {
        $this->dispatch('/category/new/1', 'GET');
        $this->assertResponseStatusCode(200);
    }

    public function testDeleteActionTryingToDeleteNoneExistent()
    {
        $this->dispatch('/category/delete/0', 'GET');
        $this->assertResponseStatusCode(404);
    }
}
