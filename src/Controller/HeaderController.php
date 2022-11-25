<?php

namespace App\Controller;

use App\Entity\Header;
use App\Form\HeaderType;
use App\Repository\HeaderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HeaderController extends AbstractController
{
    #[Route('/header', name: 'app_header')]
    public function index(): Response
    {
        return $this->render('header/index.html.twig', [
            'controller_name' => 'HeaderController',
        ]);
    }

    #[Route('/header/create', name: 'app_header_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager, HeaderRepository $repos): Response
    {
        $header = new Header();
        
        $form = $this->createForm(HeaderType::class,  $header);

        
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        
        if(count($repos->findAll()) > 0){
            $repos->deleteAllHeader();
            $manager->persist($form->getData());        
          }else{
                    $manager->persist($form->getData());   
          }
        
     
       
   
        $manager->flush();
        return $this->redirectToRoute('app_home');
    }

        return $this->render('pages/header/new.html.twig',['form'=> $form->createView()]);
    }
}
