<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article_all")
     */
    public function all(Request $request, EntityManagerInterface $em)
    {
        $repo = $em->getRepository(Article::class);
        $articles = $repo->findAll();

        return $this->render('article/article_all.html.twig', [
            'articles' => $articles,
        ]);
    }


    /**
     * @Route("/article/new", name="article_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $em)
    {
        if ($request->isMethod('POST')){
            $article = new Article();
            $article->setTitle($request->request->get('title'));
            $article->setSlug(str_replace(' ', '-', $request->request->get('title')));
            $article->setContent($request->request->get('content'));

            if ($request->request->has('publishedAt')){
                $article->setPublishedAt(new \DateTime());
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_show',
                ['id' => $article->getId()]
            );
        }

        $repo = $em->getRepository(Category::class);
        $categories = $repo->findAll();
        return $this->render('article/article_new.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     * @param string $slug
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function show($id, EntityManagerInterface $em)
    {
        //dump($id);die;
        $repo = $em->getRepository(Article::class);
        $article = $repo->find(['id' => str_replace('-', ' ', $id)]);

        if (!$article){
            throw $this->createNotFoundException(sprintf('No article found $s', $id));
        }


        return $this->render('article/article_show.html.twig', [
            'article' => $article,
        ]);
    }
}
