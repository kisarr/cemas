<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/blog/article/{id}/edit", name="blog_edit")
     */

    public function form(Article $article = null, Request $request, ObjectManager $manager)
    {
       if($article === null){
        $article = new Article();
       }
        
       /* $article->setTitle("Titre de l'exemple")
                ->setContent("Contenu de l'article exemple")
                ->setImage("http://placehold.it/350x150"); */

     /*   $form = $this->createFormBuilder($article)
                    ->add('title')
                    ->add('content')
                    ->add('image')
                    ->getForm(); */
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if(!$article->getId()){
            $article->setCreatedAt(new \DateTime());
            }
            //dd($article);
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('blog_show', [
                'id' => $article->getId()
                ]);
        };

        return $this->render('blog/create.html.twig', [
            'form' => $form->createView(),
            'editMode' => $article->getId() !== null
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
