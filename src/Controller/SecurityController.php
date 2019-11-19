<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * Undocumented function
     *@Route("/register", name="security_registration")
     */
    public function register(Request $request, ObjectManager $manager, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder){
        //On crée un objet User
        $user = new User();

        //On relie le formulaire REgistrationType avec l'objet User
        $form = $this->createForm(RegistrationType::class, $user);

        //On hydrate l'objet avec les données entrées par l'utilisateur
        $form->handleRequest($request);

        $errors = $validator->validate($user);
        $errorsString = (string) $errors;

        //On vérifie la conformité des données saisies
        if($form->isSubmitted() && $form->isValid()){
            //On s'assure de bien encoder le mot de passe avant l'insertion en BDD
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($hash);
            //On persist l'objet user
            $manager->persist($user);
            $manager->flush();

            //Affiche un message de succes en cas de réussite
            $this->addFlash('success', 'Votre compte a bien été créé');
            //Redidrige vers la page de login
            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig',[
            'form'=> $form->createView(),
            'errors' => $errorsString
        ]);
    }



     /**
     * @Route("/login", name="security_login")
     */

    public function login(AuthenticationUtils $authenticationUtils){
        // Recupere les erreurs de connexion, s'il y en a
        $errors = $authenticationUtils->getLastAuthenticationError();
        // Le dernier username entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig',[
            'last_username' => $lastUsername,
            'errors' => $errors,
        ]);
    }


    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(){}
}
