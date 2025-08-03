<?php

namespace App\Controller;

use App\Entity\Veterinario;
use App\Form\VeterinarioType;
use App\Repository\VeterinarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/veterinario')]
final class VeterinarioController extends AbstractController
{
    #[Route(name: 'app_veterinario_index', methods: ['GET'])]
    public function index(
        VeterinarioRepository $veterinarioRepository,
        PaginatorInterface $paginator, Request $request
    ): Response{

        $veterinarios = $veterinarioRepository->findAll();

        $pagination = $paginator->paginate(
            $veterinarios,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render('veterinario/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/novo', name: 'app_veterinario_novo', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $veterinario = new Veterinario();
        $form = $this->createForm(VeterinarioType::class, $veterinario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($veterinario);
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veterinario/new.html.twig', [
            'veterinario' => $veterinario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_veterinario_show', methods: ['GET'])]
    public function show(Veterinario $veterinario): Response
    {
        return $this->render('veterinario/show.html.twig', [
            'veterinario' => $veterinario,
        ]);
    }

    #[Route('/{id}/editar', name: 'app_veterinario_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Veterinario $veterinario, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VeterinarioType::class, $veterinario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veterinario/edit.html.twig', [
            'veterinario' => $veterinario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_veterinario_delete', methods: ['POST'])]
    public function delete(Request $request, Veterinario $veterinario, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$veterinario->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($veterinario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_veterinario_index', [], Response::HTTP_SEE_OTHER);
    }
}
