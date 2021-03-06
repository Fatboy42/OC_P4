<?php

namespace ML\FrontBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use ML\FrontBundle\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ML\FrontBundle\CheckQuantity\MLCheckQuantity;




class RecapController extends Controller
{
  /**
  *@param Request
  *Display the reservation stored in the session
  *At multiple times we check if the number of selected tickets + sale tickets number =< 1000.
  */

 public function viewRecapAction(Request $request, MLCheckQuantity $soldQuantityService)
  {
    $session = $request->getSession()->get('reservation');
    if ($session)
    {
      //$soldQuantityService = $this->get('ml_frontbundle.checkquantity');
      $var = $soldQuantityService->quantityChecker($session->getDateform());
    }
    else
    {
      return $this->redirectToRoute('ml_front_homepage');
    }
    //$soldQuantityService = $this->get('ml_frontbundle.checkquantity');
    //$var = $soldQuantityService->quantityChecker($session->getDateform());

    if ($session)
    {
      if ($var)
      {
        $tickets = $session->getTickets()->count();//nombre de billets souhaités
        $quantity = $var->getSoldquantity();//nombre de billets vendus
        if ($tickets + $quantity > 1000)
        {
          $this->addFlash('alert', 'Quantité de billets insuffisante pour la date selectionnée, choisissez en une autre.');
          return $this->redirectToRoute('ml_front_modif');
          # redirection vers la page de modif avec message flash
        }
        else
        {
          return $this->render('/Reservation/recap.html.twig', array(
            'reservation' => $session,
          ));

          //dump($session);
        }
      }
      else {
        return $this->render('/Reservation/recap.html.twig', array(
          'reservation' => $session,
        ));

        //dump($session);
      }

    }

    else
    {
      return $this->redirectToRoute('ml_front_homepage');
    }

  }
}






