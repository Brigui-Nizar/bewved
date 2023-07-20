<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Entity\SkillGroup;
use App\Form\SkillGroupType;
use App\Form\SkillType;
use App\Repository\SkillGroupRepository;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
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

    /**
     * create skill by SkillGroupId
     */
    #[Route('/skill/create/{id}', name: 'app_skill_createWithId')]
    public function createWithId(SkillGroup $skillGroup, Request $request, EntityManagerInterface $entityManager): Response
    {
        $skill = new Skill;
        $skill->setSkillGroup($skillGroup);

        $form = $this->createForm(SkillType::class, $skill);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('skill/createSkill.html.twig', [
                'form' => $form->createView(),
                'skillGroup' => $skillGroup
            ]);
        }
        $skill = $form->getData();
        // $skill->setSkillGroup();


        $entityManager->persist($skill);
        $entityManager->flush();

        return $this->redirectToRoute('app_skill_index');
    }

    /**
     * create skill
     */
    #[Route('/skill/create', name: 'app_skill_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $skill = new Skill;

        $form = $this->createForm(SkillType::class, $skill);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('skill/createSkill.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        $skill = $form->getData();


        $entityManager->persist($skill);
        $entityManager->flush();

        return $this->redirectToRoute('app_skill_index');
    }


    /**
     * create skillGroup
     */
    #[Route('/skill/createSkillGroup', name: 'app_skill_createSkillGroup')]
    public function createSkillGroup(Request $request, EntityManagerInterface $entityManager): Response
    {
        $skillGroup = new SkillGroup;

        $form = $this->createForm(SkillGroupType::class, $skillGroup);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('skill/createSkillGroup.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        $skillGroup = $form->getData();


        $entityManager->persist($skillGroup);
        $entityManager->flush();

        return $this->redirectToRoute('app_skill_createWithId', ['id' => $skillGroup->getId()]);
    }

    /**
     * former delete
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/skill/delete/{id}', name: 'app_skill_delete')]
    public function delete(Skill $skill, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($skill);
        $entityManager->flush();

        return $this->redirectToRoute('app_skill_index');
    }
}
