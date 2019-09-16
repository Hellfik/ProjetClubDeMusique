<?php

namespace App\Controller;

use App\Entity\Musiciens;
use App\Form\MusicienType;
use App\Repository\MusiciensRepository;
use Knp\Component\Pager\PaginatorInterface;
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
    *@Route("/admin/musiciens", name="admin_musiciens") 
    */
    public function musiciens(MusiciensRepository $repo) 
    {
        $musiciens = $repo->findAll();
        return $this->render('admin/musiciens/musicien.html.twig', [
            'musiciens' => $musiciens
        ]);
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
        }
        return $this->render('admin/musiciens/addmusicien.html.twig', [
            'formMusicien' => $form->createView()
        ]);
    }
    
    /**
    *@Route("/orchestre/musiciens", name="musiciens") 
    */
    public function listMusicien()
    {
        return $this->render('orchestre/musiciens.html.twig');
    }

        /**
     * Liste tous les utilisateurs enregistrés dans la base de données
     * @Route("/admin/musiciens", name="admin_musiciens")
     */

     public function showMusiciens(MusiciensRepository $repo, PaginatorInterface $paginator, Request $request){
        //Si l'utilisateur a entré une recherche
        if(isset($_GET['search']) && !empty($_GET['search'])){
            //Requete en fonction de la recherche de l'utilisateur
            $musiciens = $paginator->paginate(
                $repo->findFilter($_GET['search']),
                $request->query->getInt('page',1),7
            );

            //Stock la recherche dans une variable
            $search = $_GET['search'];
            //Permet de savoir si une requete SQL a été envoyée
            $send = true;
        }else{
            $musiciens = $paginator->paginate(
                $repo->findAll(),
            $request->query->getInt('page', 1),10
            );
            $search = null;
            $send = false;
        }
        return $this->render('admin/musiciens/musicien.html.twig',[
            'musiciens' => $musiciens,
            'search' => $search,
            'send' => $send
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
