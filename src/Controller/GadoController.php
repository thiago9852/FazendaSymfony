<?php

namespace App\Controller;

use App\Entity\Gado;
use App\Form\GadoType;
use App\Repository\GadoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/gado')]
final class GadoController extends AbstractController
{
    #[Route(name: 'app_gado_index', methods: ['GET'])]
    public function index(
        GadoRepository $gadoRepository,
        Request $request,
        PaginatorInterface $paginator
    ): Response {

        $gados = $gadoRepository->findBy(['id' => 'DESC']);
        $pagination = $paginator->paginate(
            $gados,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render('gado/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_gado_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gado = new Gado();
        $form = $this->createForm(GadoType::class, $gado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($gado);
            $entityManager->flush();

            return $this->redirectToRoute('app_gado_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gado/new.html.twig', [
            'gado' => $gado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gado_show', methods: ['GET'])]
    public function show(Gado $gado): Response
    {
        return $this->render('gado/show.html.twig', [
            'gado' => $gado,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gado_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gado $gado, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GadoType::class, $gado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_gado_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gado/edit.html.twig', [
            'gado' => $gado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gado_delete', methods: ['POST'])]
    public function delete(Request $request, Gado $gado, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gado->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($gado);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_gado_index', [], Response::HTTP_SEE_OTHER);
    }
}
