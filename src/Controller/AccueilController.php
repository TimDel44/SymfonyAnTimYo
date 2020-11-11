<?php

namespace App\Controller;

use App\Entity\Personne;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="personne")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Personne::class);

        $personne = $repo->findAll();
        return $this->render('personne/index.html.twig', [
            'Personne' => $personne,
        ]);
    }
}
