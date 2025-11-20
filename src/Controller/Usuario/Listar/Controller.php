<?php

namespace App\Controller\Usuario\Listar;

use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
        return $this->render('usuario/index.html.twig', [
            'usuarios' => $this->usuarioRepository->findAll()
        ]);
    }
}
