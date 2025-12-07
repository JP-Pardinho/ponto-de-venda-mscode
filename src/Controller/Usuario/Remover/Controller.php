<?php

namespace App\Controller\Usuario\Remover;

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

    #[Route('/usuarios/remover/{usuario}', name: 'remover_usuario')]
    public function remover(Usuario $usuario): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', 'Acesso negado. Área restrita a administradores.');
            return $this->render('erro/erro.html.twig', [
                'erro' => Response::HTTP_FORBIDDEN
            ]);
        }

        $this->usuarioService->inativar($usuario);
        $this->addFlash('success', 'Usuário removido com sucesso!');

        return $this->redirectToRoute('listar_usuarios');
    }
}
