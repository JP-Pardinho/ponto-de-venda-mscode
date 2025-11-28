<?php

namespace App\Controller\Usuario\Salvar;

use App\Entity\Usuario;
use App\Exception\Usuario\SenhaObrigatoriaException;
use App\Form\UsuarioType;
use App\Service\Usuario\UsuarioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public function __construct(
        private UsuarioService $usuarioService,
    ) {
    }

    #[Route('/usuarios/salvar', name: 'salvar_usuario', methods:['GET', 'POST'])]
    public function salvar(Request $request): Response
    {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario, [
            'is_edit' => false,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $plainPassword = $form->get('plainPassword')->getData();
                
                $this->usuarioService->criar($usuario, $plainPassword);
                $this->addFlash('success', 'Usuário cadastrado com sucesso!');
                
                return $this->redirectToRoute('listar_usuarios');

            } catch (SenhaObrigatoriaException $e) {
                $this->addFlash('danger', $e->getMessage());
            } catch (\Exception $e) {
                $this->addFlash('danger', 'Erro ao criar usuário: ' . $e->getMessage());
            }
        }
        
        return $this->render('usuario/new.html.twig', [
            'form' => $form,
        ]);
    }
}
