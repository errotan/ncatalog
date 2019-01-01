<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Controller;

use Zend\Filter\HtmlEntities;
use Zend\View\Model\ViewModel;
use Zend\Http\Response\Stream;
use Zend\Http\Headers;
use Application\Entity\Acl;
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

        if (!$this->em->getRepository(Acl::class)->canUpload(1, $categoryId)) {
            return $this->getResponse()->setStatusCode(403)->setContent('Nincs jogosultsága a művelethez!');
        }

        // search for files with same name
        $alreadyUploadedFile = $this->em->getRepository(File::class)->alreadyUploaded($categoryId, $originalName);
        $version = 1;

        if ($alreadyUploadedFile) {
            $alreadyUploadedFile->setOverriden(true);

            $this->em->persist($alreadyUploadedFile);

            $version = $alreadyUploadedFile->getVersion() + 1;
        }

        // store file
        $file = (new File())
            ->setUploadedBy($user)
            ->setCategory($category)
            ->setOriginalName($originalName)
            ->setDisplayName($originalName)
            ->setVersion($version)
            ->setOverriden(false);

        $this->em->persist($file);
        $this->em->flush();

        move_uploaded_file($uploadedFile['tmp_name'], FileRepository::STOREDIR.'/'.$file->getId());

        return $this->getResponse();
    }

    /**
     * @return Response
     */
    public function downloadAction()
    {
        $fileId = $this->params()->fromRoute('fileId');
        $path = FileRepository::STOREDIR.'/'.$fileId;
        $file = $this->em->getRepository(File::class)->find($fileId);

        if (!is_readable($path) || !$file) {
            // no not found exception in zend :(
            return $this->getResponse()->setStatusCode(404)->setContent('A kért fájl nem található!');
        }

        if (!$this->em->getRepository(Acl::class)->canUpload(1, $file->getCategory()->getId())) {
            return $this->getResponse()->setStatusCode(403)->setContent('Nincs jogosultsága a művelethez!');
        }

        $response = new Stream();
        $response->setStream(fopen($path, 'r'));
        $response->setStatusCode(200);
        $response->setStreamName($file->getOriginalName());

        $headers = new Headers();
        $headers->addHeaders([
            'Content-Disposition' => 'attachment; filename="'.$file->getOriginalName().'"',
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => filesize($path),
            'Expires' => '@0',
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public',
        ]);

        $response->setHeaders($headers);

        return $response;
    }

    /**
     * @return ViewModel
     */
    public function historyAction()
    {
        $file = $this->em->getRepository(File::class)->find($this->params()->fromRoute('fileId'));

        if (!$file) {
            // no not found exception in zend :(
            return $this->getResponse()->setStatusCode(404)->setContent('A kért fájl történet nem található!');
        }

        $files = $this->em
            ->getRepository(File::class)
            ->alreadyUploadeds($file->getCategory()->getId(), $file->getOriginalName());

        $view = new ViewModel(['files' => $files]);
        $view->setTerminal(true);

        return $view;
    }
}
