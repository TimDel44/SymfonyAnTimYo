<?php

namespace App\Controller;

use App\Entity\Personne;
use ContainerFo4qxhk\getDoctrine_Orm_DefaultEntityManager_PropertyInfoExtractorService;
use phpDocumentor\Reflection\Types\AggregatedType;
use App\Form\PersonneSupprimerType;
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

        $sum= $repo->createQueryBuilder('m')
            ->Select('SUM(m.solde)')
            //->From('personne')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('personne/index.html.twig', [
            'Personne' => $personne,
            'Resultat' => $sum,

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

    /**
     * @Route("/personne/supprimer/{id}",name="personne_supprimer")
     */
    public function supprimer($id, Request $request){

        $repo = $this->getDoctrine()->getRepository(Personne::class);
        $personne = $repo->find($id);

        //$form = $this->createForm(PersonneSupprimerType::class, $personne);

        //$form->handleRequest($request);

        /*if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($personne);
            $em->flush();

            return $this->redirectToRoute("personne");
        }*/

        $em = $this->getDoctrine()->getManager();
        $em->remove($personne);
        $em->flush();

        return $this->redirectToRoute("personne");

        /*return $this->render("personne/supprimer.html.twig", [
            "formulaire" => $form->createView(),
            "Personne"=>$personne,
        ]);*/
    }
}
