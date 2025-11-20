<?php

namespace App\Controller\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): RedirectResponse
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app');
        }

        return $this->redirectToRoute('app_login');
    }
}
