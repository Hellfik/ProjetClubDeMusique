<?php

namespace App\Controller;


use App\Entity\Instruments;
use App\Form\InstrumentType;
use App\Repository\FamilleInstrumentsRepository;
use App\Repository\InstrumentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class EdmController extends AbstractController
{
    /**
     * Return le rendu de la pages des professeurs
     * 
     * @Route("/edm/professeur", name="professeur")
     */
    public function showTeacher()
    {
        return $this->render('edm/professeur.html.twig');
    }

    /**
     * 
     *
     * @param InstrumentsRepository $repo1
     * @param FamilleInstrumentsRepository $repo2
     * @Route("/edm/instruments", name="instruments")
     */
    public function showInstruments(InstrumentsRepository $repo1, FamilleInstrumentsRepository $repo2){

        if(isset($_GET['famille']) && $_GET['famille'] <= $repo2->numberOfFamilly() && $_GET['famille'] > 0){
            $nrFamille = $_GET['famille'];
            $instruments = $repo1->findByFamilly($nrFamille);
        }else{
            $instruments = $repo1->findAll();
            $nrFamille = null;
        }
        $familleInstrument = $repo2->findAll();
        return $this->render('edm/instruments.html.twig',[
            'instruments' => $instruments,
            'familleInstrument' => $familleInstrument,
            'nrFamille' => $nrFamille
        ]);
    }

}
