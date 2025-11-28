<?php

namespace App\Controller\Usuario\Ver;

use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class Controller extends AbstractController
{
    public const ROUTE_NAME = 'ver_usuario'; 

    #[Route('/usuarios/{id}', name: self::ROUTE_NAME, methods:'GET')]
    public function read(Usuario $usuario): Response
    {
        /** @var Usuario $usuarioLogado */
        $usuarioLogado = $this->getUser();

        if (!$this->isGranted('ROLE_ADMIN') && $usuarioLogado->getId() !== $usuario->getId()) {
            $this->addFlash('danger', 'Acesso negado. Área restrita a administradores.');
            return $this->render('erro/erro.html.twig', [
                'erro' => '401'
            ]);
        }

        return $this->render('usuario/read.html.twig', [
            'usuario' => $usuario,
        ]);
    }
}
