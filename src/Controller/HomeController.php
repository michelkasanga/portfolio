<?php

namespace App\Controller;

use App\Repository\AboutRepository;
use App\Repository\BlogRepository;
use App\Repository\ClientsSayRepository;
use App\Repository\HeaderRepository;
use App\Repository\QualityContentRepository;
use App\Repository\QualityRepository;
use App\Repository\ServiceRepository;
use App\Repository\SkillsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HeaderRepository $header, 
                                          ClientsSayRepository $clients_say,
                                          SkillsRepository $skills,
                                          AboutRepository $abouts,
                                          QualityContentRepository $qualitycontent,
                                          QualityRepository $quality,
                                          BlogRepository $blog,
                                          ServiceRepository $service): Response
    {

        return $this->render('pages/index.html.twig',[
            'headers' => $header->findAll(),
            'clients_say' => $clients_say->findAll(),
            'skills' => $skills->findAll(),
            'abouts' => $abouts->findAll(),
            'qualityContent' => $qualitycontent->findAll(),
            'qualities' => $quality->findAll(),
            'blogs' => $blog->findAll(),
            'services' => $service->findAll()
        ]);
    }
}
