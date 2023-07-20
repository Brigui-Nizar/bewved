<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class FormerController extends AbstractController
{
    #[Route('/former', name: 'app_former_index')]
    public function index(UserRepository $userRepository): Response
    {
        $formers = $userRepository->findAll();

        return $this->render('former/former.html.twig', [
            'formers' => $formers,
        ]);
    }

    /**
     * create former
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/former/create', name: 'app_former_create')]
    public function create(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
    {
        $former = new User;

        $form = $this->createForm(UserType::class, $former);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('former/createformer.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        $former = $form->getData();

        $former->setPassword(
            $hasher->hashPassword(
                $former,
                $former->getPassword()
            )
        );
        $former->setRoles(['ROLE_USER']);
        $entityManager->persist($former);
        $entityManager->flush();

        return $this->redirectToRoute('app_former_index');
    }

    /**
     * former delete
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/former/delete/{id}', name: 'app_former_delete')]
    public function delete(User $user, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_former_index');
    }
}
