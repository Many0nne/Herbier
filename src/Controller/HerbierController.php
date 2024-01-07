<?php

namespace App\Controller;

use App\Entity\Herbier;
use App\Form\HerbierType;
use App\Repository\HerbierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/herbier')]
class HerbierController extends AbstractController
{
    #[Route('/', name: 'app_herbier_index', methods: ['GET'])]
    public function index(HerbierRepository $herbierRepository): Response
    {
        $herbiers = $herbierRepository->findAll();

        $herbierData = [];

        foreach ($herbiers as $herbier) {
            
            $releve = $herbier->getReleve();

            $table = $herbier->generateTable();

            $herbierData[] = [
                'herbier' => $herbier,
                'releve' => $releve,
                'table' => $table,
            ];
        }

        return $this->render('herbier/index.html.twig', [
            'herbierData' => $herbierData,
        ]);
    }

    #[Route('/new', name: 'app_herbier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $herbier = new Herbier();
        $form = $this->createForm(HerbierType::class, $herbier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($herbier);
            $entityManager->flush();

            return $this->redirectToRoute('app_herbier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('herbier/new.html.twig', [
            'herbier' => $herbier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_herbier_show', methods: ['GET'])]
    public function show(Herbier $herbier): Response
    {
        return $this->render('herbier/show.html.twig', [
            'herbier' => $herbier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_herbier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Herbier $herbier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HerbierType::class, $herbier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_herbier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('herbier/edit.html.twig', [
            'herbier' => $herbier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_herbier_delete', methods: ['POST'])]
    public function delete(Request $request, Herbier $herbier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$herbier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($herbier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_herbier_index', [], Response::HTTP_SEE_OTHER);
    }
}
