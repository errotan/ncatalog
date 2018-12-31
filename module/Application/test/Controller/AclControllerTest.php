<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace ApplicationTest\Controller;

use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AclControllerTest extends AbstractHttpControllerTestCase
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

    public function testIndexActionCanBeAccessed()
    {
        $this->dispatch('/acl', 'GET');
        $this->assertResponseStatusCode(200);
    }

    public function testListActionCanBeAccessed()
    {
        $this->dispatch('/acl/list/1', 'GET');
        $this->assertResponseStatusCode(200);
    }

    public function testEditActionCanBeAccessed()
    {
        $this->dispatch('/acl/edit/1', 'GET');
        $this->assertResponseStatusCode(200);
    }

    public function testNewActionCanBeAccessed()
    {
        $this->dispatch('/acl/new/1', 'GET');
        $this->assertResponseStatusCode(200);
    }

    public function testDeleteActionTryingToDeleteNoneExistent()
    {
        $this->dispatch('/acl/delete/0', 'GET');
        $this->assertResponseStatusCode(404);
    }
}
