<?php

namespace App\Controller\Usuario\Editar;

use App\Entity\Usuario;
use App\Form\UsuarioType;
use App\Service\Usuario\UsuarioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private UsuarioService $usuarioService
    ) {
    }

    #[Route('/usuarios/editar/{usuario}', name: 'editar_usuario', methods:['GET', 'POST'])]
    public function editar(Usuario $usuario, Request $request): Response
    {
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->usuarioService->editar($usuario);
            $this->addFlash('success', 'Usuario editado com sucesso!');

            return $this->redirectToRoute('listar_usuarios');
        }
        
        return $this->render('usuario/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form,
        ]);
    }
}
