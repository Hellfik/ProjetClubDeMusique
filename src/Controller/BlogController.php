<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     *
     */
    public function blog(ArticleRepository $repo)
    {
        $articles = $repo->findById(); 
        return $this->render('blog/blog.html.twig', [
            'articles' => $articles
        ]);
    }
    /**
     * @param Article $article
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article){
         return $this->render('blog/show.html.twig', [
             'article' => $article
         ]);
    }

}
