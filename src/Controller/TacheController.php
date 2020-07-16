<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Form\TacheFormType;
use App\Repository\TacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

/**
* @IsGranted("ROLE_USER")
*/
class TacheController extends AbstractController
{
    /**
     * @Route("/tache", name="app_tache")
     */
    public function index_tache(TacheRepository $repo, Request $request)
    {
      $tache = new Tache();
      $form = $this->createForm(TacheFormType::class, $tache);

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $tache = $form->getData();
        $tache->setEtat('A faire');
        $tache->setCreation(new \DateTime());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($tache);
        $entityManager->flush();
      }


      return $this->render('tache/tache.html.twig', [
        'form'=>$form->createView(),
        'afaire'=>$repo->findBy(['etat'=>'A faire']),
        'encours'=>$repo->findBy(['etat'=>'En cours']),
        'termines'=>$repo->findBy(['etat'=>'Terminé'])
      ]);
    }

    /**
     * @Route("/tache/{id}", name="app_tache_changement")
     */
    public function changement_etat($id, TacheRepository $repo)
    {
      $entityManager = $this->getDoctrine()->getManager();
      $tache = $repo->find($id);
      $etat = $tache->getEtat();

      if($etat == 'A faire') {
        $tache->setEtat('En cours');
        $tache->setResponsable($this->getUser());
        $entityManager->persist($tache);
      } elseif($etat == 'En cours') {
        $tache->setEtat('Terminé');
        $entityManager->persist($tache);
      } elseif($etat == 'Terminé') {
        $entityManager->remove($tache);
      }
      $entityManager->flush();

      return $this->redirectToRoute('app_tache');
    }

}
