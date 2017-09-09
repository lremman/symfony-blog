<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\BlogPost;

use Symfony\Component\HttpFoundation\JsonResponse;

class BlogController extends Controller
{
    /**
     * @Route("/", name="blog_list")
     */
    public function showListAction(Request $request)
    {
    	$articles = $this->getListItems($request);

        return $this->render('blog/list.html.twig', [
        	'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="blog_list")
     */
    public function ajaxListPaginateAction(Request $request)
    {
        $articles = $this->getListItems($request);

        $html = $this->get('twig')
            ->render('blog/portlets/list-items.html.twig', [
                'articles' => $articles
            ]);

        $hasMorePages = $articles->getPage() < $articles->getPageCount();
        $nextPage = ($articles->getPage() ?: 1) + 1;

        return new JsonResponse ([
            'html' => $html,
            'hasMorePages' => $hasMorePages,
            'nextPage' => $nextPage,
        ], 200);
    }

    /**
     * 
     */
    public function getListItems(Request $request) 
    {
        $entityManager = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT a FROM AppBundle:BlogPost a ORDER BY a.id DESC";
        $query = $entityManager->createQuery($dql);

        $paginator = $this->get('knp_paginator');

        $articles = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $articles;
    }

    /**
     * @Route("/{id}", name="blog_item")
     */
    public function showItemAction($id)
    {
    	$article = $this->getDoctrine()
            ->getRepository(BlogPost::class)
            ->find($id)
        ;

        return $this->render('blog/article.html.twig', [
            'article' => $article
        ]);
    }
}
