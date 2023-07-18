<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    #[Route('/skill', name: 'app_skill')]
    public function index(): Response
    {
        return $this->render('skill/index.html.twig', [
            'controller_name' => 'SkillController',
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
