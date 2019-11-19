<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    
    /**
    *@Route("/contact", name="contact") 
    */
    
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
    
    $form = $this->createFormBuilder()
        ->add('email', EmailType::class, [
            'attr' => [
                'placeholder' => 'Votre email']
        ])
        ->add('message', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Votre message']
        ])
        ->getForm();

     $form->handleRequest($request);

     if ($form->isSubmitted() && $form->isValid()) {
        
        $contact = $form->getData();

        $message = (new \Swift_Message('Email bien evoyé!'))
            ->setFrom($contact['message'])
            ->setTo('lecoutrestephane@outlook.com')
            ->setBody($contact['message'], 'text/plain');

            $mailer->send($message);

            return $this->redirectToRoute('contact');

     }

        return $this->render('contact.html.twig', [
            'form' => $form->createView()

        ]);
    }
    

  
 
}
