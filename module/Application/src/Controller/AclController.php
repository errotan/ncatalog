<?php

/*
 * Copyright (c) 2018 Puskás Zsolt <errotan@gmail.com>
 * Licensed under the MIT license.
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Application\Entity\Acl;
use Application\Entity\Category;
use Application\Entity\User;
use Application\Controller\AbstractController;

/**
 * Access control list pages.
 */
class AclController extends AbstractController
{
    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $users = $this->em->getRepository(User::class)->findAll();
        $view = new ViewModel(['users' => $users]);
        $view->setTerminal(true);

        return $view;
    }

    /**
     * @return ViewModel
     */
    public function listAction()
    {
        $userId = $this->params()->fromRoute('userId');
        $user = $this->em->find(User::class, $userId);
        $acls = $this->em->getRepository(Acl::class)->findBy(['user' => $userId]);

        $view = new ViewModel(['acls' => $acls, 'user' => $user]);
        $view->setTerminal(true);

        return $view;
    }
}
