<?php

namespace App\Controller;

use App\Entity\Musiciens;
use App\Form\MusicienType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     *@Route("admin/musiciens/add", name="add_musicien")
     *
     * @param ObjectManager $manager
     * @param Request $request
     * @return void
     */
    public function addmusicien(ObjectManager $manager, Request $request)
    {
        $musicien = new Musiciens;
        $form = $this->createForm(MusicienType::class, $musicien);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($musicien);
            $manager->flush();
            return $this->redirectToRoute('musiciens');
        }
        return $this->render('admin/musiciens/addmusicien.html.twig', [
            'formMusicien' => $form->createView()
        ]);
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
