<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    /**
     * @Route("/footer", name="planDuSite")
     */
    public function planDuSite()
    {
        return $this->render('footer/planDuSite.html.twig', [
            'controller_name' => 'FooterController',
        ]);
    }
}
