<?php

namespace App\Controller;

use App\Entity\Fazenda;
use App\Form\FazendaType;
use App\Repository\FazendaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/fazenda')]
final class FazendaController extends AbstractController
{
    #[Route(name: 'app_fazenda_index', methods: ['GET'])]
    public function index(FazendaRepository $fazendaRepository): Response
    {
        return $this->render('fazenda/index.html.twig', [
            'fazendas' => $fazendaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_fazenda_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fazenda = new Fazenda();
        $form = $this->createForm(FazendaType::class, $fazenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fazenda);
            $entityManager->flush();

            return $this->redirectToRoute('app_fazenda_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fazenda/new.html.twig', [
            'fazenda' => $fazenda,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fazenda_show', methods: ['GET'])]
    public function show(Fazenda $fazenda): Response
    {
        return $this->render('fazenda/show.html.twig', [
            'fazenda' => $fazenda,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fazenda_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fazenda $fazenda, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FazendaType::class, $fazenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_fazenda_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fazenda/edit.html.twig', [
            'fazenda' => $fazenda,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fazenda_delete', methods: ['POST'])]
    public function delete(Request $request, Fazenda $fazenda, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fazenda->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($fazenda);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_fazenda_index', [], Response::HTTP_SEE_OTHER);
    }
}
