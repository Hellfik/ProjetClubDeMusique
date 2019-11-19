<?php

namespace App\Controller;


use App\Form\UserType;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\FamilleType;
use App\Entity\Instruments;
use App\Form\InstrumentType;
use App\Entity\FamilleInstruments;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\InstrumentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FamilleInstrumentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(UserRepository $repo1, InstrumentsRepository $repo2, FamilleInstrumentsRepository $repo3, ArticleRepository $repo4)
    {
        $fiveLastusers = $repo1->findFiveLastUsers();
        $numberOfUsers = $repo1->numberOfUsers();
        $numberOfInstruments = $repo2->numberOfInstruments();
        $numberOfFamilly = $repo3->numberOfFamilly();
        $numberOfPosts = $repo4->numberOfPosts();

        return $this->render('admin/index.html.twig', [
            'last_users' => $fiveLastusers,
            'users' => $numberOfUsers,
            'instruments' => $numberOfInstruments,
            'familly' => $numberOfFamilly,
            'posts' => $numberOfPosts
        ]);
    }

    /**
     * Liste tous les utilisateurs enregistrés dans la base de données
     * @Route("/admin/users", name="admin_users")
     */

    public function showUsers(UserRepository $repo){
        //Si l'utilisateur a entré une recherche
        if(isset($_GET['search']) && !empty($_GET['search'])){
            //Requete en fonction de la recherche de l'utilisateur
            $users = $repo->findFilter($_GET['search']);
            //Stock la recherche dans une variable
            $search = $_GET['search'];
            //Permet de savoir si une requete SQL a été envoyée
            $send = true;
        }else{
            $users = $repo->findAll();
            $search = null;
            $send = false;
        }
        return $this->render('admin/users/users.html.twig',[
            'users' => $users,
            'search' => $search,
            'send' => $send
        ]);
    }

    /**
     * Fonction permettant de modifier un utilisateur
     * @Route("/admin/user/editUser/{id}", name="admin_edit_user")
     * @param User $user
     * @param ObjectManager $manager
     * @param Request $request
     * 
     */
    public function editUser(User $user, ObjectManager $manager, Request $request){

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'L\'utilisateur a bien été modifié');
            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/users/editUser.html.twig',[
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * Fonction permettant de supprimer un utilisateur
     *
     * @param User $user
     * @param ObjectManager $manager
     * @Route("admin/deleteUser/{id}", name="admin_delete_user")
     */
    public function deleteUser( User $user, ObjectManager $manager){
        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('admin_users');
    }

    /**
     * Liste tous les articles de la base de données
     * @Route("admin/article", name="admin_articles", methods={"GET", "POST"})
     */

    public function showArticles(ArticleRepository $repo){
        if(isset($_POST['search']) && !empty($_POST['search'])){
            $articles = $repo->findFilter($_POST['search']);
            $search = $_POST['search'];
            $send = true;
        }else{
            $articles = $repo->findAllByDate();
            $search = null;
            $send = false;
        }
        
        return $this->render('admin/articles/articles.html.twig',[
            'articles' => $articles,
            'search' => $search,
            'send' => $send,
        ]);
    }

    /**
     * Permet de supprimer un article
     *
     * @param Article $article
     * @param ObjectManager $manager
     * @Route("admin/article/delete/{id}", name="admin_delete_article")
     */
    public function deleteArticle( Article $article, ObjectManager $manager){
        $manager->remove($article);
        $manager->flush();

        $this->addFlash('success', 'L\'historique a bien été supprimé');
        return $this->redirectToRoute('admin_articles');
    }

    /**
     * @Route("admin/article/editArticle/{id}", name="admin_edit_article")
     */

    public function editArticle( Article $article, ObjectManager $manager, Request $request){

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($article);
            $manager->flush();

            $this->addFlash('success', 'L\'article a bien été modifié');
            return $this->redirectToRoute('admin_articles');
        }

        return $this->render('admin/articles/editArticle.html.twig',[
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * @Route("admin/article/addArticle", name="admin_addArticle")
     */

    public function addArticle(Request $request, ObjectManager $manager){
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article->setCreatedAt(new \DateTime());
            
            
            $manager->persist($article);
            $manager->flush();

            $this->addFlash('success', 'L\'article a bien été créé');

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }

        return $this->render('admin/articles/addArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/instruments", name="admin_instruments")
     */

    public function showInstruments(InstrumentsRepository $repo){
        $instruments = $repo->findAll();
        return $this->render('admin/instruments/instruments.html.twig',[
            'instruments' => $instruments
        ]);
    }

    /**
     * @Route("admin/editInstruments/{id}", name="admin_edit_instrument")
     */
    public function editInstrument(Instruments $instrument, ObjectManager $manager, Request $request){

        $form = $this->createForm(InstrumentType::class, $instrument);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($instrument);
            $manager->flush();

            $this->addFlash('success', 'L\'instrument a bien été modifié');
            return $this->redirectToRoute('admin_instruments');
        }

        return $this->render('admin/instruments/editInstrument.html.twig', [
            'form' => $form->createView(),
            'instrument' => $instrument
        ]);

    }

    /**
     * @Route("admin/deleteInstrument/{id}", name="admin_delete_instrument")
     */

     public function deleteInstrument(Instruments $instrument, ObjectManager $manager){
        $manager->remove($instrument);
        $manager->flush();

        $this->addFlash('success', 'L\'instrument a bien été supprimé');
        return $this->redirectToRoute('admin_instruments');
     }

    /**
     * 
     * Fonction qui permet de créer des instruments via un formulaire 
     * @Route("/admin/addInstrument", name="admin_addInstrument")
     * 
     */
    public function addInstrument(Request $request, ObjectManager $manager){
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
            $this->addFlash('success', 'L\'instrument a bien été créé');
            //Une fois l'operation insertion terminée, on est redirigé vers la page des instruments
            return $this->redirectToRoute('instruments');
        }
        return $this->render('admin/instruments/addInstrument.html.twig', [
            'formInstrument' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/familleInstrument", name="admin_famille")
     */
    public function showFamille(FamilleInstrumentsRepository $repo){
        $familles = $repo->findAll();

        return $this->render('admin/familles/familles.html.twig',[
            'familles' => $familles
        ]);
    }

    /**
     * @Route("admin/editFamilleInstruments/{id}", name="admin_editFamilleInstrument")
     */
    public function editFamille(FamilleInstruments $familleInstrument, ObjectManager $manager, Request $request){

        $form = $this->createForm(FamilleType::class, $familleInstrument);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($familleInstrument);
            $manager->flush();

            $this->addFlash('success', 'La famille d\'instrument été modifiée');
            return $this->redirectToRoute('admin_famille');
        }

        return $this->render('admin/familles/editFamilleInstrument.html.twig', [
            'form' => $form->createView(),
            'familleInstrument' => $familleInstrument
        ]);

    }

    /**
     * Undocumented function
     *
     * @param FamilleInstruments $famille
     * @param ObjectManager $manager
     * @Route("admin/deleteFamille/{id}", name="admin_delete_familleInstrument")
     */
    public function deleteFamille(FamilleInstruments $famille, ObjectManager $manager){
        $manager->remove($famille);
        $manager->flush();

        return $this->redirectToRoute('admin_famille');
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @Route("admin/addFamille", name="admin_addFamille")
     */
    public function addFamille(Request $request, ObjectManager $manager){
        $famille = new FamilleInstruments();

        $form = $this->createForm(FamilleType::class, $famille);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($famille);
            $manager->flush();

            $this->addFlash('success', 'La famille d\'instrument a bien été ajoutée');
            return $this->redirectToRoute('admin_famille');
        }

        return $this->render('admin/familles/addFamille.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
