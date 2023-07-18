<?php

namespace App\Controller;

use App\Entity\Learner;
use App\Form\LearnerType;
use App\Repository\LearnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * create Learner
     */
    #[Route('/learner/create', name: 'app_learner_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $learner = new Learner;

        $form = $this->createForm(LearnerType::class, $learner);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('learner/createLearner.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        $learner = $form->getData();

        $entityManager->persist($learner);
        $entityManager->flush();

        return $this->redirectToRoute('app_learner_index');
    }
    /**
     * Learner getOne
     */
    #[Route('/learner/{id}', name: 'app_learner_getOne')]
    public function getOne(Learner $learner): Response
    {


        return $this->render('learner/detail.html.twig', [
            'learner' => $learner,
        ]);
    }
    /**
     * Learner delete
     */
    #[Route('/learner/delete/{id}', name: 'app_learner_delete')]
    public function delete(Learner $learner, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($learner);
        $entityManager->flush();

        return $this->redirectToRoute('app_learner_index');
    }
}
