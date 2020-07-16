<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ComptabiliteRepository;
use App\Entity\Comptabilite;
use App\Entity\ComptabiliteLine;
use App\Form\ComptaCreateFromFormType;
use App\Form\ComptaFormType;
use App\Form\ComptaSupprFormType;

/**
* @IsGranted("ROLE_USER")
*/
class ComptabiliteController extends AbstractController
{
    /**
     * @Route("/comptabilite", name="app_comptabilite")
     */
    public function index_comptabilite(ComptabiliteRepository $repo)
    {
      $form_from = $this->createForm(ComptaCreateFromFormType::class);
      $form_creation = $this->createForm(ComptaFormType::class);
      $form_suppr = $this->createForm(ComptaSupprFormType::class);

      return $this->render('comptabilite/comptabilite.html.twig',[
        'comptabilite'=>$repo->findAll(),
        'form_from'=>$form_from->createView(),
        'form_creation'=>$form_creation->createView(),
        'form_suppr'=>$form_suppr->createView()
      ]);
    }

    /**
    * @Route("/comptabilite/creation", name="app_comptabilite_creation")
    */
    public function creation_simple(Request $request)
    {
      $form_creation = $this->createForm(ComptaFormType::class);
      $form_creation->handleRequest($request);
      if ($form_creation->isSubmitted() && $form_creation->isValid()){
        $comptabilite = new Comptabilite();
        $comptabilite->setNom($form_creation['nom']->getData());
        $comptabilite->setCreateur($this->getUser());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($comptabilite);
        $entityManager->flush();
      }

      return $this->redirectToRoute('app_comptabilite');
    }

    /**
    * @Route("/comptabilite/suppression", name="app_comptabilite_suppression")
    */
    public function supprimer_simple(Request $request)
    {
      $form_suppr = $this->createForm(ComptaSupprFormType::class);
      $form_suppr->handleRequest($request);

      if ($form_suppr->isSubmitted() && $form_suppr->isValid()){
        $comptabilite = $form_suppr['comptabilites']->getData();

        $entityManager = $this->getDoctrine()->getManager();
        foreach($comptabilite->getLignes() as $ligne) {
          $entityManager->remove($ligne);
        }

        $entityManager->remove($comptabilite);
        $entityManager->flush();
      }

      return $this->redirectToRoute('app_comptabilite');
    }

    /**
    * @Route("/comptabilite/from", name="app_comptabilite_from")
    */
    public function creer_depuis_budget(Request $request)
    {
      $form_from = $this->createForm(ComptaCreateFromFormType::class);
      $form_from->handleRequest($request);

      if ($form_from->isSubmitted() && $form_from->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();

        $nom = $form_from['nom']->getData();
        $budget = $form_from['budgets']->getData();

        $comptabilite = new Comptabilite();
        $comptabilite->setNom($nom);
        $comptabilite->setCreateur($this->getUser());

        $entityManager->persist($comptabilite);

        foreach($budget->getLignes() as $ligne) {
          $temp_ligne = new ComptabiliteLine();
          $temp_ligne->setPassif($ligne->getMontant());
          $temp_ligne->setComptabilite($comptabilite);
          $temp_ligne->setNom($ligne->getNom());
          $entityManager->persist($temp_ligne);
        }

        $entityManager->flush();
      }

      return $this->redirectToRoute('app_comptabilite');
    }
}
