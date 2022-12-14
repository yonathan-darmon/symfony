<?php

namespace App\Controller;

use App\Entity\Articles;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {
        $page=$request->query->getInt('page',1);
        $data=$doctrine->getRepository(Articles::class)->findBy([],["created_at"=>"desc"]);
       
        $articles=$paginator->paginate($data,$page,6);
    
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'articles' => $articles,
        ]);
    }
}
