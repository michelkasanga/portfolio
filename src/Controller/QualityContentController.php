<?php

namespace App\Controller;

use App\Entity\QualityContent;
use App\Form\QualityContentType;
use App\Repository\QualityContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quality/content')]
class QualityContentController extends AbstractController
{
    #[Route('/', name: 'app_quality_content_index', methods: ['GET'])]
    public function index(QualityContentRepository $qualityContentRepository): Response
    {
        return $this->render('quality_content/index.html.twig', [
            'quality_contents' => $qualityContentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_quality_content_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QualityContentRepository $qualityContentRepository): Response
    {
        $qualityContent = new QualityContent();
        $form = $this->createForm(QualityContentType::class, $qualityContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $qualityContentRepository->save($qualityContent, true);

            return $this->redirectToRoute('app_quality_content_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quality_content/new.html.twig', [
            'quality_content' => $qualityContent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quality_content_show', methods: ['GET'])]
    public function show(QualityContent $qualityContent): Response
    {
        return $this->render('quality_content/show.html.twig', [
            'quality_content' => $qualityContent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quality_content_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, QualityContent $qualityContent, QualityContentRepository $qualityContentRepository): Response
    {
        $form = $this->createForm(QualityContentType::class, $qualityContent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $qualityContentRepository->save($qualityContent, true);

            return $this->redirectToRoute('app_quality_content_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quality_content/edit.html.twig', [
            'quality_content' => $qualityContent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quality_content_delete', methods: ['POST'])]
    public function delete(Request $request, QualityContent $qualityContent, QualityContentRepository $qualityContentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$qualityContent->getId(), $request->request->get('_token'))) {
            $qualityContentRepository->remove($qualityContent, true);
        }

        return $this->redirectToRoute('app_quality_content_index', [], Response::HTTP_SEE_OTHER);
    }
}
