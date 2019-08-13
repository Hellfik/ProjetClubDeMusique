<?php

namespace App\Controller;

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

    /**
    *@Route("/ficheTechnique", name="ficheTechnique") 
    */
    public function ficheTechnique()
    {
        return $this->render('ficheTechnique.html.twig');
    }

    /**
    *@Route("/historique", name="historique") 
    */

    public function historique()
    {
        return $this->render('historique.html.twig');
    }

    
}
