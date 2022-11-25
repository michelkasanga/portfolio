<?php

namespace App\Controller;

use App\Entity\About;
use App\Form\AboutType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/about', name: 'app_about')]
    public function index(): Response
    {
        return $this->render('about/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }

    #[Route('/about/create', name: 'app_about_create')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $about = new About();
        $form = $this->createForm(AboutType::class, $about);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
           $manager->persist($form->getData()) ;
           $manager->flush();

            
        }
        return $this->render('pages/about/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
