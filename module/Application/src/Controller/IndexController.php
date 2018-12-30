<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Application\Entity\Category;
use Application\Entity\File;
use Application\Controller\AbstractController;

/**
 * Contains file lister by category.
 */
class IndexController extends AbstractController
{
    /**
     * Home page and file lister.
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $repository = $this->em->getRepository(Category::class);
        $categories = $repository->findAllAsTree();
        $view = new ViewModel(['categories' => $categories]);

        if ($categoryId = $this->params()->fromRoute('categoryId')) {
            $categoryPath = $repository->findPath($categoryId);
            $files = $this->em->getRepository(File::class)->findBy(['categoryId' => $categoryId, 'overriden' => 0]);

            $view->setVariables(['categoryPath' => $categoryPath]);
            $view->setVariables(['categoryId' => $categoryId]);
            $view->setVariables(['files' => $files]);
        }

        return $view;
    }
}
