<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Controller;

use Zend\Filter\HtmlEntities;
use Zend\View\Model\ViewModel;
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
        $category = $this->em->getRepository(Category::class)->find($categoryId);

        if (!$category) {
            // no not found exception in zend :(
            return $this->getResponse()->setStatusCode(404)->setContent('A kért kategória nem található!');
        }

        $view->setVariables(['category' => $category]);

        if ('POST' === $this->getRequest()->getMethod()) {
            $filter = new HtmlEntities();
            $category->setName($filter->filter($this->params()->fromPost('name')));

            $this->em->persist($category);
            $this->em->flush();
        }

        return $view;
    }

    /**
     * @return ViewModel
     */
    public function newAction()
    {
        $view = new ViewModel(['parentId' => $this->params()->fromRoute('parentId')]);
        $view->setTerminal(true);

        if ('POST' === $this->getRequest()->getMethod()) {
            $filter = new HtmlEntities();
            $category = new Category();
            $category->setName($filter->filter($this->params()->fromPost('name')));
            $category->setParentId($this->params()->fromRoute('parentId'));

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
        $category = $this->em->getRepository(Category::class)->find($this->params()->fromRoute('categoryId'));

        if ($category) {
            $this->em->remove($category);
            $this->em->flush();
        }

        return $this->getResponse();
    }
}
