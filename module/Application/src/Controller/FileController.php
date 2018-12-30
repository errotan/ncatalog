<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Controller;

use Zend\Filter\HtmlEntities;
use Zend\View\Model\ViewModel;
use Application\Entity\Category;
use Application\Entity\File;
use Application\Entity\User;
use Application\Controller\AbstractController;
use Application\Repository\FileRepository;

/**
 * Holds methods for file handling.
 */
class FileController extends AbstractController
{
    /**
     * @return ViewModel
     */
    public function uploadAction()
    {
        $view = new ViewModel(['categoryId' => $this->params()->fromRoute('categoryId')]);
        $view->setTerminal(true);

        return $view;
    }

    /**
     * @return Response
     */
    public function storeAction()
    {
        // TODO: move work to service class, break up functionality for clean code

        $uploadedFile = $this->params()->fromFiles('file');

        if (!$uploadedFile) {
            // can't find this kind of exception in zend :(
            return $this->getResponse()->setStatusCode(422)->setContent('Nincs fájl a kérésben!');
        }

        // escape file name
        $filter = new HtmlEntities();
        $originalName = $filter->filter($uploadedFile['name']);

        // load foreign objects
        $categoryId = $this->params()->fromRoute('categoryId');
        $user = $this->em->getRepository(User::class)->find(1); // TODO: id from session
        $category = $this->em->getRepository(Category::class)->find($categoryId);

        // search for files with same name
        $alreadyUploadedFile = $this->em->getRepository(File::class)->alreadyUploaded($categoryId, $originalName);
        $version = 1;

        if ($alreadyUploadedFile) {
            $alreadyUploadedFile->setOverriden(1);

            $this->em->persist($alreadyUploadedFile);

            $version = $alreadyUploadedFile->getVersion() + 1;
        }

        // store file
        $file = new File();
        $file->setUploadedBy($user);
        $file->setCategoryId($category);
        $file->setOriginalName($originalName);
        $file->setDisplayName($originalName);
        $file->setVersion($version);
        $file->setOverriden(0);

        $this->em->persist($file);
        $this->em->flush();

        move_uploaded_file($uploadedFile['tmp_name'], FileRepository::STOREDIR.'/'.$file->getId());

        return $this->getResponse();
    }
}
