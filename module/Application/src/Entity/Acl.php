<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Application\Repository\AclRepository")
 */
class Acl
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", options={"unsigned"=true})
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userId",nullable=false,onDelete="CASCADE")
     */
    private $user;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="categoryId",onDelete="CASCADE")
     */
    private $category;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $canCreateCategory;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $canUpload;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $canDownload;

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @param User $user
     *
     * @return self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @param Category $category
     *
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of canCreateCategory
     *
     * @return bool
     */
    public function getCanCreateCategory()
    {
        return $this->canCreateCategory;
    }

    /**
     * Set the value of canCreateCategory
     *
     * @param bool $canCreateCategory
     *
     * @return self
     */
    public function setCanCreateCategory($canCreateCategory)
    {
        $this->canCreateCategory = $canCreateCategory;

        return $this;
    }

    /**
     * Get the value of canUpload
     *
     * @return bool
     */
    public function getCanUpload()
    {
        return $this->canUpload;
    }

    /**
     * Set the value of canUpload
     *
     * @param bool $canUpload
     *
     * @return self
     */
    public function setCanUpload($canUpload)
    {
        $this->canUpload = $canUpload;

        return $this;
    }

    /**
     * Get the value of canDownload
     *
     * @return bool
     */
    public function getCanDownload()
    {
        return $this->canDownload;
    }

    /**
     * Set the value of canDownload
     *
     * @param bool $canDownload
     *
     * @return self
     */
    public function setCanDownload($canDownload)
    {
        $this->canDownload = $canDownload;

        return $this;
    }
}
