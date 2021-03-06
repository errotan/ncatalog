<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Controller;

use Zend\Filter\HtmlEntities;
use Zend\View\Model\ViewModel;
use Application\Entity\Acl;
use Application\Entity\Category;
use Application\Controller\AbstractController;

/**
 * Holds methods for category manipulation.
 */
class CategoryController extends AbstractController
{
    /**
     * @return ViewModel|Response
     */
    public function editAction()
    {
        $view = new ViewModel();
        $view->setTerminal(true);

        $categoryId = $this->params()->fromRoute('categoryId');
        $category = $this->em->find(Category::class, $categoryId);

        if (!$category) {
            // no not found exception in zend :(
            return $this->getResponse()->setStatusCode(404)->setContent('A kért kategória nem található!');
        }

        if ('POST' === $this->getRequest()->getMethod()) {
            if (!$this->em->getRepository(Acl::class)->canUpload(1, $category->getId())) {
                return $this->getResponse()->setStatusCode(403)->setContent('Nincs jogosultsága a művelethez!');
            }

            $filter = new HtmlEntities();
            $category->setName($filter->filter($this->params()->fromPost('name')));

            $this->em->persist($category);
            $this->em->flush();
        }

        $view->setVariables(['category' => $category]);

        return $view;
    }

    /**
     * @return ViewModel
     */
    public function newAction()
    {
        $parentId = $this->params()->fromRoute('parentId');
        $view = new ViewModel(['parentId' => $parentId]);
        $view->setTerminal(true);

        if ('POST' === $this->getRequest()->getMethod()) {
            if (!$this->em->getRepository(Acl::class)->canUpload(1, $parentId)) {
                return $this->getResponse()->setStatusCode(403)->setContent('Nincs jogosultsága a művelethez!');
            }

            $filter = new HtmlEntities();
            $category = (new Category())
                ->setName($filter->filter($this->params()->fromPost('name')));

            if ($parentId) {
                $parentCategory = $this->em->find(Category::class, $parentId);
                $category->setParent($parentCategory);
            }

            $this->em->persist($category);
            $this->em->flush();
        }

        return $view;
    }

    /**
     * @return Response
     */
    public function deleteAction()
    {
        $category = $this->em->find(Category::class, $this->params()->fromRoute('categoryId'));

        if ($category) {
            if (!$this->em->getRepository(Acl::class)->canUpload(1, $category->getId())) {
                return $this->getResponse()->setStatusCode(403)->setContent('Nincs jogosultsága a művelethez!');
            }

            $this->em->remove($category);
            $this->em->flush();
        } else {
            // no not found exception in zend :(
            return $this->getResponse()->setStatusCode(404)->setContent('A törlendő kategória nem található!');
        }

        return $this->getResponse();
    }
}
