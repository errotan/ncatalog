<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace ApplicationTest\Utils;

use PHPUnit\Framework\TestCase;
use Application\Utils\Asset;

class AssetTest extends TestCase
{
    public function setUp()
    {
        Asset::install();
    }

    public function testDirsCreated()
    {
        $this->assertSame(true, is_dir(Asset::CSSDIR));
        $this->assertSame(true, is_dir(Asset::JSDIR));
        $this->assertSame(true, is_dir(Asset::FONTDIR));
    }

    public function testFileMapping()
    {
        $this->assertSame(true, is_file(Asset::CSSDIR.'bootstrap.css') || is_link(Asset::CSSDIR.'bootstrap.css'));
    }
}
