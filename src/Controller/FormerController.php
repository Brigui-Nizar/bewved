<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormerController extends AbstractController
{
    #[Route('/former', name: 'app_former_index')]
    public function index(): Response
    {
        return $this->render('former/former.html.twig', [
            'formers' => ['john@mail.com', 'yoda@mail.com'],
        ]);
    }

    #[Route('/skills', name: 'app_former_skill')]
    public function skill(): Response
    {
        return $this->render('former/former.html.twig', [
            'skills' => [[
                'label' => 'Compétences Front',
                'skill' => ['id' => 1, 'label' => 'CSS']
            ]],
        ]);
    }
}
