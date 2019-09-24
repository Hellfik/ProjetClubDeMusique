<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
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
    public function contact()
    {
        return $this->render('contact.html.twig');
    }

  
 
}
