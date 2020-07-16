<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\BudgetRepository;
use App\Repository\BudgetLineRepository;
use App\Form\BudgetFormType;
use App\Form\BudgetLineFormType;
use App\Form\BudgetMaximumFormType;
use App\Form\BudgetCopyFormType;
use App\Form\BudgetSupprFormType;
use App\Entity\Budget;
use App\Entity\BudgetLine;
use Symfony\Component\HttpFoundation\Request;

/**
* @IsGranted("ROLE_USER")
*/
class BudgetInterneController extends AbstractController
{

    /**
     * @Route("/budget/{id}", name="app_budget_view")
     */
    public function view_budget($id, BudgetRepository $repo, Request $request) {
      $budget = $repo->find($id);
      $new_ligne = new BudgetLine();
      $form = $this->createForm(BudgetLineFormType::class, $new_ligne);
      $form_max = $this->createForm(BudgetMaximumFormType::class);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();

        $budgetLine = $form->getData();
        $entityManager->persist($budgetLine);
        $entityManager->flush();

        $budget->addLigne($budgetLine);
        $entityManager->persist($budget);
        $entityManager->flush();
      }


      return $this->render('budget/view.html.twig',[
        'budget'=>$budget,
        'data'=>$budget->getLignes(),
        'form'=>$form->createView(),
        'form_max'=>$form_max->createView()
      ]);
    }

    /**
    * @Route("/budget/max/{id}", name="app_budget_max")
    */
    public function set_maximum($id, BudgetRepository $repo, Request $request){

      $form = $this->createForm(BudgetMaximumFormType::class);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $max = $form['montant']->getData();

        $budget = $repo->find($id);
        $budget->setMax($max);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($budget);
        $entityManager->flush();
      }

      return $this->redirectToRoute('app_budget_view', ['id' => $id]);
    }

    /**
    * @Route("/budget/sprligne/{id}/{idBudget}", name="app_budget_sprligne")
    */
    public function supprimer_ligne($id, $idBudget, BudgetLineRepository $repo) {
      $ligne = $repo->find($id);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($ligne);
      $entityManager->flush();

      return $this->redirectToRoute('app_budget_view', ['id' => $idBudget]);
    }
}
