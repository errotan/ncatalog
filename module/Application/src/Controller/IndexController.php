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
            $files = $this->em->getRepository(File::class)->findBy(['category' => $categoryId, 'overriden' => false]);

            $view->setVariables(['categoryPath' => $repository->findPath($categoryId)]);
            $view->setVariables(['categoryId' => $categoryId]);
            $view->setVariables(['files' => $files]);
        }

        return $view;
    }
}
