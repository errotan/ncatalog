<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Repository;

use Application\Entity\Category;

/**
 * AclRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AclRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param int $userId
     * @param int $categoryId
     *
     * @return bool
     */
    public function canUpload($userId, $categoryId)
    {
        $match = $this->findParentMatch($userId, $categoryId);

        return $match ? $match->getCanUpload() : false;
    }

    /**
     * @param int $userId
     * @param int $categoryId
     *
     * @return bool
     */
    public function canDownload($userId, $categoryId)
    {
        $match = $this->findParentMatch($userId, $categoryId);

        return $match ? $match->getCanDownload() : false;
    }

    /**
     * Find closest acl or parent acl that matches category for user.
     *
     * @param int $userId
     * @param int $categoryId
     *
     * @return Acl|null
     */
    private function findParentMatch($userId, $categoryId)
    {
        // try current category
        $match = $this->findOneBy(['user' => $userId, 'category' => $categoryId]);

        if ($match) {
            return $match;
        }

        // null is the root, no acl found
        if (null === $categoryId) {
            return null;
        }

        // fetch parent category
        $parentCategoryId = null;

        if (null !== $categoryId) {
            $parentCategoryId = $this->getEntityManager()->find(Category::class, $categoryId)->getParent();

            if ($parentCategoryId) {
                $parentCategoryId = $parentCategoryId->getId();
            }
        }

        // try finding parent
        $match = $this->findParentMatch($userId, $parentCategoryId);

        return $match ? $match : null;
    }
}
