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
        $recentArticles = $repo->findThreeMostRecent(); 
        return $this->render('blog/blog.html.twig', [
            'articles' => $articles,
            'recentArticles' => $recentArticles
        ]);
    }
    /**
     * @param Article $article
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article, ArticleRepository $repo){
        $recentArticles = $repo->findThreeMostRecent();
         return $this->render('blog/show.html.twig', [
             'article' => $article,
             'recentArticles' => $recentArticles
         ]);
    }

}
