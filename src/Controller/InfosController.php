<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InfosController extends AbstractController
{
    /**
     * @Route("/infos/historique", name="historique")
     */
    public function historique()
    {
        return $this->render('infos/historique.html.twig');
    }

    /**
    *@Route("/infos/mecenat", name="mecenat") 
    */
    public function mecenat()
    {
        return $this->render('infos/mecenat.html.twig');
    }

    /**
    *@Route("/infos/revuePresse", name="revuePresse") 
    */
    public function revuePresse()
    {
        return $this->render('infos/revuePresse.html.twig');
    }
}
