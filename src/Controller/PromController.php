<?php

namespace App\Controller;

use App\Entity\Prom;
use App\Form\PromType;
use App\Repository\PromRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PromController extends AbstractController
{
    #[Route('/prom', name: 'app_prom_index')]
    public function index(PromRepository $promRepository): Response
    {
        {
            $proms = $promRepository->findAll();
    
            return $this->render('prom/prom.html.twig', [
                'proms' => $proms,
            ]);
        }
    }
    

    #[IsGranted('ROLE_USER')]
    #[Route('/prom/prom', name: 'app_prom_create')]
    public function createProm(Request $request, EntityManagerInterface $entityManager): Response
    {
        $prom = new Prom;

        $form = $this->createForm(PromType::class, $prom);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('prom/createProm.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        $prom = $form->getData();

    
        $entityManager->persist($prom);
        $entityManager->flush();

        return $this->redirectToRoute('app_prom_index');
    }
}
