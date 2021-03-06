<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Repository;

/**
 * FileRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FileRepository extends \Doctrine\ORM\EntityRepository
{
    const STOREDIR = 'data/files';

    /**
     * Find already uploaded last file with same name.
     *
     * @param int    $categoryId
     * @param string $originalName
     *
     * @return Application\Entity\File|null
     */
    public function alreadyUploaded($categoryId, $originalName)
    {
        return $this->findOneBy(['category' => $categoryId, 'originalName' => $originalName], ['version' => 'DESC']);
    }

    /**
     * Find already uploaded files with same name.
     *
     * @param int    $categoryId
     * @param string $originalName
     *
     * @return array
     */
    public function alreadyUploadeds($categoryId, $originalName)
    {
        return $this->findBy(['category' => $categoryId, 'originalName' => $originalName]);
    }
}
