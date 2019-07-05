<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index()
    {
        return $this->render('base/base-front.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    /**
     * @Route("/admin", name="admin_home")
     */
    public function admin()
    {
        return $this->render('base/base-admin.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
