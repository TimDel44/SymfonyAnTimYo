<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavbarController extends AbstractController
{
    public function navbar()
    {
        return $this->render('navbar/navbar.html.twig', [
            'navbar' => 'NavbarController',
        ]);
    }
}
