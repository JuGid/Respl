<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use App\Form\StockageFormType;

/**
* @IsGranted("ROLE_USER")
*/
class StockageController extends AbstractController
{
    /**
     * @Route("/stockage", name="app_stockage")
     */
    public function index_stockage()
    {
      $stockage_form = $this->createForm(StockageFormType::class);

      return $this->render('stockage/stockage.html.twig', [
        'stockage_form' => $stockage_form->createView()
      ]);
    }

}
