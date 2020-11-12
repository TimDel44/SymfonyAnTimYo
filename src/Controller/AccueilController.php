<?php

namespace App\Controller;

use App\Entity\Personne;
use ContainerFo4qxhk\getDoctrine_Orm_DefaultEntityManager_PropertyInfoExtractorService;
use phpDocumentor\Reflection\Types\AggregatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
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
        return $this->render('accueil/index.html.twig', [
            'Personne' => $personne,
            'Resultat' => $sum,

        ]);
    }
}
