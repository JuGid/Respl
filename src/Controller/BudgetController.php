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
class BudgetController extends AbstractController
{
    /**
     * @Route("/budget", name="app_budget")
     */
    public function index_budget(BudgetRepository $repo, Request $request)
    {
      $form_copy = $this->createForm(BudgetCopyFormType::class);
      $form_suppr = $this->createForm(BudgetSupprFormType::class);

      $new_budget = new Budget();
      $form = $this->createForm(BudgetFormType::class, $new_budget);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $budget = $form->getData();
        $budget->setMax(0);
        $budget->setCreateur($this->getUser());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($budget);
        $entityManager->flush();

      }

      return $this->render('budget/budget.html.twig', [
        'budgets'=>$repo->findAll(),
        'form'=>$form->createView(),
        'form_copy'=>$form_copy->createView(),
        'form_suppr'=>$form_suppr->createView()
      ]);
    }

    /**
    * @Route("/budget/copier", name="app_budget_copy")
    */
    public function copier_budget(Request $request)
    {
      $form_copy = $this->createForm(BudgetCopyFormType::class);
      $form_copy->handleRequest($request);

      if ($form_copy->isSubmitted() && $form_copy->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();

        $budget = $form_copy['budgets']->getData();

        $new_budget = clone $budget;
        $new_budget->setNom($form_copy['nom']->getData());
        $new_budget->setCreateur($this->getUser());
        
        $entityManager->persist($new_budget);

        foreach($budget->getLignes() as $ligne) {
          $new_ligne = clone $ligne;
          $new_ligne->setBudget($new_budget);
          $new_budget->addLigne($new_ligne);
          $entityManager->persist($new_ligne);
        }

        $entityManager->flush();
      }

      return $this->redirectToRoute('app_budget');
    }

    /**
    * @Route("/budget/supprimer", name="app_budget_suppr")
    */
    public function supprimer_budget(Request $request){
      $form_suppr = $this->createForm(BudgetSupprFormType::class);
      $form_suppr->handleRequest($request);

      if ($form_suppr->isSubmitted() && $form_suppr->isValid()) {
        $budget = $form_suppr['budgets']->getData();

        $entityManager = $this->getDoctrine()->getManager();
        foreach($budget->getLignes() as $ligne) {
          $entityManager->remove($ligne);
        }

        $entityManager->remove($budget);
        $entityManager->flush();
      }

      return $this->redirectToRoute('app_budget');
    }
}
