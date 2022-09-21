<?php

namespace App\Controller;

use App\Entity\Articles;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $articles=$doctrine->getRepository(Articles::class)->findBy([],["created_at"=>"desc"]);
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'articles' => $articles,
        ]);
    }
}
