<?php

namespace App\Controller\Usuario\Reativar;

use App\Entity\Usuario;
use App\Service\Usuario\UsuarioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private UsuarioService $usuarioService
    ) {
    }

    #[Route('/usuarios/reativar/{usuario}', name: 'reativar_usuario', methods:'POST')]
    public function reativar(Usuario $usuario): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', 'Acesso negado. Área restrita a administradores.');
            return $this->render('erro/erro.html.twig', [
                'erro' => Response::HTTP_FORBIDDEN
            ]);
        }
        $this->usuarioService->reativar($usuario);
        $this->addFlash('success', 'Usuário reativado com sucesso!');

        return $this->redirectToRoute('listar_usuarios');
    }
}
