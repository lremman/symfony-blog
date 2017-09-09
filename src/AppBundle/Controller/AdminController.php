<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\BlogPost;
use AppBundle\Form\BlogPostType;

class AdminController extends Controller
{
    /**
     * @Route("/admin/add-article", name="admin_add_article")
     */
    public function getAddArticleAction(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(BlogPostType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $blogPost = $form->getData();
            $blogPost->setCreatedAt();
            $em->persist($blogPost);
            $em->flush();

            $this->addFlash('success', 'The post successfully added to dashboard!');

            return $this->redirectToRoute('admin_add_article');
        }

        return $this->render('admin/add-article.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
