<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Comment;
use App\Form\CommentFormType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/page', name: 'page')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $comments = new Comment();
        $comments->setUser($this->getUser());
        $page = $request->query->get('id');
        $article = $doctrine->getRepository(Articles::class)->find($page);
        $comment = $doctrine->getRepository(Comment::class)->findBy(["articles" => $article]);
        $form = $this->createForm(CommentFormType::class, $comments);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comments->setCreatedAt(new DateTime);
            $comments->setArticles($article);
            $doctrine->getManager()->persist($comments);
            $doctrine->getManager()->flush();

        }
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
            'article' => $article,
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }
}
