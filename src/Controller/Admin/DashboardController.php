<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Entity\Blog;
use App\Entity\ClientsSay;
use App\Entity\Header;
use App\Entity\Quality;
use App\Entity\QualityContent;
use App\Entity\Service;
use App\Entity\Skills;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('pages/admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Portfolio');
    }

    public function configureMenuItems(): iterable
    {
        return[
                    MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
                    MenuItem::subMenu('Entity', 'fa fa-sliders')->setSubItems([
                            MenuItem::linkToCrud('En-tete', 'fas fa-hashtag', Header::class),
                            MenuItem::linkToCrud('A propos', 'fas fa-user', About::class),
                            MenuItem::linkToCrud('Competence', 'fas fa-graduation-cap', QualityContent::class),
                            MenuItem::linkToCrud('Quality', 'fas fa-shield-halved', Quality::class),
                            MenuItem::linkToCrud('Evaluation', 'fas fa-pen-to-square', Skills::class),
                            MenuItem::linkToCrud('Realisation', 'fas fa-images', Blog::class),
                            MenuItem::linkToCrud('Clients', 'fas fa-message', ClientsSay::class),
                            MenuItem::linkToCrud('Service', 'fas fa-briefcase', Service::class),
                    ]),
        ];
        
    }
}
