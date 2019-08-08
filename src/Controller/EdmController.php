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
}
