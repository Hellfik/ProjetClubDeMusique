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
     * @param ArticleRepository $repo
     */
    public function blog(ArticleRepository $repo)  
    {
        $articles = $repo->findById();
        $recentArticles = $repo->findThreeMostRecent(); 
        if(isset($_GET['search']) && !empty($_GET['search'])){
            $articles = $repo->findFilter($_GET['search']);
            $search = $_GET['search'];
            $send = true;
        }else{
            $articles = $repo->findAllByDate();
            $search = null;
            $send = false;
        }
        return $this->render('blog/blog.html.twig', [
            'articles' => $articles,
            'recentArticles' => $recentArticles,
            'search' => $search,
            'send' => $send
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
