<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        //$repo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repo->findAll();

        //dd($articles);

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
    * @Route("/", name="home")
    */
    public function home()
    {
    	return $this->render('blog/home.html.twig');
    }

    /**
     * @Route("/new", name="blog_create")
     */

    public function create(Request $request)
    {
       $article = new Article();

       $form = $this->createFormBuilder($article)
                    ->add('title')
                    ->add('content')
                    ->add('image')
                    ->getForm();


        return $this->render('blog/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

     /**
    * @Route("/blog/article/{id}", name="blog_show")
    */
    public function show(Article $article)
    {
       // $repo = $this->getDoctrine()->getRepository(Article::class);

        //$article = $repo->find($id);
    	return $this->render('blog/show.html.twig',['article' => $article]);
    }
}
