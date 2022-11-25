<?php

namespace App\Controller;

use App\Entity\Header;
use App\Repository\HeaderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HeaderRepository $header, EntityManagerInterface $manager): Response
    {

        return $this->render('pages/index.html.twig',[
            'headers' => $header->findAll()
        ]);
    }
}
