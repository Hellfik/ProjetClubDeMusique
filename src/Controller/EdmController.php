<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EdmController extends AbstractController
{
    /**
     * @Route("/edm/professeur", name="professeur")
     */
    public function showTeacher()
    {
        return $this->render('edm/professeur.html.twig');
    }

    /**
     *@Route("/edm/instrusments", name="instruments")
     */
    public function showInstruments(){
        return $this->render('edm/instruments.html.twig');
    }
}
