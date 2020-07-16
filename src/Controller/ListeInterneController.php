<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ListeFormType;
use App\Form\ListeSupprFormType;
use App\Form\ListeInterneFormType;
use App\Repository\ListeRepository;
use App\Repository\ListeLineRepository;
use App\Entity\ListeLine;

/**
* @IsGranted("ROLE_USER")
*/
class ListeInterneController extends AbstractController
{
    /**
     * @Route("/liste/{id}", name="app_liste_view")
     */
    public function index_liste_view($id, ListeRepository $repo, Request $request)
    {
      $liste = $repo->find($id);

      $new_listeline = new ListeLine();
      $form_creation = $this->createForm(ListeInterneFormType::class, $new_listeline);
      $form_creation->handleRequest($request);

      if ($form_creation->isSubmitted() && $form_creation->isValid()){
        $new_listeline = $form_creation->getData();
        $new_listeline->setListe($liste);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($new_listeline);
        $entityManager->flush();
      }

      return $this->render('liste/view.html.twig', [
        'id'=>$liste->getId(),
        'liste'=>$liste->getNom(),
        'total'=>$liste->getTotal(),
        'data'=>$liste->getLignes(),
        'obligatoires'=>$liste->getNombrebObligatoire(),
        'form_creation'=>$form_creation->createView()
      ]);
    }

    /**
    * @Route("/liste/sprligne/{id}/{idListe}", name="app_liste_lignes_supprimer")
    */
    public function supprimer_ligne_liste($id, $idListe, ListeLineRepository $repo) {
      $ligne = $repo->find($id);
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($ligne);
      $entityManager->flush();

      return $this->redirectToRoute('app_liste_view', ['id'=> $idListe]);
    }

}
