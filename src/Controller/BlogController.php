<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog_index')]
    public function index(): Response
    {
        $title = "Learn Symfony 8.1";

        return $this->render('blog/index.html.twig', ['title' => $title]);
    }

    #[Route('/blog/{slug}', name: 'blog.single', methods: ['GET', 'HEAD'])]
    public function single(string $slug): Response
    {
        $title = "Learn Symfony 8.1";

        $slug = $slug;

        return $this->render('blog/index.html.twig', ['title' => $title, 'slug' => $slug]);
    }
}
