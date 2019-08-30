<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Article;
use App\Form\ArticleType;
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
        $users = $repo->findAll();
        return $this->render('admin/users/users.html.twig',[
            'users' => $users
        ]);
    }

    /**
     * Fonction permettant de modifier un utilisateur
     *@Route("/admin/editUser/{id}", name="admin_edit_user")
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
     * @Route("admin/articles", name="admin_articles")
     */

    public function showArticles(ArticleRepository $repo){
        $articles = $repo->findAllByDate();
        return $this->render('admin/articles/articles.html.twig',[
            'articles' => $articles
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

        return $this->redirectToRoute('admin_articles');
    }

    /**
     * @Route("admin/editArticle/{id}", name="admin_edit_article")
     */

    public function editArticle( Article $article, ObjectManager $manager, Request $request){

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($article);
            $manager->flush();
        }

        return $this->render('admin/articles/editArticle.html.twig',[
            'form' => $form->createView(),
            'article' => $article
        ]);
    }

    /**
     * @Route("admin/addArticle", name="admin_addArticle")
     */

    public function addArticle(Request $request, ObjectManager $manager){
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article->setCreatedAt(new \DateTime());

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }

        return $this->render('admin/articles/addArticle.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
