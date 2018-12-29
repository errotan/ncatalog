<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Application\Entity\Category;

/**
 * Contains file lister by category.
 */
class IndexController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em database access object
     *
     * @return void
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

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

            $view->setVariables(['categoryPath' => $categoryPath]);
            $view->setVariables(['categoryId' => $categoryId]);
        }

        return $view;
    }
}
