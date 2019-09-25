<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticleRepository $repo)
    {
        $recentArticles = $repo->findThreeMostRecent();
        return $this->render('home/index.html.twig',[
            'recentArticles' => $recentArticles
        ]);
    }
    /**
    *@Route("/contact", name="contact") 
    */
    
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
    $defaultData = ['message' => 'Votre message'];
    $form = $this->createFormBuilder($defaultData)
        ->add('email', EmailType::class)
        ->add('message', TextareaType::class)
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
