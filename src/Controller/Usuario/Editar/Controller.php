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
        $form = $this->createForm(UsuarioType::class, $usuario, [
            'is_edit' => true,
        ]);
    
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();

            $this->usuarioService->editar($usuario, $plainPassword);
            $this->addFlash('success', 'Usuário atualizado com sucesso!');
            return $this->redirectToRoute('listar_usuarios');
        }

        return $this->render('usuario/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form,
        ]);
    }
}
