<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
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
    
    public function contact(Request $request ,\Swift_Mailer $mailer)
    {
    $defaultData = ['message' => 'Type your message here'];
    $form = $this->createFormBuilder($defaultData)
        ->add('email', EmailType::class)
        ->add('message', TextareaType::class)
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('send@example.com')
        ->setTo('lecoutrestephane@outlook.com')
        ->setBody('You should see me from the profiler!')
    ;
        dump($message);
        $mailer->send($message);
    }

        return $this->render('contact.html.twig', [
            'form' => $form->createView()

        ]);
    }
    

  
 
}
