<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ComptabiliteLine;
use App\Repository\ComptabiliteRepository;
use App\Repository\ComptabiliteLineRepository;
use App\Form\ComptaLineFormType;

/**
* @IsGranted("ROLE_USER")
*/
class ComptabiliteInteController extends AbstractController
{
    /**
     * @Route("/comptabilite/{id}", name="app_comptabilite_view")
     */
    public function index_comptabilite_view($id, ComptabiliteRepository $repo, Request $request)
    {
      $comptabilite = $repo->find($id);

      $form_line = $this->createForm(ComptaLineFormType::class);
      $form_line->handleRequest($request);

      if ($form_line->isSubmitted() && $form_line->isValid()){
        $ligne = $form_line->getData();
        $ligne->setComptabilite($comptabilite);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($ligne);
        $entityManager->flush();
      }

      return $this->render('comptabilite/view.html.twig',[
        'lignes'=>$comptabilite->getLignes(),
        'total'=>$comptabilite->getTotal(),
        'idComptabilite'=>$comptabilite->getId(),
        'form_line'=>$form_line->createView()
      ]);
    }

    /**
    * @Route("/comptabilite/sprligne/{id}/{idComptabilite}", name="app_comptabilite_lignes_supprimer")
    */
    public function supprimer_ligne_comptabilite($id, $idComptabilite, ComptabiliteLineRepository $repo) {
      $ligne = $repo->find($id);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($ligne);
      $entityManager->flush();

      return $this->redirectToRoute('app_comptabilite_view', ['id'=> $idComptabilite]);
    }

}
