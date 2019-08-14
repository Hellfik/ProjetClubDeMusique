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
     * Fonction qui permet de créer des instruments via un formulaire 
     * @Route("/edm/add", name="create_instrument")
     * 
     */
    public function create(Request $request, ObjectManager $manager){
        //Créé une nouvelle instance de la classe Instruments
        $instrument = new Instruments();

        //Créé un formulaire avec les inputs necessaires à la création d'un instrument et le lie à la nouvelle instance
        $form = $this->createForm(InstrumentType::class, $instrument);

        //Permet de gérer la soumission du formulaire
        $form->handleRequest($request);
        
        //Vérifie si le formulaire a été soumis et qu'il est valide
        if($form->isSubmitted() && $form->isValid()){
            
            //Prépare la requete d'insertion en base de données
            $manager->persist($instrument);
            //Insert le nouvel instrument en base
            $manager->flush();
            //Une fois l'operation insertion terminée, on est redirigé vers la page des instruments
            return $this->redirectToRoute('instruments');
        }
        return $this->render('edm/addinstrument.html.twig', [
            'formInstrument' => $form->createView()
        ]);
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
