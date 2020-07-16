<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ListeFormType;
use App\Form\ListeSupprFormType;
use App\Form\ListeCopyFormType;
use App\Repository\ListeRepository;
use App\Entity\Liste;

/**
* @IsGranted("ROLE_USER")
*/
class ListeController extends AbstractController
{
    /**
     * @Route("/liste", name="app_liste")
     */
    public function index_liste(ListeRepository $repo)
    {
      $form_suppr = $this->createForm(ListeSupprFormType::class);
      $form_creation = $this->createForm(ListeFormType::class);
      $form_copy = $this->createForm(ListeCopyFormType::class);

      return $this->render('liste/liste.html.twig', [
        'listes'=>$repo->findAll(),
        'form_creation'=>$form_creation->createView(),
        'form_suppr'=>$form_suppr->createView(),
        'form_copy'=>$form_copy->createView()
      ]);
    }

    /**
    * @Route("/liste/creation", name="app_liste_creation")
    */
    public function creation_simple(Request $request)
    {
      $form_creation = $this->createForm(ListeFormType::class);
      $form_creation->handleRequest($request);
      if ($form_creation->isSubmitted() && $form_creation->isValid()){
        $liste = new Liste();
        $liste->setNom($form_creation['nom']->getData());
        $liste->setCreateur($this->getUser());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($liste);
        $entityManager->flush();
      }

      return $this->redirectToRoute('app_liste');
    }

    /**
    * @Route("/liste/copier", name="app_liste_copy")
    */
    public function copier_liste(Request $request)
    {
      $form_copy = $this->createForm(ListeCopyFormType::class);
      $form_copy->handleRequest($request);

      if ($form_copy->isSubmitted() && $form_copy->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();

        $liste = $form_copy['listes']->getData();

        $new_liste = clone $liste;
        $new_liste->setNom($form_copy['nom']->getData());
        $new_liste->setCreateur($this->getUser());

        $entityManager->persist($new_liste);

        foreach($liste->getLignes() as $ligne) {
          $new_ligne = clone $ligne;
          $new_ligne->setListe($new_liste);
          $new_liste->addLigne($new_ligne);
          $entityManager->persist($new_ligne);
        }

        $entityManager->flush();
      }

      return $this->redirectToRoute('app_liste');
    }

    /**
    * @Route("/liste/suppression", name="app_liste_suppression")
    */
    public function supprimer_simple(Request $request)
    {
      $form_suppr = $this->createForm(ListeSupprFormType::class);
      $form_suppr->handleRequest($request);

      if ($form_suppr->isSubmitted() && $form_suppr->isValid()){
        $liste = $form_suppr['listes']->getData();

        $entityManager = $this->getDoctrine()->getManager();
        foreach($liste->getLignes() as $ligne) {
          $entityManager->remove($ligne);
        }

        $entityManager->remove($liste);
        $entityManager->flush();
      }

      return $this->redirectToRoute('app_liste');
    }

}
