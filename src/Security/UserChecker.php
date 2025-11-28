<?php

namespace App\Security;

use App\Entity\Usuario;
use App\Service\Usuario\UsuarioService;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    public function __construct(
        private UsuarioService $usuarioService
    ) {
    }

    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof Usuario) {
            return;
        }

        $this->usuarioService->verificaStatusUsuario($user);
    }

    public function checkPostAuth(UserInterface $user): void
    {

    }
}