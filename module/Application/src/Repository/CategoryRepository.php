<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Repository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Returns a tree like array of all categories.
     *
     * @return array
     */
    public function findAllAsTree()
    {
        $categories = $this->findBy([], ['parent' => 'ASC', 'name' => 'ASC']);
        $childs = [];

        foreach ($categories as $category) {
            $parent = $category->getParent();

            $childs[$parent ? $parent->getId() : 0][] = $category;
        }

        foreach ($categories as $category) {
            if (isset($childs[$category->getId()])) {
                $category->childs = $childs[$category->getId()];
            }
        }

        return $childs[0];
    }

    /**
     * Returns an array which contains the category and parent category names.
     *
     * @param int|null $categoryId
     *
     * @return array
     */
    public function findPath($categoryId)
    {
        if (null === $categoryId) {
            return [];
        }

        $category = $this->find($categoryId);
        $parentName = $this->findPath($category->getParent() ? $category->getParent()->getId() : null);
        $pathName = array_merge($parentName, [$category->getName()]);

        return array_filter($pathName);
    }
}
