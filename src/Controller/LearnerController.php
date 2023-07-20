<?php

namespace App\Controller;

use App\DTO\LearnerSearchCriteria;
use App\Entity\Learner;
use App\Entity\Prom;
use App\Entity\Skill;
use App\Form\LearnerSearchCriteriaType;
use App\Form\LearnerType;
use App\Repository\LearnerRepository;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
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
    #[Route('/learner/prom/{prom}', name: 'app_learner_indexFiltered')]
    public function indexFiltered(Prom $prom = null, LearnerRepository $learnerRepository): Response
    {
        $learners = $learnerRepository->findByProm($prom);
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
     * Learner delete
     */
    #[Route('/learner/delete/{id}', name: 'app_learner_delete')]
    public function delete(Learner $learner, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($learner);
        $entityManager->flush();

        return $this->redirectToRoute('app_learner_index');
    }


    #[Route('/learner/group/{id}', name: 'app_learner_generate')]
    public function generate(Prom $prom, Request $request, LearnerRepository $learnerRepository): Response
    {
        $form = $this->createForm(LearnerSearchCriteriaType::class, null, ['method' => 'GET',]);
        $form->handleRequest($request);

        $searchCriteria = $form->getData();
        /**
         * @var LearnerSearchCriteria  $searchCriteria
         */
        $length = $searchCriteria->size;
        $isMixite = $searchCriteria->genre;
        $isAge = $searchCriteria->age;

        //search all learner and sort by LearnerSearchCriteria::class
        $learners = $learnerRepository->findLearnerByUsersPromOrberBySearchCriteria($prom,  $searchCriteria);
        dump($learners);
        $groups = array_chunk($learners,  $length);

        if ($isMixite) {
            $groups = array_chunk($learners,  (int)(count($learners) / $length) + 1);
            $learnerInGroup = [];
            $groupsLearners = [];
            for ($i = 0; $i < count($groups[0]); $i++) { // group[0] length
                foreach ($groups as  $key => $group) {
                    if (isset($group[$i])) {
                        $learnerInGroup[$key] = $group[$i];
                    }
                }
                array_push($groupsLearners, $learnerInGroup);
            }
            $groups = $groupsLearners;
        }
        if ($isAge) {
            $groups = array_chunk($learners,  (int)(count($learners) / $length));
            $learnersinGroup = [];
            for ($i = 0; $i < count($groups[0]); $i++) { // group[0] length
                foreach ($groups as  $key => $value) {
                    if (isset($value[$i])) {
                        array_push($learnersinGroup, $value[$i]);
                    }
                }
            }
            $groups = array_chunk($learnersinGroup,  $length);
        }

        return $this->render('learner/group.html.twig', [
            'prom' => $prom,
            'count' => count($learners),
            'form' => $form->createView(),
            'groups' => $groups,
        ]);
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
}
