<?php

namespace App\Controller\Usuario\Listar;

use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class Controller extends AbstractController
{   
    public const ROUTE_NAME = 'listar_usuarios';
    
    public function __construct(
        private UsuarioRepository $usuarioRepository
    ) {  
    }
        
    #[Route('/usuarios', name: self::ROUTE_NAME, methods:'GET')]
    public function show(): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', 'Acesso negado. Área restrita a administradores.');
            return $this->render('erro/erro.html.twig', [
                'erro' => '401'
            ]);
        }

        return $this->render('usuario/index.html.twig', [
            'usuarios' => $this->usuarioRepository->findAll()
        ]);
    }
}
