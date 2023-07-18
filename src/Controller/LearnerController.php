<?php

namespace App\Controller;

use App\Repository\LearnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LearnerController extends AbstractController
{
    #[Route('/learner', name: 'app_learner_index')]
    public function index(LearnerRepository $learnerRepository): Response
    {
        $learners = $learnerRepository->findAll();

        return $this->render('learner/list.html.twig', [
            'learners' => $learners,
        ]);
    }
}
