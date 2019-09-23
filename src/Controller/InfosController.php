<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Form\HistoriqueType;
use App\Repository\HistoriqueRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InfosController extends AbstractController
{
    /**
     * @Route("/infos/historique", name="historique")
     * Affiche la page historique
     */
    public function historique(HistoriqueRepository $repo)
    {
        $events = $repo->findAll();
        return $this->render('infos/historique.html.twig',[
            'events' => $events
        ]);
    }

    /**
     * Liste tous les évènements historique dans la BDD
     * @Route("admin/historique", name="admin_historique")
     */
    public function showHistorique(HistoriqueRepository $repo)
    {
        $historique = $repo->findAll();
        return $this->render('admin/historique/historique.html.twig', [
           'historique' => $historique
        ]);
    }

    /**
     *Fonction pour ajouter un évènement et enregistrer dans la BDD
     *@Route("admin/historique/add", name="add_historique")
     *
     * @param ObjectManager $manager
     * @param Request $request
     * @return void
     */
    public function AddHistorique(ObjectManager $manager, Request $request)
    {
        $historique = new Historique;
        $form = $this->createForm(HistoriqueType::class, $historique);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($historique);
            $manager->flush();

            return $this->redirectToRoute('admin_historique');
        }
        return $this->render('admin/historique/addHistorique.html.twig', [
            'formHistorique' => $form->createView()
        ]);
    }

    /**
     * Fonction permettant de modifier un évènement historique
     *@Route("/admin/editHistorique/{id}", name="admin_edit_historique")
     * @param Historique $historique
     * @param ObjectManager $manager
     * @param Request $request
     * 
     */
     public function editHistorique(ObjectManager $manager, Request $request,Historique $historique)
     {
         $form = $this->createForm(HistoriqueType::class, $historique);
         $form->handleRequest($request);
 
         if($form->isSubmitted() && $form->isValid()) {
             $manager->persist($historique);
             $manager->flush();
 
             return $this->redirectToRoute('admin_historique');
         }
 
         return $this->render('admin/historique/editHistorique.html.twig', [
             'form' => $form->createView(),
             'historique' => $historique
         ]);
     }

     /**
     * Fonction permettant de supprimer un évènement historique
     *
     * @param Historique $historique
     * @param ObjectManager $manager
     * @Route("admin/deleteHistorique/{id}", name="admin_delete_historique")
     */
     public function deleteHistorique( Historique $historique, ObjectManager $manager){
        $manager->remove($historique);
        $manager->flush();

        return $this->redirectToRoute('admin_historique');
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
