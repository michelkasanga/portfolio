<?php

namespace App\Controller;

use App\Entity\ClientsSay;
use App\Form\ClientsSayType;
use App\Repository\ClientsSayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/clients/say')]
class ClientsSayController extends AbstractController
{
    #[Route('/', name: 'app_clients_say_index', methods: ['GET'])]
    public function index(ClientsSayRepository $clientsSayRepository): Response
    {
        return $this->render('pages/clients_say/index.html.twig', [
            'clients_says' => $clientsSayRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_clients_say_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClientsSayRepository $clientsSayRepository): Response
    {
        $clientsSay = new ClientsSay();
        $form = $this->createForm(ClientsSayType::class, $clientsSay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientsSayRepository->save($clientsSay, true);

            return $this->redirectToRoute('app_clients_say_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/clients_say/new.html.twig', [
            'clients_say' => $clientsSay,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_clients_say_show', methods: ['GET'])]
    public function show(ClientsSay $clientsSay): Response
    {
        return $this->render('pages/clients_say/show.html.twig', [
            'clients_say' => $clientsSay,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_clients_say_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClientsSay $clientsSay, ClientsSayRepository $clientsSayRepository): Response
    {
        $form = $this->createForm(ClientsSayType::class, $clientsSay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientsSayRepository->save($clientsSay, true);

            return $this->redirectToRoute('app_clients_say_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/clients_say/edit.html.twig', [
            'clients_say' => $clientsSay,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_clients_say_delete', methods: ['POST'])]
    public function delete(Request $request, ClientsSay $clientsSay, ClientsSayRepository $clientsSayRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clientsSay->getId(), $request->request->get('_token'))) {
            $clientsSayRepository->remove($clientsSay, true);
        }

        return $this->redirectToRoute('app_clients_say_index', [], Response::HTTP_SEE_OTHER);
    }
}
