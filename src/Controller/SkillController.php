<?php

namespace App\Controller;

use App\Repository\SkillGroupRepository;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    #[Route('/skill', name: 'app_skill_index')]
    public function index(SkillGroupRepository $skillRepository): Response
    {
        $skills = $skillRepository->findAll();

        return $this->render('skill/list.html.twig', [
            'skills' => $skills,
        ]);
    }
}
