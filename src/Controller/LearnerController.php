<?php

namespace App\Controller;

use App\DTO\LearnerSearchCriteria;
use App\Entity\Learner;
use App\Entity\Prom;
use App\Form\LearnerSearchCriteriaType;
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
        //search all learner and sort by gender
        $learners = $learnerRepository->findBy(['prom' => $prom], ['gender' => 'ASC']);
        //sear and count female
        $learnersF = $learnerRepository->findBy(['prom' => $prom, 'gender' => 'f'], ['gender' => 'ASC']);
        $learnersFCount = count($learnersF);


        $form = $this->createForm(LearnerSearchCriteriaType::class, null, ['method' => 'GET',]);
        $form->handleRequest($request);

        // source https://www.php.net/manual/fr/ref.array.php
        function array_move_elem($array, $from, $to)
        {
            if ($from == $to) {
                return $array;
            }
            $c = count($array);
            if (($c > $from) and ($c > $to)) {
                if ($from < $to) {
                    $f = $array[$from];
                    for ($i = $from; $i < $to; $i++) {
                        $array[$i] = $array[$i + 1];
                    }
                    $array[$to] = $f;
                } else {
                    $f = $array[$from];
                    for ($i = $from; $i > $to; $i--) {
                        $array[$i] = $array[$i - 1];
                    }
                    $array[$to] = $f;
                }
            }
            return $array;
        }
        //
        $length = $form['size']->getData();
        $mixite = $form['genre']->getData();


        //deplace woman  
        $toPos = count($learners) - 1;
        $grpTemp = array_chunk($learners,  $length);
        $groupsCount = count($grpTemp);

        $actualgroupId = $groupsCount - 1;
        $womanInGroup = 0;
        if ($mixite) {
            //determine le nombre de femme ENTIERE par groupe
            if ($learnersFCount % $groupsCount == 0) {
                $calcNbWomanInGrp = ((int)$learnersFCount / $groupsCount);
            } else {
                $calcNbWomanInGrp = ((int)$learnersFCount / $groupsCount) - 1;
            }
            if ($calcNbWomanInGrp <= 0) {
                $calcNbWomanInGrp = 0;
            }
            for ($i = $learnersFCount - 1; $i > 0; $i--) {
                //le nombre de femme est< au nombre de groupe
                if ($toPos > 1 && $calcNbWomanInGrp >= $womanInGroup) {
                    $learners = array_move_elem($learners, $i, $toPos);
                    $womanInGroup = $womanInGroup + 1;
                }

                if ($calcNbWomanInGrp > $womanInGroup) {
                    $toPos = $toPos -  1;
                } else {
                    $toPos = $toPos  -  (count($grpTemp[$actualgroupId]) - $calcNbWomanInGrp);
                    $womanInGroup = 0;
                    $actualgroupId = $actualgroupId - 1;
                }
            };
        }


        $groups = array_chunk($learners,  $length);
        // if (!$form->isSubmitted() || !$form->isValid()) {
        return $this->render('learner/group.html.twig', [
            'prom' => $prom,
            'count' => count($learners),
            'form' => $form->createView(),
            'learners' => $learners,
            'groups' => $groups,
        ]);






        /*   $learners = $learnerRepository->findAll();

        return $this->render('learner/group.html.twig', [
            'learners' => $learners,
        ]); */
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
