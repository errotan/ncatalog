<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"unsigned"=true})
     */
    private $parentId;

    /**
     * Get the value of id
     *
     * @return  int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of parentId
     *
     * @return  int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set the value of parentId
     *
     * @param  int  $parentId
     *
     * @return  self
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }
}
