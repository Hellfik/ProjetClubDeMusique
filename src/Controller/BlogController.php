<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     * @param ArticleRepository $repo
     */
    public function blog(ArticleRepository $repo, PaginatorInterface $paginator,Request $request)  
    {
        $articles = $repo->findById();
        $recentArticles = $repo->findThreeMostRecent(); 
        if(isset($_GET['search']) && !empty($_GET['search'])){
            
            $articles = $paginator->paginate($repo->findFilter($_GET['search']),
            $request->query->getInt('page',1),6);

            $search = $_GET['search'];
            $send = true;
        }else{
            $articles = $paginator->paginate(
                $repo->findById(),
                $request->query->getInt('page',1),5
            );
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
    public function show(Article $article, ArticleRepository $repo ){
        $recentArticles = $repo->findThreeMostRecent();
         return $this->render('blog/show.html.twig', [
             'article' => $article,
             'recentArticles' => $recentArticles
         ]);
    }

}
