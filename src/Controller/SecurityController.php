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
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        $errors = $validator->validate($user);
        $errorsString = (string) $errors;


        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Votre compte a bien été créé');
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
        $error = $authenticationUtils->getLastAuthenticationError();
        // Le dernier username entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }


    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(){}
}
