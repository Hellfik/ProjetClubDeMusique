<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OrchestreController extends AbstractController
{
    /**
   *@Route("/orchestre/sortiesAnnuelles", name="sortiesAnnuelles") 
   */
   public function sortiesAnnuelles()
   {
       return $this->render('orchestre/sortiesAnnuelles.html.twig');
   }

     /**
    *@Route("/orchestre/musiciens", name="musiciens") 
    */
    public function musiciens()
    {
        return $this->render('orchestre/musiciens.html.twig');
    }

    /**
    *@Route("/orchestre/documentsInscription", name="documentsInscription") 
    */
    public function documentsInscription()
    {
        return $this->render('orchestre/documentsInscription.html.twig');
    }

    /**
    *@Route("/orchestre/tarifsOrchestre", name="tarifsOrchestre") 
    */
    public function tarifsOrchestre()
    {
        return $this->render('orchestre/tarifsOrchestre.html.twig');
    }

    
   

}
