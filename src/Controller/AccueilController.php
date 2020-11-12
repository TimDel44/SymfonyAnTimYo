<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    /**
     * @Route("/personne/ajouter",name="personne_ajouter")
     */
    public function ajouter(Request $request){

        $personne = new Personne();

        $form = $this->createForm(PersonneType::class, $personne);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();

            return $this->redirectToRoute("personne");
        }
        return $this->render("personne/ajouter.html.twig", ["formulaire" => $form->createView()]);
    }

    /**
     * @Route("/personne/modifier/{id}",name="personne_modifier")
     */
    public function modifier($id, Request $request){

        $repo = $this->getDoctrine()->getRepository(Personne::class);
        $personne = $repo->find($id);

        $form = $this->createForm(PersonneType::class, $personne);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();

            return $this->redirectToRoute("personne");
        }
        return $this->render("personne/modifier.html.twig", ["formulaire" => $form->createView()]);
    }
}
