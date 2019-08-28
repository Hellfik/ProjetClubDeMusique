<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\ArticleRepository;
use App\Repository\FamilleInstrumentsRepository;
use App\Repository\InstrumentsRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/admin/users", name="admin_users")
     */

    public function showUsers(UserRepository $repo){
        $users = $repo->findAll();
        return $this->render('admin/users/users.html.twig',[
            'users' => $users
        ]);
    }

    /**
     * 
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
     * Undocumented function
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
}
