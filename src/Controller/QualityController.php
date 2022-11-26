<?php

namespace App\Controller;

use App\Entity\Quality;
use App\Form\QualityType;
use App\Repository\QualityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quality')]
class QualityController extends AbstractController
{
    #[Route('/', name: 'app_quality_index', methods: ['GET'])]
    public function index(QualityRepository $qualityRepository): Response
    {
        return $this->render('quality/index.html.twig', [
            'qualities' => $qualityRepository->findAll(),
        ]);
    }

    #[Route('/quality/new', name: 'app_quality_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QualityRepository $qualityRepository): Response
    {
        $quality = new Quality();
        $form = $this->createForm(QualityType::class, $quality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $qualityRepository->save($quality, true);

            return $this->redirectToRoute('app_quality_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quality/new.html.twig', [
            'quality' => $quality,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quality_show', methods: ['GET'])]
    public function show(Quality $quality): Response
    {
        return $this->render('quality/show.html.twig', [
            'quality' => $quality,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quality_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quality $quality, QualityRepository $qualityRepository): Response
    {
        $form = $this->createForm(QualityType::class, $quality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quality->setUpdatedAt(new \DateTimeImmutable());
            $qualityRepository->save($quality, true);

            return $this->redirectToRoute('app_quality_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quality/edit.html.twig', [
            'quality' => $quality,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quality_delete', methods: ['POST'])]
    public function delete(Request $request, Quality $quality, QualityRepository $qualityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quality->getId(), $request->request->get('_token'))) {
            $qualityRepository->remove($quality, true);
        }

        return $this->redirectToRoute('app_quality_index', [], Response::HTTP_SEE_OTHER);
    }
}
