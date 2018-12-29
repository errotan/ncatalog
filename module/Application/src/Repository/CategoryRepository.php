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
        $categories = $this->findBy([], ['parentId' => 'ASC', 'name' => 'ASC']);
        $childs = [];

        foreach ($categories as $category) {
            $childs[$category->getParentId()][] = $category;
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
     * @param int $categoryId category id
     *
     * @return array
     */
    public function findPath($categoryId)
    {
        if (0 === $categoryId) {
            return [];
        }

        $category = $this->find($categoryId);
        $pathName = array_merge($this->findPath($category->getParentId()), [$category->getName()]);

        return array_filter($pathName);
    }
}
