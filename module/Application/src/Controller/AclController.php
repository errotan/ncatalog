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

    /**
     * @return ViewModel
     */
    public function editAction()
    {
        $acl = $this->em->find(Acl::class, $this->params()->fromRoute('aclId'));

        if ('POST' === $this->getRequest()->getMethod()) {
            $acl->setCanCreateCategory((bool) $this->params()->fromPost('cancreatecategory'))
                ->setCanUpload((bool) $this->params()->fromPost('canupload'))
                ->setCanDownload((bool) $this->params()->fromPost('candownload'));

            $this->em->persist($acl);
            $this->em->flush();
        }

        $view = new ViewModel(['acl' => $acl]);
        $view->setTerminal(true);

        return $view;
    }

    /**
     * @return ViewModel
     */
    public function newAction()
    {
        // TODO: move work to service class, break up functionality for clean code

        $categories = $this->em->getRepository(Category::class)->findAllAsTree();
        $user = $this->em->find(User::class, $this->params()->fromRoute('userId'));

        if ('POST' === $this->getRequest()->getMethod()) {
            $categoryId = (int) $this->params()->fromPost('category');

            if (0 === $categoryId) {
                $categoryId = null;
            }

            $aclWithSameCategory = $this->em
                ->getRepository(Acl::class)
                ->findBy(['user' => $user->getId(), 'category' => $categoryId]);

            if ($aclWithSameCategory) {
                return $this->getResponse()->setStatusCode(422)->setContent('Már van erre kategóriára beállítás!');
            }

            $acl = (new Acl())
                ->setUser($user)
                ->setCanCreateCategory((bool) $this->params()->fromPost('cancreatecategory'))
                ->setCanUpload((bool) $this->params()->fromPost('canupload'))
                ->setCanDownload((bool) $this->params()->fromPost('candownload'));

            if ($categoryId) {
                // TODO: check category exists
                $acl->setCategory($this->em->find(Category::class, $categoryId));
            }

            $this->em->persist($acl);
            $this->em->flush();
        }

        $view = new ViewModel(['categories' => $categories, 'user' => $user]);
        $view->setTerminal(true);

        return $view;
    }

    /**
     * @return Response
     */
    public function deleteAction()
    {
        $acl = $this->em->getRepository(Acl::class)->find($this->params()->fromRoute('aclId'));

        if ($acl) {
            $this->em->remove($acl);
            $this->em->flush();
        } else {
            // no not found exception in zend :(
            return $this->getResponse()->setStatusCode(404)->setContent('A törlendő jogosultság nem található!');
        }

        return $this->getResponse();
    }
}
