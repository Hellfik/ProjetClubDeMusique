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
    
    public function contact(Request $request)
    {
    $defaultData = ['message' => 'Type your message here'];
    $form = $this->createFormBuilder($defaultData)
        ->add('email', EmailType::class)
        ->add('message', TextareaType::class)
        ->add('send', SubmitType::class)
        ->getForm();

    // $form->handleRequest($request);

    // if ($form->isSubmitted() && $form->isValid()) {
    //     // data is an array with "name", "email", and "message" keys
    //     $data = $form->getData();
    // }

        return $this->render('contact.html.twig', [
            'form' => $form->createView()

        ]);
    }
    

  
 
}
