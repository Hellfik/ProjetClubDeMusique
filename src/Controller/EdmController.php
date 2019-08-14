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
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
     * @Route("/edm/add", name="create_instrument")
     * 
     */
    public function create(Request $request, ObjectManager $manager){
        $instrument = new Instruments();

        $form = $this->createForm(InstrumentType::class, $instrument);

        $form->handleRequest($request);
        dump($instrument);
        if($form->isSubmitted() && $form->isValid()){
    
            $manager->persist($instrument);
            $manager->flush();

            return $this->redirectToRoute('instruments');
        }
        return $this->render('edm/addinstrument.html.twig', [
            'formInstrument' => $form->createView()
        ]);
    }

    /**
     * Undocumented function
     *
     * @param InstrumentsRepository $repo1
     * @param FamilleInstrumentsRepository $repo2
     * @Route("/edm/instruments", name="instruments")
     */
    public function showInstruments(InstrumentsRepository $repo1, FamilleInstrumentsRepository $repo2){

        if(isset($_GET['famille'])){
            $famille = $_GET['famille'];
            $instruments = $repo1->findByFamilly($famille);
        }else{
            $instruments = $repo1->findAll(); 
        }
        $familleInstrument = $repo2->findAll();
        return $this->render('edm/instruments.html.twig',[
            'instruments' => $instruments,
            'familleInstrument' => $familleInstrument
        ]);
    }

}
